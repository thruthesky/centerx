<section class="m-5">
    <form data-cy="register-form" @submit.prevent="onSubmitRegisterForm()" >
        <input type="hidden" name="p" value="user.register.submit">
        <div class="form-group">
            <label>이메일</label>
            <input data-cy="email-input" type="email" class="form-control" name="email" v-model="form.email" aria-describedby="Input email">
            <small id="emailHelp" class="form-text text-muted">이메일 주소를 입력해 주세요.</small>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input data-cy="password-input" type="password" class="form-control" name="password" v-model="form.password">
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


<script>
    mixins.push({
        data: {
            form: {
                email: '',
                password: '',
                name: '',
                phoneNo: '',
                color: ''
            }
        },
        methods: {
            onSubmitRegisterForm: function() {
request('user.register', this.form, function(user) {
    Cookies.set('sessionId', user.sessionId, {
        expires: 365,
        path: '/',
        domain: '<?=COOKIE_DOMAIN?>'
    });
}, alert);

            }
        }
    })
</script>