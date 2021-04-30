<section class="m-5">
    <form action="./">
        <input type="hidden" name="p" value="user.register.submit">
        <div class="form-group">
            <label><?= ek('Email Address', '@T Email Address') ?></label>
            <input type="email" class="form-control" name="email" aria-describedby="Input email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label><?= ek('Password', '@T Password') ?></label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label><?= ek('Name', '@T Name') ?></label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label><?= ek('Phone number', '@T Phone number') ?></label>
            <input type="text" class="form-control" name="phoneNo">
        </div>
        <div class="form-group">
            <label>Your favorite color</label>
            <input type="text" class="form-control" name="color">
        </div>
        <button type="submit" class="btn btn-primary"><?= ek('Register', '@T Register') ?></button>
    </form>
</section>