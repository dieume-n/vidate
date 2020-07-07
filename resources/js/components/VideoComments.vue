<template>
    <div>
        <div class="card card-body mt-3">
            <div>{{ comments.length }} {{ comments.length | pluralize }}</div>
            <div class="my-3" v-if="$root.user.authenticated">
                <textarea v-model="body" class="form-control" placeholder="Say something..."></textarea>
                <button
                    class="float-right btn btn-outline-info mt-2"
                    @click.prevent="createComment"
                >Post</button>
            </div>
            <ul class="list-unstyled mt-4">
                <li class="media mb-3" v-for="(comment, index) in comments" :key="index">
                    <a :href="comment.channel.link" target="_blank">
                        <vue-avatar
                            :username="comment.channel.name"
                            :scr="comment.channel.image"
                            :border-radius="5"
                            class="mr-3 text-white"
                        ></vue-avatar>
                    </a>

                    <div class="media-body">
                        <a :href="comment.channel.link">
                            <h5 class="mt-0 mb-1">
                                {{comment.channel.name }} &nbsp;
                                <small class="text-muted">
                                    <i class="far fa-clock"></i>
                                    &nbsp;{{ comment.created_at|fromNow }}
                                </small>
                            </h5>
                        </a>
                        <p>{{ comment.body }}</p>
                        <div v-if="comment.replies.length != 0">
                            <div
                                class="media"
                                v-for="(reply, index) in comment.replies"
                                :key="index"
                            >
                                <a :href="reply.channel.link" target="_blank">
                                    <vue-avatar
                                        :username="reply.channel.name"
                                        :scr="reply.channel.image"
                                        :border-radius="5"
                                        class="mr-3 text-white"
                                    ></vue-avatar>
                                </a>
                                <div class="media-body">
                                    <a :href="reply.channel.link">
                                        <h5 class="mt-0 mb-1">
                                            {{reply.channel.name }} &nbsp;
                                            <small class="text-muted">
                                                <i class="far fa-clock"></i>
                                                &nbsp;{{ reply.created_at|fromNow }}
                                            </small>
                                        </h5>
                                    </a>
                                    <p>{{ reply.body }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import VueAvatar from "@lossendae/vue-avatar";
export default {
    props: ["videoUid"],
    components: {
        VueAvatar
    },
    data() {
        return {
            comments: [],
            body: null
        };
    },
    methods: {
        getComments() {
            axios.get(`/videos/${this.videoUid}/comments`).then(response => {
                this.comments = response.data.data;
            });
        },
        createComment() {
            axios
                .post(`/videos/${this.videoUid}/comments`, {
                    body: this.body
                })
                .then(response => {
                    this.comments.unshift(response.data.data);
                    this.body = null;
                });
        }
    },
    created() {},
    mounted() {
        this.getComments();
    }
};
</script>
<style scoped>
a:hover {
    text-decoration: none;
}
</style>