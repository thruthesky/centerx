<div class="box">

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">패스 휴대폰번호 로그인</a>

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">카카오톡 로그인</a>

    <a class="btn btn-warning" href="<?=passLoginUrl('openHome')?>">네이버 로그인</a>

    <section class="m-5">
        <form action="./">
            <input type="hidden" name="p" value="user.login.submit">
            <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" name="email" aria-describedby="Input email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </section>
</div>