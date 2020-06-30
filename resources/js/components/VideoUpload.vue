<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Upload</div>

          <div class="card-body">
            <input
              type="file"
              name="video"
              id="video"
              @change="fileInputChange"
              v-if="!uploading"
              accept="video/mp4, video/x-m4v, video/*"
            />

            <div
              class="alert alert-danger"
              role="alert"
              v-if="failed"
            >Something went wrong, please try again</div>

            <div id="video-form" v-if="uploading && !failed">
              <div class="alert alert-info" role="alert" v-if="!uploadComplete">
                Your video will be available at
                <a
                  :href="video_link"
                  target="_blank"
                >{{ video_link }}</a>
              </div>

              <div class="alert alert-success" role="alert" v-if="uploadComplete">
                Upload complete. your video is now processing.
                <a href="/videos">Go to your videos</a>
              </div>

              <div class="progress mb-3" v-if="!uploadComplete">
                <div
                  class="progress-bar"
                  v-bind:style="{ width: fileProgress + '%' }"
                  role="progressbar"
                  aria-valuemax="100"
                ></div>
              </div>

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
  props: ["url"],
  data() {
    return {
      uid: null,
      uploading: false,
      uploadComplete: false,
      failed: false,
      title: "Untitled",
      description: null,
      visibility: "private",
      saveStatus: null,
      fileProgress: 0
    };
  },
  computed: {
    video_link: function() {
      return `${this.url}/videos/${this.uid}`;
    }
  },
  methods: {
    fileInputChange() {
      this.uploading = true;
      this.failed = false;

      this.file = document.getElementById("video").files[0];

      // Store metadata
      this.store()
        .then(() => {
          let form = new FormData();
          form.append("video", this.file);
          form.append("uid", this.uid);

          axios
            .post("/upload", form, {
              onUploadProgress: e => {
                if (e.lengthComputable) {
                  this.updateProgress(e);
                }
              }
            })
            .then(response => {
              this.uploadComplete = true;
            })
            .catch(error => {
              this.failed = true;
            });
        })
        .catch(error => {
          this.failed = true;
        });

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
    },
    updateProgress(e) {
      e.percent = (e.loaded / e.total) * 100;
      this.fileProgress = e.percent;
    }
  },
  mounted() {
    window.onbeforeunload = () => {
      if (this.uploading && !this.uploadComplete && !this.failed) {
        return "Are you sure you want to navigate away?";
      }
    };
  }
};
</script>