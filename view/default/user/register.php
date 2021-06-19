<section class="m-5">
    <form data-cy="register-form" action="./">
        <input type="hidden" name="p" value="user.register.submit">
        <div class="form-group">
            <label>Email address</label>
            <input data-cy="email-input" type="email" class="form-control" name="email" aria-describedby="Input email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input data-cy="password-input" type="password" class="form-control" name="password">
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
        <button data-cy="submit-button" type="submit" class="btn btn-primary">Register</button>
    </form>
</section>