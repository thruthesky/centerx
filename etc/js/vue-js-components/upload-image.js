/**
 * 첨부 사진을 taxonomy, entity, code 별로 보여주고, 삭제하고, 변경하고 등의 작업을 한다.
 * 주의, 기존에 존재하는 사진을 삭제한다. 즉, 게시판 처럼 무제한으로 사진을 올리고자 할 때 사용하지는 못하며,
 * taxonomy, entity, code 별로 사진을 하나만 유지하고자 할 때 사용 할 수 있다.
 *
 * 글, 코멘트, 쇼핑몰, 회원 사진, 카테고리 별 사진 등 모든 경우에 다 사용가능하다.
 *
 *
 * 참고, wc_posts 테이블의 글에 사진을 추가하는 경우,
 *  taxonomy 는 'posts' 가 되어야 하고, entity 는 해당 글의 idx 이어야 하는데, 글 작성시에는 0 의 값일 수 있다.
 *  글 작성시에는 이전의 사진을 지울 때, 글 번호(idx)가 없는 상태이므로, 이전에 업로드된 사진 중 taxonomy, code 는 같으나 글 번호가 0 인 사진을 지운다.
 *  즉, 의미없는 것이다.
 *  글이 작성되고 수정 할 때에는 실제 idx 값을 가지는데, 그 때에는 이전에 등록된 사진을 삭제한다.
 *
 * 주의, taxonomy, entity, code 는 3개 모두 다 입력이 안되어도 된다. 하지만 입력을 안하거나 몇 개만 입력하는 경우, 원하지 않는 파일이 표시되는 경우가 있다.
 *
 * @prop taxonomy - 이 값이 'posts' 이면, 최 상위 Vue.instance 의 data 중 'files' 속성에
 *  업로드 한 파일의 idx 를 추가하고,
 *  삭제한 파일의 idx 를 뺀다.
 *  즉, 게시판 글에 사진/파일을 업로드 할 때, 비록 이전 파일을 삭제하지만, 마찬가지로 idx 를 빼거나 추가를 해 주어야 한다.
 *
 * @fix 2021. 05. 21. 이전에는 게시글에 한정되었는데, taxonomy, entity 를 추가로 입력 받아, 어떤 곳이든 사용가능하도록 한다.
 *
 * @see readme
 */
Vue.component('upload-image', {
    props: ['taxonomy', 'entity', 'code'],
    data: function() {
        return {
            percent: 0,
            file: {},
            confirmDelete: '',
        }
    },
    created: function() {
        console.log('created for;', this.taxonomy, this.entity, this.code);
        const self = this;
        request('file.get', {taxonomy: this.taxonomy, entity: this.entity, code: this.code}, function(res) {
            self.file = Object.assign({}, self.file, res);
        }, function(e) {
            if ( e === 'error_entity_not_found' ) {
            } else {
                alert(e);
            }
        });

        request('translation.get', {'code': 'confirm_delete'}, function(res) { self.confirmDelete = res.text; }, alert);
    },
    template: '' +
        '<section class="upload-image">' +
        '   <div class="uploaded-image d-inline-block" style="position: relative">' +
        '       <img :src="file.url" v-if="file.url">' +
        '       <div class="close-button" @click="onClickDeleteImage" v-if="file.idx" style="position: absolute; display: flex; width: 24px;  align-items: center; justify-content: center; bottom: 6px; right: 6px; height: 24px; background-color: red; color: white; border-radius: 50%; cursor: pointer; font-weight: bold; font-size: 18px;"><div>&#x00D7</div></div>' +
        '   </div>' +
        '   <div class="upload-button">' +
        '       <input type="file" @change="onFileChangeImage($event, \'banner\')">' +
        '   </div>' +
        '</section>',

    methods: {
        deleteImage: function() {
            const self = this;
            request('file.delete', {idx: self.file.idx}, function(res) {
                console.log('deleted: res: ', res);
                if ( self.taxonomy === 'posts' ) {
                    self.$parent.$data.files = deleteByComma(self.$parent.$data.files, res.idx);
                }
                self.file = {};
            }, alert);
        },
        onClickDeleteImage: function() {
            const re = confirm( this.confirmDelete );
            this.deleteImage();
        },
        onFileChangeImage: function (event) {
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
                this.deleteImage();
            }

            // 새로운 사진을 업로드한다.
            fileUpload(
                file,
                {
                    taxonomy: self.taxonomy,
                    entity: self.entity,
                    code: self.code
                },
                function (res) {
                    // console.log("success: res.path: ", res, res.path, 'parent files: ', self.$parent.$data.files);
                    // debugger;
                    if ( self.taxonomy === 'posts' ) {
                        self.$parent.$data.files = addByComma(self.$parent.$data.files, res.idx);
                    }
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