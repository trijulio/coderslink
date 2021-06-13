<template>
    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Image Galery and upload on VueJS / Laravel</div>

                    <div class="card-body">
                        <form @submit="formSubmit" enctype="multipart/form-data">
                            <input type="file" class="form-control mb-2" ref="file" v-on:change="onChange" :disabled="working" accept="image/png, image/gif, image/jpeg">
                            <small class="form-text text-right">Max File size: 2MB, Available types:JPEG/JPG/PNG/GIF</small>
                            <button class="btn btn-success btn-block" :disabled="working || !file">Upload</button>

                            <div
                              class="progress-bar progress-bar-info progress-bar-striped"
                              role="progressbar"
                              :aria-valuenow="uploadPercentage"
                              aria-valuemin="0"
                              aria-valuemax="100"
                              :style="{ width: uploadPercentage + '%', 'background-color': barcolor }"
                            >
                              {{ uploadPercentage }}%
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="alert alert-danger" v-if="error">
            {{ error }}
        </div>
        <h5 class="display-6 mt-4 mb-3">Images Uploaded in this sesion</h5>
        <div v-if="!images.length" class="alert alert-info">No images added yet, please upload images first.</div>
        <div class="row text-center text-lg-left">
            <div class="col-lg-3 col-md-4 col-6" v-for="image in images">
              <a v-bind:href="image" class="d-block mb-4 h-100" target="_blank">
                    <img v-bind:src="image" class="img-fluid" />
                  </a>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                images: [],
                file: null,
                error: null,
                uploadPercentage: 0,
                working: false
            };
        },
        computed: {
            barcolor: function () {
              if(this.uploadPercentage == 100)
                return '#7ed7a4';
              return '#3490dc';
            }
          },
        methods: {
            finished(){ // Process the form after the request has been completly finished
                this.working = false;
                this.uploadPercentage = 100;
            },
            insertImage(imageUrl){
                this.images.unshift(imageUrl);
            },
            onChange(e) {
                this.file = e.target.files[0];

                if(this.file['type'] !== 'image/jpeg' && this.file['type'] !== 'image/jpg' && this.file['type'] !=='image/png' && this.file['type'] !=='image/gif'){
                    this.error = 'File must be an image type jpeg/jpg/png/gif';
                    this.resetForm();
                }
            },
            resetForm(){
                this.$refs.file.value=null;
                this.file = null;
            },
            formSubmit(e) {
                e.preventDefault();

                let data = new FormData();
                data.append('image', this.file);

                //Reset and block form
                this.resetForm();
                this.error = null;
                this.working = true;
                this.uploadPercentage = 0;

                const config = {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function( progressEvent ) {
                          this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 )) - 1;
                        }.bind(this)
                }

                axios.post('/api/upload', data, config)
                    .then((res) => {
                        if(res.data.status == 'success'){
                            this.insertImage(res.data.data.image);
                        }

                        if(res.data.status == 'error'){
                            this.error = res.data.error;
                        }
                        this.finished();

                    }).catch((err) => {
                        this.error = err;
                        this.finished();
                    });
            }
        }
    }

</script>