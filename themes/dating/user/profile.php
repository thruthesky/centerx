<section class="register m-5">
    <form @submit.prevent="onSubmitRegisterForm()">
        <!--    <input type="hidden" name="p" value="/">-->

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
                name: '',
                birthday: '',
                gender: '',
                address: '',
            },
            errorMessage: {
                name: null,
                birthday: null,
                gender: null,
                address: null,
            },

        },
        methods: {
            onSubmitRegisterForm: function () {
                this.errorMessage = {};
                if (this.form.name === '') return this.errorMessage.name = '이름을 입력해 주세요.';
                if (this.form.birthday === '') return this.errorMessage.birthday = '생년월일을 입력해 주세요.';
                if (this.form.gender === '') return this.errorMessage.gender = '성별을 입력해 주세요.';
                if (this.form.address === '') return this.errorMessage.address = '주소를 입력해 주세요.';

                request('user.register', this.form, function (user) {
                    setAppCookie('sessionId', user.sessionId);
                    location.href = '/';
                    alert('가입이 완료되었습니다.')
                }, alert);
            }
        }
    })
</script>
