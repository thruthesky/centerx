<section class="m-5">
    <form action="./">
        <input type="hidden" name="p" value="user.profile.submit">
        <div class="form-group">
            <label>Name</label>
            <div>
                <?php if ( login()->provider == 'passlogin' ) { ?>
                    <?=login()->name?>
                <?php } else { ?>
                    본인 인증을 하지 않아 이름을 알 수 없습니다.
                <?php } ?>
            </div>
        </div>
        <div class="form-group">
            <label>Phone No</label>
            <div>
                <?php if ( login()->provider == 'passlogin' ) { ?>
                    <?=login()->phoneNo?>
                <?php } else { ?>
                    본인 인증을 하지 않아 전화번호를 알 수 없습니다.
                <?php } ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Profile Update</button>
    </form>
</section>
