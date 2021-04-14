
Vue.component('upload-by-code', {
    props: ['postIdx', 'code', 'label', 'tip'],
    data: function() {
        return {
            percent: 0,
            file: {},
        }
    },
    created: function() {
        console.log('created for', this.postIdx, this.code);
        if ( this.postIdx ) {
            const self = this;
            request('file.byPostCode', {idx: this.postIdx, code: this.code}, function(res) {
                console.log('byPostCode: ', res);
                self.file = Object.assign({}, self.file, res);
            }, alert);
        }
    },
    template: '' +
        '<section class="form-group">' +
        '   <small class="form-text text-muted">{{tip}}</small>' +
        '   <label>{{label}}</label>' +
        '   <img class="mb-2 w-100" :src="file.url">' +
        '   <div>' +
        '       <input type="file" @change="onFileChange($event, \'banner\')">' +
        '   </div>' +
        '</section>',

    methods: {
        onFileChange: function (event) {
            if (event.target.files.length === 0) {
                console.log("User cancelled upload");
                return;
            }
            const file = event.target.files[0];
            const self = this;

            // 이전에 업로드된 사진이 있는가?
            if ( this.file.idx ) {
                // 그렇다면, 이전 업로드된 파일이 쓰레기로 남지 않도록 삭제한다.
                console.log('going to delete');
                request('file.delete', {idx: self.file.idx}, function(res) {
                    console.log('deleted: res: ', res);
                    self.$parent.$data.files = deleteByComma(self.$parent.$data.files, res.idx);
                }, alert);
            }

            // 새로운 사진을 업로드한다.
            fileUpload(
                file,
                {
                    code: self.code
                },
                function (res) {
                    // console.log("success: res.path: ", res, res.path, 'parent files: ', self.$parent.$data.files);
                    // debugger;
                    self.$parent.$data.files = addByComma(self.$parent.$data.files, res.idx);
                    self.file = res;
                },
                alert,
                function (p) {
                    console.log("("+self.code+")pregoress: ", p);
                    this.percent = p;
                }
            );
        },
    },
});


const app = new Vue({
    el: '#app',
    data: {},
    mixins: mixins
});
