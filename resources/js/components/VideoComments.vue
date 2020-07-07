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
            <ul class="list-unstyled d-block">
                <li class="media" v-for="(comment, index) in comments" :key="index">
                    <a :href="comment.channel.link" target="_blank">
                        <vue-avatar
                            :username="comment.channel.name"
                            :scr="comment.channel.image"
                            :border-radius="5"
                            class="mr-3 text-white"
                        ></vue-avatar>
                    </a>

                    <div class="media-body">
                        <ul class="list-inline my-0">
                            <li class="list-inline-item">
                                <a :href="comment.channel.link">
                                    <h5 class="mt-0 mb-1">
                                        {{comment.channel.name }} &nbsp;
                                        <small class="text-muted">
                                            <i class="far fa-clock"></i>
                                            &nbsp;{{ comment.created_at|fromNow }}
                                        </small>
                                    </h5>
                                </a>
                            </li>
                            <li class="list-inline-item" v-if="$root.user.id === comment.user_id">
                                <a
                                    href="#"
                                    @click.prevent="deleteComment(comment.id)"
                                    class="text-danger"
                                >Delete</a>
                            </li>
                        </ul>
                        <p>{{ comment.body }}</p>

                        <ul class="list-inline my-0">
                            <li class="list-inline-item" v-if="$root.user.authenticated">
                                <a
                                    href="#"
                                    @click.prevent="toggleReplyForm(comment.id)"
                                >{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply'}}</a>
                            </li>
                        </ul>

                        <div class="my-3" v-if="replyFormVisible === comment.id ">
                            <textarea v-model="replyBody" class="form-control"></textarea>
                            <button
                                class="float-right d-block btn btn-outline-info mt-2"
                                @click.prevent="createReply(comment.id)"
                            >Reply</button>
                        </div>

                        <!-- Show replies -->
                        <div v-if="comment.replies.length != 0" class="mt-3">
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
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a :href="reply.channel.link">
                                                <h5 class="mt-0 mb-1">
                                                    {{reply.channel.name }} &nbsp;
                                                    <small
                                                        class="text-muted"
                                                    >
                                                        <i class="far fa-clock"></i>
                                                        &nbsp;{{ reply.created_at|fromNow }}
                                                    </small>
                                                </h5>
                                            </a>
                                        </li>
                                        <li
                                            class="list-inline-item"
                                            v-if="$root.user.id === reply.user_id"
                                        >
                                            <a
                                                href="#"
                                                @click.prevent="deleteComment(reply.id)"
                                                class="text-danger"
                                            >Delete</a>
                                        </li>
                                    </ul>
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
            body: null,
            replyBody: null,
            replyFormVisible: null
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
        },
        toggleReplyForm(commentId) {
            this.replyBody = null;

            if (this.replyFormVisible === commentId) {
                this.replyFormVisible = null;
                return;
            }

            this.replyFormVisible = commentId;
        },

        createReply(commentId) {
            axios
                .post(`/videos/${this.videoUid}/comments`, {
                    body: this.replyBody,
                    reply_id: commentId
                })
                .then(response => {
                    this.comments.map((comment, index) => {
                        if (comment.id === commentId) {
                            this.comments[index].replies.push(
                                response.data.data
                            );
                        }
                    });
                    this.replyBody = null;
                    this.replyFormVisible = null;
                });
        },
        deleteComment(commentId) {
            if (!confirm("Are you sure you want to delete this comment?")) {
                return;
            }
            this.deleteById(commentId);

            axios.delete(`/videos/${this.videoUid}/comments/${commentId}`);
        },
        deleteById(commentId) {
            this.comments.map((comment, index) => {
                if (comment.id === commentId) {
                    this.comments.splice(index, 1);
                    return;
                }

                comment.replies.map((reply, replyIndex) => {
                    if (reply.id === commentId) {
                        this.comments[index].replies.splice(replyIndex, 1);
                        return;
                    }
                });
            });
        }
    },
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