<template>
  <div>
    <ul class="list-inline">
      <li class="list-inline-item">
        <a href="#" :class="{ 'disabled' : !canVote}">
          <i class="fas fa-thumbs-up" v-if="userVote == 'up'"></i>
          <i class="far fa-thumbs-up" v-else></i>
        </a>
        {{ up}}
      </li>&nbsp;
      <li class="list-inline-item">
        <a href="#" :class="{ 'disabled' : !canVote }">
          <i class="fas fa-thumbs-down" v-if="userVote == 'down'"></i>
          <i class="far fa-thumbs-down" v-else></i>
        </a>
        {{ down}}
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: ["videoUid"],
  data() {
    return {
      up: null,
      down: null,
      userVote: null,
      canVote: false
    };
  },
  methods: {
    vote() {}
  },
  mounted() {
    axios.get(`/videos/${this.videoUid}/votes`).then(response => {
      this.up = response.data.data.up;
      this.down = response.data.data.down;
      this.canVote = response.data.data.can_vote;
      this.userVote = response.data.data.user_vote;
    });
  }
};
</script>
<style scoped>
a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>