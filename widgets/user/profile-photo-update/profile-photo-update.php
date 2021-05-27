<?php
/**
 * @size narrow
 * @description user photo upload
 */

$o = getWidgetOptions();
$text = $o['text'] ?? null;

?>
    <div class="profile-photo-update position-relative d-inline-block pointer overflow-hidden">

        <div class="photo position-relative">
            <div class="circle bg-light">
                <img class="cover circle" :src=" userProfilePhotoUrl " v-if="userProfilePhotoUrl"/>
                <i class="fas fa-user-circle fs-xxl" v-if=" ! userProfilePhotoUrl "></i>
            </div>
            <i class="fas fa-camera fs-lg position-absolute bottom p-1"></i>
        </div>

        <?php if ($text) { ?>
        <div><?=ln('upload_photo')?></div>
        <?php } ?>

        <input class="cover pointer opacity-0" type="file" v-on:change="onUserProfilePhotoChange($event)">

        <progress-bar class="fs-xxs" :progress="userProfilePhotoUploadPercentage"></progress-bar>
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
            app.trLoginFirst = "<?=ln('login_first')?>";
        });
    </script>
<?php js(HOME_URL . 'etc/js/vue-js-mixins/user-profile-photo-upload.js');?>
<?php js('/etc/js/vue-js-components/progress-bar.js')?>
