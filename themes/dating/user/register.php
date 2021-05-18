<section class="m-5">

    <form @submit.prevent="onSubmitRegisterForm()">
        <!--    <input type="hidden" name="p" value="/">-->
        <div class="form-group">
            <label for="inputEmail1">이메일</label>
            <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" v-model="form.email">
            <div style="color: red">{{form.errorMessage.email}}</div>
        </div>
        <div class="form-group">
            <label for="inputPassword1">패스워드</label>
            <input type="password" class="form-control" id="inputPassword1" v-model="form.password">
            <div style="color: red">{{form.errorMessage.password}}</div>

        </div>
        <div class="form-group">
            <label for="inputPassword2">패스워드 확인</label>
            <input type="password" class="form-control" id="inputPassword2" v-model="form.password2">
            <div style="color: red">{{form.errorMessage.password2}}</div>
        </div>
        <div class="form-group">
            <label for="inputName">이름</label>
            <input type="text" class="form-control" id="inputName" v-model="form.name">
            <div style="color: red">{{form.errorMessage.name}}</div>

        </div>
        <div class="form-group">
            <label for="inputBirthday">생년월일</label>
            <input type="text" class="form-control" id="inputBirthday" v-model="form.birthday">
            <div style="color: red">{{form.errorMessage.birthday}}</div>

        </div>
        <div class="form-group">
            <label for="inputGender">성별</label>
            <input type="text" class="form-control" id="inputGender" v-model="form.gender">
            <div style="color: red">{{form.errorMessage.gender}}</div>

        </div>
        <div class="form-group">
            <label for="inputAddress">지역</label>
            <input type="text" class="form-control" id="inputAddress" v-model="form.address">
            <div style="color: red">{{form.errorMessage.address}}</div>

        </div>
        <button type="submit" class="btn btn-primary">가입하기</button>
    </form>
</section>
<script>
    mixins.push({
        data: {
            form: {
                email: '',
                password: '',
                password2: '',
                name: '',
                birthday: '',
                gender: '',
                address: '',
                errorMessage: {
                    email: '',
                    password: '',
                    password2: '',
                    name: '',
                    birthday: '',
                    gender: '',
                    address: '',
                },
            },
            // errorMessage: {
            //     email: '',
            //     password: '',
            //     password2: '',
            //     name: '',
            //     birthday: '',
            //     gender: '',
            //     address: '',
            // }

        },
        methods: {
            onSubmitRegisterForm: function () {
                this.form.errorMessage.email = '';
                this.form.errorMessage.password = '';
                this.form.errorMessage.password2 = '';
                this.form.errorMessage.password = '';
                this.form.errorMessage.name = '';
                this.form.errorMessage.birthday = '';
                this.form.errorMessage.gender = '';
                this.form.errorMessage.address = '';

                // if (this.form.email === '') return this.errorMessage.email = '이메일을 입력해 주세요.';
                if (this.form.email === '') return this.form.errorMessage.email = '이메일을 입력해 주세요.';
                if (this.form.password === '') return this.form.errorMessage.password = '비밀번호를 입력해 주세요.';
                if (this.form.password2 === '') return this.form.errorMessage.password2 = '확인 비밀번호를 입력해 주세요.';
                if (this.form.password !== this.form.password2) return this.form.errorMessage.password = '비밀번호가 일치 하지 않습니다.';
                if (this.form.name === '') return this.form.errorMessage.name = '이름을 입력해 주세요.';
                if (this.form.birthday === '') return this.form.errorMessage.birthday = '생년월일을 입력해 주세요.';
                if (this.form.gender === '') return this.form.errorMessage.gender = '성별을 입력해 주세요.';
                if (this.form.address === '') return this.form.errorMessage.address = '주소를 입력해 주세요.';

                request('user.register', this.form, function (user) {
                    Cookies.set('sessionId', user.sessionId, {
                        expires: 365,
                        path: '/',
                        domain: '<?=COOKIE_DOMAIN?>'
                    });
                }, alert);
            }

            // location.href('/');
        }
    })
</script>
