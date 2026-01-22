import React from "react";
import { Input } from "sulu-admin-bundle/components";
import styles from "./videoPreview.scss";

class VideoPreview extends React.Component {
  get videoProvider() {
    const { value } = this.props;

    if (value && (value.includes("youtube") || value.includes("youtu.be"))) {
      return "YouTube";
    }

    if (value && value.includes("vimeo")) {
      return "Vimeo";
    }

    if (value && value.includes("dailymotion")) {
      return "Dailymotion";
    }

    return "URL";
  }

  get isValidUrl() {
    const { value } = this.props;

    if (value === undefined || value.trim() === "") {
      return true;
    }

    const regex = new RegExp("^(https?|ftp)://[^s/$.?#].*$", "i");

    return regex.test(value);
  }

  get isIFrame() {
    const { value } = this.props;

    if (!value) {
      return false;
    }

    return (
      (this.isValidUrl && value !== "" && value.includes("youtube")) ||
      value.includes("vimeo") ||
      value.includes("youtu.be") ||
      value.includes("dailymotion")
    );
  }

  get isHTML5Video() {
    const { value } = this.props;

    if (!value || this.isIFrame) {
      return false;
    }

    return (
      (this.isValidUrl && value !== "" && value.includes(".mp4")) ||
      value.includes(".webm") ||
      value.includes(".ogv")
    );
  }

  get embedUrl() {
    const { value } = this.props;

    let embed_url = value || "";

    // Vimeo
    if (embed_url.includes("vimeo")) {
      embed_url = embed_url.replace("/vimeo.com", "/player.vimeo.com/video");
      embed_url += (embed_url.includes("?") ? "&" : "?") + "dnt=1";

      return embed_url;
    }

    // Dailymotion
    if (embed_url.includes("dailymotion.com")) {
      embed_url = embed_url.replace("dailymotion.com", "dailymotion.com/embed");

      return embed_url;
    }

    // YouTube
    if (embed_url.includes("youtube")) {
      embed_url = embed_url.replace("watch?v=", "embed/");
    }

    if (embed_url.includes("shorts/")) {
      // Shorts don't support "youtube-nocookie.com"
      embed_url = embed_url.replace("shorts/", "embed/");
      return embed_url;
    }

    if (embed_url.includes("youtu.be")) {
      embed_url = embed_url.replace("youtu.be", "www.youtube.com/embed");
    }

    if (embed_url.includes("youtube.com")) {
      embed_url = embed_url.replace("youtube.com", "youtube-nocookie.com");

      return embed_url;
    }

    return embed_url;
  }

  render() {
    return (
      <div>
        <div className={styles.inputContainer}>
          <span className={styles.prefix}>{this.videoProvider}</span>
          <Input
            {...this.props}
            valid={this.isValidUrl}
            onChange={this.props.onChange}
          />
        </div>
        <div className={styles.iframeWrapper}>
          {this.isIFrame && (
            <iframe
              src={this.embedUrl}
              className={styles.iframe}
              frameborder="0"
              allow="fullscreen"
            ></iframe>
          )}
          {this.isHTML5Video && (
            <video
              controls
              autoPlay={false}
              className={styles.iframe}
              src={this.embedUrl}
            ></video>
          )}
        </div>
      </div>
    );
  }
}

export default VideoPreview;
