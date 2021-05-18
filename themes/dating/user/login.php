<form @submit.prevent="onSubmitRegisterForm()">
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
    <button type="submit" class="btn btn-primary">로그인</button>
</form>

<script>
    mixins.push({
        data: {
            form: {
                email: null,
                password: null,
            },
            errorMessage: {
                email: null,
                password: null,
            }
        },
        methods: {
            onSubmitRegisterForm: function () {
                this.errorMessage = {};

               // if(this.form.email === '') return this.errorMessage.email = '이메일을 입력해 주세요.';
               // if(this.form.password ==password= '') return this.errorMessage.password = '이메일을 입력해 주세요.';


                // setAppCookie()
                // location.href='/';
            }
        }

    });


</script>