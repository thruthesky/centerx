<?php

function pass_login_aes_dec($str)
{
    $key_128 = substr(PASS_LOGIN_CLIENT_SECRET_KEY, 0, 128 / 8);
    return openssl_decrypt(base64_decode($str), 'AES-128-CBC', $key_128, true, $key_128);
}

/**
 * 휴대폰번호 PASS 로그인을 한 후, 그 정보를 배열로 리턴한다.
 *
 * @param $in
 * @return array|string
 *
 * 최초 로그인 또는 자동로그인아 아닌 경우, 리턴되는 값 예)
Array
(
    [ci] => fkxZh3dlJtMa9u+Prs42nkY4IoTUOw9J65gWlVYNpjsZ3psXHJGamA6olV9uW46l9Lge0D36xQkCBN9q5lmuZA==
    [phoneNo] => 01086934225
    [name] => 송재호
    [birthdate] => 731016
    [gender] => M
    [agegroup] => 40
    [foreign] => L
    [telcoCd] => S
    [plid] => 86289de3-aa03-468f-a7ef-0526fc33a219
    [autoStatusCheck] => N
)
 * 자동 로그인ㅇ르 하는 경우, 리턴되는 값 예)
Array(
  [autoLoginYn] => Y
  [plid] => 86289de3-aa03-468f-a7ef-0526fc33a219
  [autoStatusCheck] => N
)
 *
 */
function pass_login_callback($in): array|string
{
    debug_log("pass_login_callback", json_encode($in));
    // Callback url 이 처음 호출 되면,
    //   Array ( [code] => lzRdPT, [state] => apple_banana_cherry )
    // 와 같은 값이 넘어 온다.
    // 이, code 로, 사용자 정보를 가져온다.
    if (!isset($in['code'])) return e()->code_is_empty;
    $code = $in['code'];
    $state = $in['state'] ?? '';

    // Step 1. 백엔드에서 PASS 서버로 로그인해서, access_token 을 가져온다. 참고로 Refresh 를 하면 Invalid authorization code 에러가 난다.
    // 로그인 성공하면, ["access_token" => "...", "token_type" => "bearer", "expires_in" => 600, "state" => "..."] 와 같은 정보가 나온다.
    $url = "https://id.passlogin.com/oauth2/token";

    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic ' . base64_encode(PASS_LOGIN_CLIENT_ID . ":" . PASS_LOGIN_CLIENT_SECRET_KEY),
    );
    $o = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => "grant_type=authorization_code&code=$code&state=$state",
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_HEADER => 0, // 결과 값에 HEADER 정보 출력 여부
        CURLOPT_FRESH_CONNECT => 1, // 캐시 사용 0, 새로 연결 1
        CURLOPT_RETURNTRANSFER => 1, // 리턴되는 결과 처리 방식. 1을 변수 저장. 2는 출력.
        CURLOPT_SSL_VERIFYPEER => 0 // HTTPS 사용 여부
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $o);

    try {
        $response = curl_exec($ch);
        $re = json_decode($response, true);
        if (isset($re['error'])) {
            return e()->passlogin_faield . ":Failed to get token. $re[error] $re[message]";
        }
        // @todo leave log
        //            file_put_contents($log_file, $response ."\r\n\r\n");
    } catch (exception $e) {
        // @todo leave log
        d($e);
    }
    curl_close($ch);



    /// Step 2. access_token 의 회원 정보를 가져온다. access_token 당 1회만 조회 가능. 주의: 자동 로그인을 할 때에는 전화번호나 기타 정보가 따라오지 않는다. 그래서 가능하면 로그인을 한번하고 로그인을 끊어 줘야 한다.

    $headers = ['Authorization: Bearer ' . $re['access_token']];
    $o = [
        CURLOPT_URL => "https://id.passlogin.com/v1/user/me",
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_HEADER => 0, // 결과 값에 HEADER 정보 출력 여부
        CURLOPT_FRESH_CONNECT => 1, // 캐시 사용 0, 새로 연결 1
        CURLOPT_RETURNTRANSFER => 1, // 리턴되는 결과 처리 방식. 1을 변수 저장. 2는 출력.
        CURLOPT_SSL_VERIFYPEER => 0 // HTTPS 사용 여부
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $o);

    try {
        $response = curl_exec($ch);
        $re = json_decode($response, true);
        if (isset($re['error']) && $re['error']) echo "[ ERROR: $re[error], MESSAGE: $re[message] ]";
        // @todo leave log
        //            file_put_contents($log_file, $response ."\r\n\r\n");
    } catch (exception $e) {
        // @todo leave log
        d($e);
    }
    curl_close($ch);

    // 휴대폰 PASS 로그인으로 부터 받은 회원 정보
    $user = $re['user'];
    $ret = [];


    /**
     * 주의: 자동로그인을 할 때, ci 및 기타 값에 이상한 값이 들어온다.
     */
    if (isset($user['autoLoginYn']) && $user['autoLoginYn'] == 'Y') {
        // 자동 로그인의 경우,
        $ret['autoLoginYn'] = $user['autoLoginYn'];
    } else {
        /**
         * 최초로그인 또는 자동로그인이 아닌 경우,
         */
        if (isset($user['ci']) && $user['ci']) {
            $ret['ci'] = pass_login_aes_dec($user['ci']);
        }
        if (isset($user['phoneNo']) && $user['phoneNo']) {
            $ret['phoneNo'] = pass_login_aes_dec($user['phoneNo']);
        }
        if (isset($user['name']) && $user['name']) {
            $ret['name'] = pass_login_aes_dec($user['name']);
        }
        if (isset($user['birthdate']) && $user['birthdate']) {
            $ret['birthdate'] = pass_login_aes_dec($user['birthdate']);
        }
        if (isset($user['gender']) && $user['gender']) {
            $ret['gender'] = $user['gender'];
        }
        if (isset($user['agegroup']) && $user['agegroup']) {
            $ret['agegroup'] = $user['agegroup'];
        }
        if (isset($user['foreign']) && $user['foreign']) {
            $ret['foreign'] = $user['foreign'];
        }
        if (isset($user['telcoCd']) && $user['telcoCd']) {
            $ret['telcoCd'] = $user['telcoCd'];
        }
    }

    // plid 는 자동로그인이든 아니든 항상 들어오며, 암호화되어 들어오지 않는다. 복호화 할 필요 없다.
    if (isset($user['plid']) && $user['plid']) {
        $ret['plid'] = $user['plid'];
    }

    if (isset($user['autoStatusCheck']) && $user['autoStatusCheck']) {
        $ret['autoStatusCheck'] = $user['autoStatusCheck'];
    }


