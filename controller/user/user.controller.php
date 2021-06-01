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

    // Returns log-in user's profile.
    // Use this method to refresh the login user's profile, also.
    public function profile($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->response();
    }

    public function otherUserProfile($in)
    {
        if (isset($in['idx'])) {
            return user($in['idx'])->shortProfile(firebaseUid: true);
        } else if (isset($in['email'])) {
            return user($in['email'])->shortProfile(firebaseUid: true);
        } else if (isset($in['firebaseUid'])) {
            return user()->findOne(['firebaseUid' => $in['firebaseUid']])->shortProfile(firebaseUid: true);
        } else {
            return e()->user_not_found;
        }
    }

    public function update($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        return login()->update($in)->response();
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
     * 참고, pointHistory.route.php 를 참고한다.
     *
     * @param $in
     * @return mixed
     * @throws Exception
     */
    public function point($in)
    {
        $myIdx = login()->idx;
        return entity(POINT_HISTORIES)->search(where: "fromUserIdx=$myIdx OR toUserIdx=$myIdx", limit: 200, select: '*');
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
        return act()->count(conds: ['action' => POINT_LIKE, 'toUserIdx' => login()->idx]);
    }


    public function search($in)
    {

        $name = $in[NAME] ?? '';;
        if (empty($name)) return e()->empty_name;
        $rows = db()->get_results("SELECT idx FROM " . entity(USERS)->getTable() . " WHERE name='$name' OR nickname='$name'", ARRAY_A);
        $rets = [];
        foreach ($rows as $row) {
            $idx = $row[IDX];
            $rets[] = user($idx)->shortProfile(firebaseUid: true);
        }
        return $rets;
    }
}



