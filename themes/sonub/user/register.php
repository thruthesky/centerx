
<h1>가입 및 로그인</h1>

* 참고: 이곳에 가입을 하시면 홈페이지를 올바로 이용 할 수 없습니다.

<h2>로그인</h2>
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

<h2>회원 가입</h2>
<section class="m-5">
    <form action="./">
        <input type="hidden" name="p" value="user.register.submit">
        <div class="form-group">
            <label>Email address</label>
            <input type="email" class="form-control" name="email" aria-describedby="Input email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label>Phone No</label>
            <input type="text" class="form-control" name="phoneNo">
        </div>
        <div class="form-group">
            <label>Your favorite color</label>
            <input type="text" class="form-control" name="color">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</section>