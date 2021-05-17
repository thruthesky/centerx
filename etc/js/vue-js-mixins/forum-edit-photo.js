
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
                alert,
                function(p) {
                    console.log("progress: ", p);
                    self.percent = p;
                }
            );
        },
        onFileDelete: function(idx) {
            const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
            if (re === false) return;
            const self = this;
            request('file.delete', {
                idx: idx
            }, function(res) {
                self.uploadedFiles = self.uploadedFiles.filter(function(v, i, ar) {
                    return v.idx !== res.idx;
                });
                self.files = deleteByComma(self.files, res.idx);
            }, alert);
        }
    }
});