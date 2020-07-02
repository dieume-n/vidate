<template>
    <div>
        <video
            id="my-video"
            class="video-js vjs-theme-fantasy vjs-16-9"
            controls
            preload="auto"
            poster="thumbnailUrl"
            fuild="true"
        ></video>
    </div>
</template>	

<script>
import videojs from "video.js";
import resolveUrl from "@videojs/vhs-utils/dist/resolve-url";
import qualityLevels from "videojs-contrib-quality-levels";
import hlsQualitySelector from "videojs-hls-quality-selector";
require("videojs-hls-quality-selector");

export default {
    props: ["videoUid", "videoUrl", "thumbnailUrl"],
    data() {
        return {
            player: null
        };
    },
    mounted() {
        // videojs.registerPlugin("hls", Hls);
        this.player = videojs("my-video", {
            html5: {
                vhs: {
                    overrideNative: true,
                    withCredentials: false
                },
                nativeAudioTracks: false,
                nativeVideoTracks: false,
                smoothQualityChange: true
            }
        });
        let qualityLevels = this.player.qualityLevels();

        // disable quality levels with less than 720 horizontal lines of resolution when added
        // to the list.
        qualityLevels.on("addqualitylevel", function(event) {
            let qualityLevel = event.qualityLevel;

            if (qualityLevel.height >= 720) {
                qualityLevel.enabled = true;
            } else {
                qualityLevel.enabled = false;
            }
        });
        // this.player.hlsQualitySelector({
        //     displayCurrentQuality: true
        // });
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