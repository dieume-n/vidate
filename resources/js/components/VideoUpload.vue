<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Upload</div>

          <div class="card-body">
            <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading" />
            <div id="video-form" v-if="uploading && !failed">
              <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" v-model="title" />
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  name="description"
                  id="description"
                  cols="30"
                  rows="5"
                  class="form-control"
                  v-model="description"
                ></textarea>
              </div>
              <div class="form-group">
                <label for="visibility">Visibility</label>
                <select class="form-control" v-model="visibility">
                  <option value="private">Private</option>
                  <option value="public">Public</option>
                  <option value="unlisted">Unlisted</option>
                </select>
              </div>
              <div class="d-flex justify-content-between">
                <button class="btn btn-primary" @click.prevent="update">Save Changes</button>
                <span class="form-text text-muted pull-right">{{ saveStatus }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      uid: null,
      uploading: false,
      uploadComplete: false,
      failed: false,
      title: "Untitled",
      description: null,
      visibility: "private",
      saveStatus: null
    };
  },
  methods: {
    fileInputChange() {
      this.uploading = true;
      this.failed = false;

      this.file = document.getElementById("video").files[0];

      // Store metadata
      this.store().then(() => {});

      // Upload video
    },
    store() {
      return axios
        .post("/videos", {
          title: this.title,
          description: this.description,
          visibility: this.visibility,
          extension: this.file.name.split(".").pop()
        })
        .then(response => {
          this.uid = response.data.data.uid;
        });
    },
    update() {
      this.saveStatus = "Saving changes...";

      return axios
        .put(`/videos/${this.uid}`, {
          title: this.title,
          description: this.description,
          visibility: this.visibility
        })
        .then(response => {
          this.saveStatus = "Changes saved";
          setTimeout(() => {
            this.saveStatus = null;
          }, 3000);
        })
        .catch(error => {
          this.saveStatus = "Failed to save changes";
        });
    }
  }
};
</script>