
<div class="profile-photo-update position-relative pointer">
    <div class="photo">
        <?php if (login()->photoUrl) { ?>
            <img :src=" userProfilePhotoUrl " />
        <?php } else { ?>
            <i class="fa fa-user"></i>
        <?php } ?>
    </div>

    <div><?=ek('Upload photo', '사진 업로드')?></div>

    <input class="cover pointer fs-lg opacity-0" type="file" v-on:change="onUserProfilePhotoChange($event)">
</div>
<div>
    {{ userProfilePhotoUploadPercentage }}
</div>

<style>
    .profile-photo-update .photo {
        width: 100px;
        height: 100px;
        overflow: hidden;
    }
    .profile-photo-update img {
        width: 100%;
    }
</style>
<script>
    later(function() {
        app.userProfilePhotoUrl = '<?=login()->photoUrl?>';
    });
</script>
<?php js(HOME_URL . 'etc/js/vue-js-mixins/user-profile-photo-upload.js');?>