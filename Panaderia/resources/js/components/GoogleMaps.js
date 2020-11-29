import React, { Component } from "react";
import ReactDOM from "react-dom";
import { Map, GoogleApiWrapper, Marker } from "google-maps-react";

class GoogleMaps extends Component {
  constructor(props) {
    super(props);
    this.state = {
      lat: "",
      lng: "",
      name: "",
    };
  }

  componentDidMount() {
    this.setState({
      lat: parseFloat(this.props.lat),
      lng: parseFloat(this.props.lon),
      name: this.props.name,
    });
  }

  render() {
    const { lat, lng, name } = this.state;
    const position = {
      lat: lat,
      lng: lng,
    };
    return (
      <div style={{ width: "100%", height: "40vh", position: "relative" }}>
        <Map
          google={this.props.google}
          zoom={15}
          initialCenter={position}
          center={position}
        >
          <Marker name={name} title={name} position={position} />
        </Map>
      </div>
    );
  }
}
GoogleMaps = GoogleApiWrapper({
  apiKey: process.env.MIX_GOOGLE_API_KEY,
})(GoogleMaps);
export default GoogleMaps;

if (document.getElementById("google-maps")) {
  const element = document.getElementById("google-maps");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <GoogleMaps {...props} />,
    document.getElementById("google-maps")
  );
}
