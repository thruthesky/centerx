
<div class="box mb-2">
    <div class="fs-xs">
        로그인을 해 주세요.
    </div>
    <a href="javascript:loginWithKakao()"><img class="mt-1 w-100" src="/widgets/login/social-login/kakao-login.png"></a>
    <a href="<?=NAVER_API_URL?>"><img class="mt-1 w-100" src="/widgets/login/social-login/naver-login.png"></a>
    <a href="<?=passLoginUrl('openHome')?>"><img class="mt-1 w-100" src="/widgets/login/social-login/pass-login.png"></a>
</div>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type='text/javascript'>
    //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init( "<?=KAKAO_CLIENT_ID?>" );
    function loginWithKakao() {
        // 로그인 창을 띄웁니다.
        Kakao.Auth.login({
            success: function(authObj) {
                console.log(JSON.stringify(authObj));

                Kakao.API.request({
                    url: '/v2/user/me',
                    success: function(res) {
                        console.log(res);
                        const url = "<?=KAKAO_CALLBACK_URL?>?kakao_id=" + res.id;
                        console.log(url);
                        location.href = url;
                    },
                    fail: function(error) {
                        console.log(error);
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err));
            }
        });
    }
    //]]>
</script>
