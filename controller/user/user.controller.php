<?php
/**
 * @file user.controller.php
 */

/**
 * Class UserController
 */
class UserController
{

    public function login($in)
    {
        return user()->login($in)->response();
    }

    public function register($in)
    {
        return user()->register($in)->response();
    }

    public function loginOrRegister($in)
    {
        return user()->loginOrRegister($in)->response();
    }

    public function kakaoLogin($in) {
        $data = [
            EMAIL => 'kakao' . $in['id'] . '@kakao.com',
            PASSWORD => LOGIN_PASSWORD_SALT,
            NICKNAME => $in['naickname'] ?? '',
            PHOTO_URL => $in['photoUrl'] ?? '',
            DOMAIN => $in[DOMAIN],
            PROVIDER => PROVIDER_KAKAO,
        ];
        return user()->loginOrRegister($data, loginUpdate: false)->response();
    }

    /**
     * 파이어베이스 auth 로 로그인을 하는 경우, 회원 가입 또는 로그인
     *
     * 참고, 파이어베이스 로그인은 주로 구글, 페이스북, 애플 로그인을 한다.
     * 참고, 메일 주소가 없을 수 있다. 이 경우, firebaseUid 를 이용해서 회원 메일 주소를 만든다.
     *
     * @param $in
     * @return array|string
     */
    public function firebaseLogin($in) {
        $data = [
            EMAIL => $in[FIREBASE_UID] . "@" . $in[PROVIDER] . ".com",
            'orgEmail' => $in[EMAIL],
            PASSWORD => LOGIN_PASSWORD_SALT,
            NICKNAME => $in[NICKNAME] ?? '',
            PHOTO_URL => $in[PHOTO_URL] ?? '',
            DOMAIN => $in[DOMAIN],
            PROVIDER => $in[PROVIDER],
            FIREBASE_UID => $in[FIREBASE_UID],
        ];
        return user()->loginOrRegister($data, loginUpdate: false)->response();
    }

    /**
     * $in['code'] 의 값을 받아, 패스로그인 서버에 접속해서 사용자 정보를 가져 온 다음, 디코딩해서 클라이언트로 전달한다.
     * 주의, 이 함수는 오직 "패스로그인 사용자 정보"만, 리턴한다. 따로 회원가입, 로그인 도는 업데이트나 기타 작업을 하지 않는다.
     * @param $in
     * @return array|string
     */
    public function passloginCallback($in): array|string {
        include ROOT_DIR . 'etc/callbacks/pass-login/pass-login.lib.php';
        return pass_login_callback($in);
    }

    /**
     * $in['code'] 의 값을 받아, 패스로그인 서버에 접속해서 사용자 정보를 가져 온 다음, 디코딩해서,
     *  회원 가입 또는 로그인, 또는 업데이트를 한다.
     * 주의, `passloginCallback()` 함수와는 다르게,
     *  - $in['code'] 를 받아서,
     *  - 현재 로그인을 한 상태이면, "패스로그인 사용자 정보"를 회원 정보에 업데이트하고,
     *  - 현재 로그인을 하지 않은 상태이면, 회원 가입 또는 로그인을 한다.
     *
     * @param $in
     * @return array|string
     *  - 에러 문자열
     *  - 또는 사용자 response
     */
    public function passlogin($in): array|string {
        include ROOT_DIR . 'etc/callbacks/pass-login/pass-login.lib.php';
        $res = pass_login_callback($in);

        debug_log('passlogin; res; ', $res);
        if ( isError($res) ) {
            return $res;
        }

        if ( loggedIn() ) {
            // 회원 로그인을 한 상태이면, PASS LOGIN 으로 부터 넘어온 정보를 회원 정보로 업데이트한다.
            $res[VERIFIER] = VERIFIER_PASSLOGIN;
            login()->update($res);
            return login()->response();
        } else {
            if (isset($res['ci']) && $res['ci']) {
                // 처음 로그인 또는 자동 로그인이 아닌 경우,
                $res[EMAIL] = PASS_LOGIN_MOBILE_PREFIX . "$res[phoneNo]@passlogin.com"; // 임시 메일
                $res[PASSWORD] = md5(LOGIN_PASSWORD_SALT . PASS_LOGIN_CLIENT_ID . $res['phoneNo']); // 임시 비번
                $res[PROVIDER] = VERIFIER_PASSLOGIN;
                $res[VERIFIER] = VERIFIER_PASSLOGIN;
                $user = user()->loginOrRegister($res);
            } else {
                // 여러 차례 로그인,
                // plid 가 들어 오는데, meta 에서 ci 를 끄집어 내서, 사용자가 누구인지 확인한다.
                $userIdx = meta()->entity(USERS, 'plid',$res['plid']);

                $user = user($userIdx);
            }
            return $user->response();
        }
    }

    // Returns log-in user's profile.
    // Use this method to refresh the login user's profile, also.
    public function profile($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->response();
    }


    /**
     * Returns user information.
     *
     * @param $in
     *  - if $in['idx'] has passed, then check if the user of that idx exists.
     *  - if $in['email'] has passed, then check if the user of that email exists.
     *  - if $in['firebaseUid'] has passed, then check if the user of that firebaseUid exists.
     *  - if $in['uid'] has passed, then check if the user of that idx or email exists. Then, it checks if firebaseUid exists.
     * @return array|string
     */
    public function get($in)
    {
        if (isset($in['idx'])) {
            $user = user($in['idx']);
        } else if (isset($in['email'])) {
            $user = user()->findOne([EMAIL => $in['email']]);
        } else if (isset($in['firebaseUid'])) {
            $user = user()->findOne(['firebaseUid' => $in['firebaseUid']]);
        } else if (isset($in['uid'])) {
            $user = user()->by($in['uid']);
            if ($user->hasError) {
                $user = user()->findOne(['firebaseUid' => $in['firebaseUid']]);
            }
        } else {
            return e()->wrong_params;
        }

        if (isset($in['full']) && $in['full'] && admin()) {
            return $user->read()->profile();
        }
        return $user->shortProfile(firebaseUid: true);

    }

