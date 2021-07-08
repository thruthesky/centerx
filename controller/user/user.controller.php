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
        return user()->loginOrRegister($data)->response();
    }

    /**
     * 파이어베이스 auth 로 로그인을 하는 경우,
     *
     * 주로 구글, 페이스북, 애플 로그인을 한다.
     *
     * @param $in
     * @return array|string
     */
    public function firebaseLogin($in) {
        $data = [
            EMAIL => $in[EMAIL],
            PASSWORD => LOGIN_PASSWORD_SALT,
            NICKNAME => $in[NICKNAME] ?? '',
            PHOTO_URL => $in[PHOTO_URL] ?? '',
            DOMAIN => $in[DOMAIN],
            PROVIDER => $in[PROVIDER],
            FIREBASE_UID => $in[FIREBASE_UID],
        ];
        return user()->loginOrRegister($data)->response();
    }

    // Returns log-in user's profile.
    // Use this method to refresh the login user's profile, also.
    public function profile($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->response();
    }




    public function get($in)
    {
        if (isset($in['idx'])) {
            $user =  user($in['idx']);
        } else if (isset($in['email'])) {
            $user =  user($in['email']);
        } else if (isset($in['firebaseUid'])) {
            $user =  user()->findOne(['firebaseUid' => $in['firebaseUid']]);
        } else {
            return e()->user_not_found;
        }

        if (isset($in['full']) && $in['full'] && admin()) {
            return $user->read()->profile();
        }
        return $user->shortProfile(firebaseUid: true);

    }

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
        return userActivity()->search( select: '*', where: $q, params: [$myIdx,$myIdx,$in[BEGIN_AT],$endAt], limit: $limit);
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


    public function search($in)
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

    public  function count($in) : array | string {
        list ($where, $params ) = parseUserSearchHttpParams($in);
        $count = user()->count(
            where: $where,
            params: $params,
            conds: $in['conds'] ?? [],
            conj: $in['conj'] ?? "AND",
        );

        return [ 'count' => $count];
    }
}



