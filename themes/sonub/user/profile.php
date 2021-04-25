<section class="m-5">
    <form action="/" method="post">
        <?=hiddens(p: 'user.profile.submit', return_url: '/?user.profile')?>

        <div class="list-tile form-group">
            <label for="profile-nickname" class="caption">닉네임</label>
            <input name="nickname" type="text" class="form-control" id="register-nickname" aria-describedby="Input nickname" value="<?=login()->nickname?>">
            <small id="emailHelp" class="form-text text-muted">닉네임(별명)을 입력해주세요.</small>
        </div>


        <div class="list-tile">
            <div class="caption">로그인 방식</div>
            <div class="text"><?=login()->provider?></div>
        </div>

        <div class="list-tile form-group">
            <label class="caption">Name</label>
            <div class="text">
                <?php if ( login()->verified ) { ?>
                    <?=login()->name?>
                <?php } else { ?>
                    본인 인증을 하지 않아 이름을 알 수 없습니다.
                <?php } ?>
            </div>
            <div class="trailing">
                <a href="#">본인 인증하기</a>
            </div>
        </div>
        <div class="list-tile form-group">
            <label class="caption">Phone No</label>
            <div class="text">
                <?php if ( login()->verified ) { ?>
                    <?=login()->phoneNo?>
                <?php } else { ?>
                    본인 인증을 하지 않아 전화번호를 알 수 없습니다.
                <?php } ?>
            </div>
            <div class="trailing">
                <a href="#">본인 인증하기</a>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Profile Update</button>
    </form>
</section>
