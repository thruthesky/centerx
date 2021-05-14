<section class="p-3">


    <div class="alert alert-info mb-5">
        어서오세요, <?=login()->nicknameOrName?>
    </div>

    <form>
        <input type="hidden" name="p" value="user.register.submit">
        <div class="form-group">
            <label>이메일</label>
            <input class="form-control" type="email" name="email" value="">
            <small class="form-text text-muted">이메일 주소를 입력하세요.</small>
        </div>
        <div class="form-group">
            <label>비밀번호</label>
            <input class="form-control" type="text" name="password" value="">
            <small class="form-text text-muted">비밀번호를 입력하세요.</small>
        </div>
        <input type="text" name="feeling" value="">

        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitch1">
            <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>
        </div>
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" disabled id="customSwitch2">
            <label class="custom-control-label" for="customSwitch2">Disabled switch element</label>
        </div>

        <button type="submit">회원가입</button>
    </form>


</section>