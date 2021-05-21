/**
 * @file post-edit-form-file.js
 */
/**
 * Use this on every post(or any of wc_posts taxonomy) form for uploading and deleting(editing) files.
 */
mixins.push({
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
                    self.files = addByComma(self.files, res.idx);
                    self.uploadedFiles.push(res);
                    self.percent = 0;
                },
                function(e) {
                    console.error(e);
                    alert(e);
                },
                function(p) {
                    console.log("progress: ", p);
                    self.percent = p;
                }
            );
        },
        // Remove a file from the view(html)
        removeFileFromView: function(idx) {
            this.uploadedFiles = this.uploadedFiles.filter(function(v, i, ar) {
                return v.idx !== idx;
            });
            this.files = deleteByComma(this.files, idx);
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
        }
    }
});