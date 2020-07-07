<template>
  <div>
    <div class="card mt-2">
      <div class="card-header">{{ comments.length }} {{ comments.length | pluralize }}</div>
      <div class="card-body">
        <ul class="list-unstyled">
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
                <div class="media" v-for="(reply, index) in comment.replies" :key="index">
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
      comments: []
    };
  },
  methods: {
    getComments() {
      axios.get(`/videos/${this.videoUid}/comments`).then(res => {
        this.comments = res.data.data;
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