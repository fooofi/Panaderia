import React, { Component } from "react";
import ReactDOM from "react-dom";
import moment, { relativeTimeThreshold } from "moment";
import "moment/locale/es";
moment().locale("es");

class ContactTable extends Component {
  constructor(props) {
    super(props);
    this.state = {
      chatEndpoint: "",
      dataEndpoint: "",
      contacts: [],
      csrfToken: "",
    };
    this.getData = this.getData.bind(this);
  }

  componentDidMount() {
    this.setState(
      {
        chatEndpoint: this.props.contacturl,
        dataEndpoint: this.props.dataurl,
        csrfToken: document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      this.getData
    );
    this.interval = setInterval(this.getData, 1000);
  }

  componentWillUnmount() {
    clearInterval(this.interval);
  }

  getData() {
    fetch(this.state.dataEndpoint)
      .then((res) => res.json())
      .then((results) => {
        const contacts = results.contacts.map((contact) => {
          return {
            id: contact.id,
            received: moment(contact.received),
            name: contact.name,
            preference: contact.career,
            origin: contact.origin,
            type: contact.type,
          };
        });

        this.setState({
          contacts: contacts,
        });
      })
      .catch((err) => console.log(err));
  }

  render() {
    const { contacts, chatEndpoint, csrfToken } = this.state;
    const contactList = contacts.map((contact) => (
      <tr key={contact.id}>
        <td>{contact.received.fromNow()}</td>
        <td>{contact.name}</td>
        <td>{contact.preference}</td>
        <td>{contact.origin}</td>
        <td>{contact.type}</td>
        <td>
          <form
            method="post"
            action={contact.type == "Chat" ? chatEndpoint : ""}
          >
            <input type="hidden" name="contact" value={contact.id} />
            <input type="hidden" name="_token" value={csrfToken} />
            <button type="submit" className="btn btn-block">
              <span className="cil-send btn-icon"></span>
            </button>
          </form>
        </td>
      </tr>
    ));
    return (
      <table className="table table-bordered table-hover">
        <thead>
          <tr>
            <th scope="col">Recibido</th>
            <th scope="col">Nombre</th>
            <th scope="col">Preferencia</th>
            <th scope="col">Origen</th>
            <th scope="col">Tipo</th>
            <th scope="col">Contactar</th>
          </tr>
        </thead>
        <tbody>{contactList}</tbody>
      </table>
    );
  }
}

export default ContactTable;

if (document.getElementById("contact-table")) {
  const element = document.getElementById("contact-table");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <ContactTable {...props} />,
    document.getElementById("contact-table")
  );
}
