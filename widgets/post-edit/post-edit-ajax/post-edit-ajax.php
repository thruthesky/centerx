<?php
/**
 * @name Ajax post edit widget
 */

hook()->add(HOOK_POST_EDIT_FORM_ATTR, function() { return '@submit.prevent="onPostEditAjaxSubmit($event)"'; });
include widget('post-edit/post-edit-default');
?>
<script>
    mixins.push({
        methods: {
            onPostEditAjaxSubmit: function($event) {

                const data = serializeJSON($event.target);
                console.log('ajax forum submit!', data);

                if ( ! data.title.trim() ) return alert('앗, 제목을 입력하세요.');
                if ( ! data.content.trim() ) return alert('앗, 내용을 입력하세요.');

                self = this;
                self.loading = true;

                request('post.create', data, function(post) {
                    self.loading = false;
                    location.href = post.url;
                }, function(e) {
                    self.loading = false;
                    alert(e);
                });
            }
        }
    })
</script>
