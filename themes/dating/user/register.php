<section class="register m-5">
    <form @submit.prevent="onSubmitRegisterForm()">
        <!--    <input type="hidden" name="p" value="/">-->
        <div class="form-group">
            <label for="inputEmail1">이메일</label>
            <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" v-model="form.email">
            <div class="error" :class="{'d-block': errorMessage.email}">{{errorMessage.email}}</div>
        </div>
        <div class="form-group">
            <label for="inputPassword1">패스워드</label>
            <input type="password" class="form-control" id="inputPassword1" v-model="form.password">
            <div class="error" :class="{'d-block': errorMessage.password}">{{errorMessage.password}}</div>
        </div>
        <div class="form-group">
            <label for="inputPassword2">패스워드 확인</label>
            <input type="password" class="form-control" id="inputPassword2" v-model="form.password2">
            <div class="error">{{errorMessage.password2}}</div>
        </div>
        <div class="form-group">
            <label for="inputName">이름</label>
            <input type="text" class="form-control" id="inputName" v-model="form.name">
            <div class="error">{{errorMessage.name}}</div>
        </div>
        <div class="form-group">
            <label for="inputBirthday">생년월일</label>
            <input type="text" class="form-control" id="inputBirthday" v-model="form.birthday">
            <div class="error">{{errorMessage.birthday}}</div>

        </div>
        <div class="form-group">
            <label for="inputGender">성별</label>
            <input type="text" class="form-control" id="inputGender" v-model="form.gender">
            <div class="error">{{errorMessage.gender}}</div>

        </div>
        <div class="form-group">
            <label for="inputAddress">지역</label>
            <input type="text" class="form-control" id="inputAddress" v-model="form.address">
            <div class="error">{{errorMessage.address}}</div>

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
            },
            errorMessage: {
                email: '',
                password: null,
                password2: null,
                name: null,
                birthday: null,
                gender: null,
                address: null,
            },

        },
        methods: {
            onSubmitRegisterForm: function () {
                this.errorMessage = {};

                if (this.form.email === '') return this.errorMessage.email = '이메일을 입력해 주세요.';
                if (this.form.password === '') return this.errorMessage.password = '비밀번호를 입력해 주세요.';
                if (this.form.password2 === '') return this.errorMessage.password2 = '확인 비밀번호를 입력해 주세요.';
                if (this.form.password !== this.form.password2) return this.errorMessage.password = '비밀번호가 일치 하지 않습니다.';
                if (this.form.name === '') return this.errorMessage.name = '이름을 입력해 주세요.';
                if (this.form.birthday === '') return this.errorMessage.birthday = '생년월일을 입력해 주세요.';
                if (this.form.gender === '') return this.errorMessage.gender = '성별을 입력해 주세요.';
                if (this.form.address === '') return this.errorMessage.address = '주소를 입력해 주세요.';

                request('user.register', this.form, function (user) {
                    setAppCookie('sessionId', user.sessionId);
                    location.href='/';
                }, console.error);

            }

        }
    })
</script>
