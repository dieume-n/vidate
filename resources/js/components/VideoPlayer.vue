<template>
    <div>
        <video
            id="my-video"
            class="video-js vjs-theme-fantasy vjs-16-9"
            controls
            preload="auto"
            fuild
            liveui
        ></video>
    </div>
</template>	

<script>
import videojs from "video.js";
// import resolveUrl from "@videojs/vhs-utils/dist/resolve-url";
import qualityLevels from "videojs-contrib-quality-levels";
// import hlsQualitySelector from "videojs-hls-quality-selector";
require("videojs-hls-quality-selector");

export default {
    props: ["videoUid", "videoUrl", "posterUrl"],
    data() {
        return {
            player: null,
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
        this.player.hlsQualitySelector({
            displayCurrentQuality: true
        });
        this.player.src({
            src: this.videoUrl,
            type: "application/x-mpegURL",
            withCredentials: false
        });
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
    },
    created() {}
};
</script>

<style lang="stylus" scoped></style>