    /**
     * 사용자 정보 수정
     *
     * @param $in
     * @return array|string
     */
    public function update($in): array| string
    {
        if (notLoggedIn()) return e()->not_logged_in;

        if (isset($in['idx']) && admin()) {
            return user($in['idx'])->update($in)->response();
        } else {
            return login()->update($in)->response();
        }
    }

    /**
     * Save user meta code with on/off.
     *
     * Use this to switch on/off user optoin.
     *
     * @param $in
     * @return array|string
     */
    public function switch($in): array|string
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->switch($in[OPTION])->response();
    }

    public function switchOn($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->switchOn($in[OPTION])->response();
    }

    public function switchOff($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->switchOff($in[OPTION])->response();
    }

    /**
     * Returns user point history.
     *
     * Note that, it returns point histories of both that the login user made action or received point.
     * 사용자가 로그인과 같이 직접 발생시킨 포인트와, 추천과 같이 받은 포인트, 포인트 결제 등 해당 사용자와 연관된 모든 포인트를 리턴한다.
     *
     *
     * @param $in
     * @return array|string
     */
    public function point($in): array | string
    {
        if (notLoggedIn()) return e()->not_logged_in;
        $myIdx = login()->idx;

        /**
         * convert beginAt and endAt date string to stamp
         */
        $in = post()->updateBeginEndDate($in);

        /**
         * return error if date difference is more than 90days
         */
        if (daysBetween($in[BEGIN_AT], $in[END_AT]) > 90) return e()->more_than_90days_date_difference;

        $endAt = $in[END_AT] + (60 * 60 * 24) - 1;
        $sql = [];
        $sql[] = "((fromUserIdx=? AND fromUserPointApply<>0) OR (toUserIdx=? AND toUserPointApply<>0))";
        $sql[] = "(createdAt >=? AND createdAt <=?)";
        $q = implode(' AND ', $sql);

        $limit = $in['limit'] ?? 1000;
        $activities =  userActivity()->search( select: '*', where: $q, params: [$myIdx,$myIdx,$in[BEGIN_AT],$endAt], limit: $limit);

        $rets = [];
        foreach ($activities as $activity) {
            if ($activity['taxonomy'] == POSTS) {
                $activity['post'] = post($activity[ENTITY])->response();
            }
            $rets[] = $activity;
        }
        return $rets;
    }

    /**
     * Returns user list order by point rank.
     *
     * Use this to display users on the order of point rank to show who are the most high ranks.
     * @param $in
     * @return array
     */
    public function pointRank($in): array
    {
        $users = user()->search(
            order: 'point',
            page: $in['page'] ?? 1,
            limit: $in['limit'],
            object: true
        );
        $rets = [];
        foreach ($users as $user) {
            $rets[] = $user->shortProfile();
        }
        return $rets;
    }


    /**
     * Return login user's rank no of point.
     *
     * Use this to display what number is the login user in of the point rank.
     *
     * @return bool|int|mixed|null
     */
    public function myPointRank()
    {
        $rankNo = db()->get_var("SELECT COUNT(*) as raking FROM wc_users WHERE point >= (SELECT point FROM wc_users WHERE idx=" . login()->idx . ")");
        if (!$rankNo) $rankNo = 0;
        return ['rankNo' => $rankNo];
    }

    /**
     * 내가 추천 받은 총 수를 리턴한다.
     * @param $in
     * @return string
     */
    public function heart($in): string
    {
        return userActivity()->count(conds: ['action' => POINT_LIKE, 'toUserIdx' => login()->idx]);
    }


    /**
     * 사용자 검색
     *
     * @param $in
     *  $in['searchKey'] 에 문자열을 넣으면,
     *      name, nickname, email, phoneNo 중에서 부분적으로 일치하는 것이 있으면 검색 결과에 포함한다.
     *      그리고 firebaseUid 와 일치하면, 검색결과에 포함한다.
     * @return array
     */
    public function search(array $in): array
    {

        list ($where, $params ) = parseUserSearchHttpParams($in);

        $users = user()->search(
            select: $in['select'] ?? 'idx',
            where: $where,
            params: $params,
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
            object: true
        );

        $res = [];
        foreach($users as $user) {
//            $res[] = $user->shortProfile(firebaseUid: true);
            if (isset($in['full']) && $in['full'] && admin()) {
                $res[] =  $user->profile();
            } else {
                $res[] =  $user->shortProfile(firebaseUid: true);
            }

        }
        return $res;
    }

    /**
     * 사용자 카운트
     * 사용자 검색과 동일한 방식의 쿼리 가능.
     * @param array $in
     * @return array
     */
    public function count(array $in) : array {
        list ($where, $params ) = parseUserSearchHttpParams($in);
        $count = user()->count(
            where: $where,
            params: $params,
            conds: $in['conds'] ?? [],
            conj: $in['conj'] ?? "AND",
        );

        return [ 'count' => $count];
    }


    /**
     * 회원 통계 리턴
     *
     * - 총 회원 수,
     * - 남자 회원 수,
     * - 여자 회원 수
     * @return array
     */
    public function stats(): array {
        return [
            'total' => user()->count(),
            'M' => user()->count(conds: [GENDER => 'M']),
            'F' => user()->count(conds: [GENDER => 'F']),
        ];
    }


}