//    debug_log("pass: ", json_encode($ret));
    // 휴대폰 PASS 로그인으로 부터 받은 회원 정보를 배열에 담아 리턴한다. 회원 가입이나 로그인 용도로 사용 할 수 있다.
    return $ret;
}



/**
 * 패스 로그인을 한 다음, 회원 로그인 또는 회원 가입
 *
 * 참고, 원칙적으로는 이메일/비밀번호 또는 소셜로그인을 미리 하고 난 후, 패스그인으로 본인 인증을 한번만 한다.
 *      하지만, 매번 패스로그인을 하는 경우는 이 함수를 매번 호출 할 수 있다.
 *
 * @param array $user - 위 pass_login_callback 함수에서 받은 회원 정보로 회원 로그인 또는 회원 가입을 한다.
 * @return array
 */
function pass_login_or_register(array $user): UserModel
{
    if (isset($user['ci']) && $user['ci']) {
        /// 처음 로그인 또는 자동 로그인이 아닌 경우,
        $user[EMAIL] = PASS_LOGIN_MOBILE_PREFIX . "$user[phoneNo]@passlogin.com";
        $user[PASSWORD] = md5(LOGIN_PASSWORD_SALT . PASS_LOGIN_CLIENT_ID . $user['phoneNo']);
        $user[PROVIDER] = VERIFIER_PASSLOGIN;
        $user[VERIFIER] = VERIFIER_PASSLOGIN;
        $profile = user()->loginOrRegister($user);
    } else {
        /// plid 가 들어 온 경우, meta 에서 ci 를 끄집어 낸다.
        $userIdx = meta()->entity(USERS, 'plid',$user['plid']);

//        $userIdx = getMetaEntity(USERS, 'plid', $user['plid']); //  user()->getMetaEntity('plid', $user['plid']);
        $profile = user($userIdx);
    }
    return $profile;
}




function pass_login_message($msg) {
    echo <<<EOH
<div style="margin: 4em auto; max-width: 800px; text-align: center;">
    <h1>패스 휴대폰번호 로그인</h1>
    <h3>$msg</h3>
</div>
EOH;

}