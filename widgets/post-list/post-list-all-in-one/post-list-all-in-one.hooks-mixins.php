<?php

hook()->add(HOOK_POST_CREATE_BUTTON_ATTR, function() {
    return '@click.prevent="onClickPostCreate"';
});

hook()->add(HOOK_POST_EDIT_RETURN_URL, function() {
    return 'list';
});
hook()->add(HOOK_POST_EDIT_CANCEL_BUTTON_ATTR, function() {
    return '@click.prevent="onClickPostEditFormCancel"';
});

?>
<script>
    mixins.push({
        data: {
            showPostForm: false,
        },
        methods: {
            onClickPostCreate: function() {
                this.showPostForm = !this.showPostForm;
            },
            onClickPostEditFormCancel: function() {
                this.showPostForm = false;
            }
        }
    })
</script>