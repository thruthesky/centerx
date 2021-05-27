

Vue.component('comment-form', {
    props: ['rootIdx', 'parentIdx', 'commentIdx', 'textPhoto', 'textSubmit', 'textCancel'],
    data: function() {
        return {
            form: {
                p: 'forum.comment.edit.submit',
                rootIdx: this.rootIdx,
                content: this.comment ? this.comment.content : '',
                files: '', // a string of file idx(es)
            },
            percent: 0,
            uploadedFiles: [], // an array of file objects
            commenting: false,
        }
    },
    created: function() {
        if (this.commentIdx) {
            const self = this;
            request('comment.get', {
                idx: this.commentIdx
            }, function(res) {
                self.form.content = res.content;
                // self.form = res;
                self.uploadedFiles = res.files;
            }, alert);
        }
    },
    template: '<form class="mt-2 mb-0" v-on:submit.prevent="commentFormSubmit">' +
        '<input type="hidden" name="files" v-model="form.files">' +
        '<section class="d-flex">' +
        '   <div class="position-relative overflow-hidden" style="min-width: 32px">' +
        '       <img src="/etc/svg/camera.svg" class="camera-icon d-block" v-if=" !textPhoto " style="max-width: 32px;">' +
        '       <div class="mr-2 pt-1" type="button" v-if=" textPhoto ">{{ textPhoto }}</div>' +
        '       <input class="position-absolute top left right fs-lg opacity-0" type="file" v-on:change="onFileChange($event)">' +
        '   </div>' +
        '   <div class="w-100 d-flex">' +
        '     <textarea :rows="commentIdx || parentIdx !== rootIdx ? 3 : 1" class="form-control ml-2" v-model="form.content" @input="autoResize($event)" style="max-height: 250px;">' +
        '     </textarea>' +
        '       <div class="d-flex flex-column" v-if="!commenting && (form.content || uploadedFiles.length)">' +
        '         <button class="btn btn-primary ml-2" type="submit" v-if="!commenting">{{ textSubmit }}</button>' +
        '         <button class="btn btn-link ml-2" type="button" v-on:click="onCommentEditCancelButtonClick()" v-if="commentIdx || parentIdx !== rootIdx">{{ textCancel }}</button>' +
        '       </div>' +
        '       <div class="text-center" v-if="commenting"><b-spinner class="ml-2" variant="success" type="grow" label="Spinning"></b-spinner></div>' +
        '   </div>' +
        '</section>' +
        '   <progress-bar class="mt-2" :progress="percent"></progress-bar>' +
        '   <div class="mt-2 row photos" v-if="uploadedFiles.length">' +
        '       <div class="col-3 photo" v-for="file in uploadedFiles" :key="file.idx">' +
        '           <div clas="position-relative" style="height: 200px">' +
        '               <img class="h-100 w-100" :src="file.url" style="border-radius: 10px;">' +
        '               <div class="px-3 py-2 position-absolute top left font-weight-bold" v-on:click="onFileDelete(file.idx)" style="color: red">[X]</div>' +
        '           </div>' +
        '       </div>' +
        '   </div>' +
        '</div>' +
        '</form>',
    methods: {
        onFileChange: function(event) {
            if (event.target.files.length === 0) {
                console.log("User cancelled upload");
                return;
            }
            const file = event.target.files[0];
            const self = this;
            fileUpload(
                file, {},
                function(res) {
                    console.log("success: res.path: ", res, res.path);
                    self.form.files = addByComma(self.form.files, res.idx);
                    self.uploadedFiles.push(res);
                },
                alert,
                function(p) {
                    console.log("pregoress: ", p);
                    self.percent = p;
                }
            );
        },
        commentFormSubmit: function() {
            var route;
            if (this.commentIdx) {
                route = 'comment.update';
                this.form.idx = this.commentIdx;
            } else {
                route = 'comment.create';
                this.form.parentIdx = this.parentIdx;
            }

            console.log('form', this.form);

            this.commenting = true;
            request(route, this.form, function() {
                location.reload();
            }, alert);
        },
        onCommentEditCancelButtonClick: function() {
            console.log('onCommentEditCancelButtonClick', this.commentIdx);
            var idx = this.commentIdx;
            if (this.commentIdx === null 
                || this.commentIdx === '' 
                || typeof this.commentIdx === 'undefined'
                ) {
                idx = this.parentIdx;
            }
            console.log('onCommentEditCancelButtonClick', idx);

            this.$parent.displayCommentForm[idx] = '';
        },
        removeFileFromView: function(idx) {
            this.uploadedFiles = this.uploadedFiles.filter(function(v, i, ar) {
                return v.idx !== idx;
            });
            this.form.files = deleteByComma(this.form.files, idx);
        },
        onFileDelete: function(idx) {
            const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
            if (re === false) return;
            const self = this;
            request('file.delete', {
                idx: idx
            }, function(res) {
                self.removeFileFromView(idx);
            }, function(e) {
                if ( e === 'error_file_not_exists_in_db' || e === 'error_file_not_exists_in_disk' ) {
                    self.removeFileFromView(idx);
                    alert('File deleted. The file that was not actually exist in file system has now removed.');
                } else {
                    alert(e);
                }
            });
        },
        autoResize: function(event) {
            event.target.style.height = 'auto';
            event.target.style.height = event.target.scrollHeight + 'px';
        }
    }
});