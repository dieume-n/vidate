<template>
  <div>
    <video
      id="my-video"
      class="video-js vjs-big-play-centered vjs-16-9"
      controls
      poster
      preload="auto"
      fuild
    ></video>
  </div>
</template>	

<script>
import videojs from "video.js";
import qualityLevels from "videojs-contrib-quality-levels";

export default {
  props: ["videoUid", "videoUrl", "posterUrl"],
  data() {
    return {
      player: null,
      duration: null,
      options: {
        html5: {
          vhs: {
            overrideNative: true,
            withCredentials: false
          },
          nativeAudioTracks: false,
          nativeVideoTracks: false,
          smoothQualityChange: true
        },
        poster: this.posterUrl,
        playbackRates: [0.5, 1, 1.5, 2]
      }
    };
  },
  methods: {
    hasHiQuotaView() {
      if (!this.duration) {
        return false;
      }
      return (
        Math.round(this.player.currentTime()) ===
        Math.round((10 * this.duration) / 100)
      );
    },
    createView() {
      axios.post(`/videos/${this.videoUid}/views`);
    }
  },
  mounted() {
    this.player = videojs("my-video", {
      html5: {
        vhs: {
          overrideNative: true,
          withCredentials: false
        },
        nativeAudioTracks: false,
        nativeVideoTracks: false,
        smoothQualityChange: true
      },
      poster: this.posterUrl,
      playbackRates: [0.5, 1, 1.5, 2]
    });
    this.player.src({
      src: this.videoUrl,
      type: "application/x-mpegURL",
      withCredentials: false
    });
    this.player.on("loadedmetadata", () => {
      this.duration = Math.round(this.player.duration());
    });
    setInterval(() => {
      if (this.hasHiQuotaView()) {
        this.createView();
      }
    }, 1000);
  },
  beforeDestroy() {
    if (this.player) {
      this.player.dispose();
    }
  },
  created() {}
};
</script>
