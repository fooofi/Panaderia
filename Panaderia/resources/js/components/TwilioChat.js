import React, { Component } from "react";
import ReactDOM from "react-dom";
import Chat from "twilio-chat";
import moment from "moment";
import "moment/locale/es";
moment().locale("es");

class TwilioChat extends Component {
  constructor(props) {
    super(props);
    this.state = {
      token: "",
      identity: "",
      channels: [],
      current: "",
      messages: [],
      newMessage: "",
    };
  }

  componentDidMount() {
    this.setState(
      {
        token: this.props.token,
        identity: this.props.identity,
      },
      this.initChat
    );

    this.interval = setInterval(this.getChannels, 5000);
  }

  componentWillUnmount() {
    clearInterval(this.interval);
  }

  initChat = () => {
    this.chatClient = new Chat(this.state.token);
    this.identityParser = new RegExp("^(.+)-" + this.state.identity + "$");
    this.chatClient.initialize().then(this.getChannels.bind(this));
  };

  getChannels = () => {
    this.chatClient.getSubscribedChannels().then((channels) => {
      const promises = [];
      channels.items.map((channel) => {
        const uniqueName = channel.uniqueName;
        var lastMessage = undefined;
        var unread = 0;
        if (channel.lastMessage != undefined) {
          lastMessage = moment(channel.lastMessage.dateCreated);
          unread = channel.lastMessage.index - channel.lastConsumedMessageIndex;
        }
        const identity = this.identityParser.exec(uniqueName)[1];
        promises.push(
          channel
            .getMemberByIdentity(identity)
            .then((member) => member.getUser())
            .then((user) => {
              return {
                user: user.friendlyName,
                name: uniqueName,
                last: lastMessage,
                unread: unread,
              };
            })
        );
      });
      Promise.all(promises).then((channelList) => {
        channelList.sort((a, b) => moment(a.last).diff(b.last));
        this.setState({
          channels: channelList,
        });
      });
    });
  };

  selectChannel = (channel) => {
    this.setState(
      {
        current: channel,
        messages: [],
        message: "",
      },
      this.getChannelMessages
    );
  };

  getChannelMessages = () => {
    this.chatClient
      .getChannelByUniqueName(this.state.current)
      .then((channel) => {
        this.channel = channel;
        window.channel = channel;
        return this.channel;
      })
      .then((channel) => {
        Promise.all([
          channel.getMessages().then((messages) => {
            return messages.items.map((message) => this.formatMessage(message));
          }),
        ])
          .then((messageList) => {
            messageList = messageList[0];
            if (messageList.length > 0) {
              this.setState({ messages: messageList });
              this.channel.updateLastConsumedMessageIndex(
                messageList[messageList.length - 1].index
              );
            }
          })
          .then(this.channel.on("messageAdded", this.messageAdded));
      });
    this.lastMessage.scrollIntoView({ behavior: "smooth" });
  };

  messageAdded = (message) => {
    this.setState((prevState, props) => ({
      messages: [...prevState.messages, this.formatMessage(message)],
    }));
    this.channel.updateLastConsumedMessageIndex(message.index);
    this.lastMessage.scrollIntoView({ behavior: "smooth" });
  };
  onMessageChanged = (event) => {
    this.setState({
      newMessage: event.target.value,
    });
  };

  sendMessage = (event) => {
    event.preventDefault();
    const message = this.state.newMessage;
    this.setState({
      newMessage: "",
    });
    this.channel.sendMessage(message);
  };

  formatMessage = (message) => {
    return {
      from: message.author,
      body: message.body,
      date: moment(message.dateCreated).format("MMM D, HH:mm"),
      index: message.index,
      key: message.channel.entityName + "-" + message.index,
    };
  };
  render() {
    const { channels, current, newMessage, messages } = this.state;
    const channelList = channels.map((channel) => {
      let unread = "";
      let lastMessage = "";
      let lastColor = "text-muted";
      if (channel.unread) {
        unread = (
          <span className="badge rounded-pill bg-primary text-white">
            {channel.unread}
          </span>
        );
      }
      if (channel.name == current) {
        lastColor = "text-white";
      }
      if (channel.last != undefined) {
        lastMessage = (
          <small className={"float-left " + lastColor}>
            Ultimo mensaje: {channel.last.format("MMM D, HH:mm")}
          </small>
        );
      }
      return (
        <button
          className={
            "list-group-item " + (current == channel.name ? " active" : "")
          }
          key={channel.name}
          type="button"
          onClick={() => this.selectChannel(channel.name)}
        >
          <div className="d-flex w-100 justify-content-between">
            {channel.user}
            {unread}
          </div>
          {lastMessage}
        </button>
      );
    });
    const messageList = messages.map((mes) => {
      let position = "justify-content-start";
      let color = "bg-light";
      let bodyTextColor = "";
      let bodySmallColor = "text-muted";
      if (mes.from == this.state.identity) {
        position = "justify-content-end";
        color = "bg-primary";
        bodyTextColor = " text-white";
        bodySmallColor = "text-white";
      }
      return (
        <div className={"row " + position} key={mes.key}>
          <div className={"card mx-1 " + color} style={{ maxWidth: "45%" }}>
            <div className={"card-text mx-2" + bodyTextColor}>{mes.body}</div>
            <small className={"card-text text-right mx-1 " + bodySmallColor}>
              {mes.date}
            </small>
          </div>
        </div>
      );
    });
    const channelsStyle = {
      marginLeft: "-1.3rem",
      marginTop: "-1.3rem",
      maxHeight: "55vh",
    };
    return (
      <div className="card">
        <div className="card-header text-value-lg">Mensajes</div>
        <div className="card-body">
          <div className="row">
            <div className="col-md-4 d-flex">
              <div
                className="list-group list-group-flush flex-grow-1 justify-content-start overflow-auto"
                style={channelsStyle}
              >
                {channelList}
              </div>

              <div
                className="justify-content-end"
                style={{
                  height: "100%",
                  width: "1px",
                  background: "#bdc0c6",
                  display: "inline-block",
                  marginTop: channelsStyle.marginTop,
                }}
              />
            </div>
            <div className="col-md-8">
              <div
                className="row overflow-auto"
                style={{ maxHeight: "55vh", minHeight: "55vh" }}
              >
                <div className="col-md-12">
                  {messageList}
                  <div
                    ref={(lm) => {
                      this.lastMessage = lm;
                    }}
                  />
                </div>
              </div>

              <div className="row">
                <div className="col-md-12">
                  <div className="card bg-light flex-grow-1">
                    <form className="form-inline" onSubmit={this.sendMessage}>
                      <div className="input-group w-100 m-1">
                        <input
                          className="form-control"
                          type="text"
                          name="message"
                          id="message"
                          onChange={this.onMessageChanged}
                          value={newMessage}
                        />
                        <div className="input-group-append">
                          <button
                            className="btn btn-block cil-send"
                            type="submit"
                          ></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default TwilioChat;

if (document.getElementById("twilio-chat")) {
  const element = document.getElementById("twilio-chat");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <TwilioChat {...props} />,
    document.getElementById("twilio-chat")
  );
}
