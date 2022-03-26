<?php

class UserRoute {

    public function login($in) {
        return user()->login($in)->response();
    }

    public function register($in) {
        return user()->register($in)->response();
    }

    public function loginOrRegister($in) {
        return user()->loginOrRegister($in)->response();
    }

    public function profile($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->response();
    }

    public function otherUserProfile($in) {
        if ( isset($in['idx']) ) {
            return user($in['idx'])->shortProfile(firebaseUid: true);
        } else if ( isset($in['email']) ) {
            return user($in['email'])->shortProfile(firebaseUid: true);
        } else if ( isset($in['firebaseUid']) ) {
            return user()->findOne(['firebaseUid' => $in['firebaseUid']])->shortProfile(firebaseUid: true);
        } else {
            return e()->user_not_found;
        }
    }

    /**
     * @param $in
     * @return array|string
     */
    public function update($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->update($in)->response();
    }

    public function accountDelete() {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return aToken() -> accountDelete();
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
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->switch($in[OPTION])->response();
    }

    public function switchOn($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->switchOn($in[OPTION])->response();
    }

    public function switchOff($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
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
    public function point($in) {
        $myIdx = login()->idx;
        return entity(POINT_HISTORIES)->search(where: "fromUserIdx=$myIdx OR toUserIdx=$myIdx", limit: 200, select: '*');
    }

    public function token($in) {
        $myIdx = login()->idx;
        return entity('a_token_histories')->search(where: "userIdx=$myIdx ", limit: 200, select: '*');
    }

    public function logs($in) {
        $myIdx = login()->idx;
        return entity('logs')->search(where: "userIdx=$myIdx ", limit: 30, select: '*');
    }

    public function gToken($in) {
        $myIdx = login()->idx;
        return entity('users')->search(where: "userIdx=$myIdx ", limit: 1, select: 'atoken');
    }



    /**
     * @param $in
     * @return array
     */
    public function pointRank($in): array
    {
        $users = user()->search(
            order: 'point',
            page: $in['page'] ?? 1,
            limit: $in['limit'],
            where:"birthdate <= 19770000",
        );
        debug_log('pointRank:', count($users));
        $rets = [];
        foreach( $users as $user ) {
            $rets[] = $user->shortProfile();
        }

        return $rets;
    }

    /**
     * @param $in
     * @return array
     */
    public function tokenRank($in): array
    {
        $users = user()->search(
            order: 'atoken',
            page: $in['page'] ?? 1,
            limit: $in['limit'],
            where:"birthdate <= 19770000",
        );
//        debug_log('pointRank:', count($users));
        $rets = [];
        foreach( $users as $user ) {
            $rets[] = $user->shortProfile();
        }

        return $rets;
    }

    /**
     * @param $in
     * @return array
     */
    public function scoreRank($in): array
    {
        $users = user()->search(
            select: 'idx, nickname, point+(atoken * 100) as score',
            order: 'score',
            page: $in['page'] ?? 1,
            limit: $in['limit'],
            where:"birthdate <= 19770000",
        );
        $rets = [];
        foreach( $users as $user ) {
            $rets[] = $user->shortProfile();
        }

        return $rets;
    }

    /**
     * 내가 추천 받은 총 수를 리턴한다.
     * @param $in
     * @return string
     */
    public function heart($in): string {
        return pointHistory()->count(conds: [REASON => POINT_LIKE, 'toUserIdx' => login()->idx]);
    }

    public function search($in) {

        $name = $in[NAME] ?? '';
        if ( empty($name) ) return e()->empty_name;
        $rows = db()->get_results("SELECT idx FROM " . entity(USERS)->getTable() . " WHERE name='$name' OR nickname='$name'", ARRAY_A);
        $rets = [];
        foreach( $rows as $row ) {
            $idx = $row[IDX];
            $rets[] = user($idx)->shortProfile(firebaseUid: true);
        }
        return $rets;
    }


    /**
     * Return login user's rank no of point.
     * @return bool|int|mixed|null
     */
    public function myPointRank() {
        $rankNo = db()->get_var("SELECT COUNT(*) as raking FROM wc_users WHERE birthdate <=19770000 AND  point >= (SELECT point FROM wc_users WHERE idx=".login()->idx.")");
        if ( !$rankNo ) $rankNo = 0;
        return ['rankNo' => $rankNo];
    }

    public function myTokenRank() {
        $rankNo = db()->get_var("SELECT COUNT(*) as raking FROM wc_users WHERE birthdate <=19770000 AND  atoken >= (SELECT atoken FROM wc_users WHERE idx=".login()->idx.")");
        if ( !$rankNo ) $rankNo = 0;
        return ['rankNo' => $rankNo];
    }

    public function myScoreRank() {
        $rankNo = db()->get_var("SELECT COUNT(*) as raking FROM wc_users WHERE birthdate <=19770000 AND  point + (atoken *100) >= (SELECT point + (atoken *100) as score FROM wc_users WHERE idx=".login()->idx.")");
        if ( !$rankNo ) $rankNo = 0;
        return ['rankNo' => $rankNo];
    }



    public function recommend($in) {

        $recommend = entity('user_recommends');

        if ( $recommend->count(conds: ['userIdx' => login()->idx ] ) >= 10 ) return e()->maximum_recommends;

        $created = $recommend->create(['userIdx' => login()->idx, 'otherUserIdx' => $in['otherUserIdx']]);
        if ( $created->hasError ) return $created->getError();

        aToken()->recommend(user($in['otherUserIdx']));
        return ['idx' => $created->idx];
    }

    public function list() {
        $rows = db()->get_results("SELECT idx FROM " . entity(USERS)->getTable(), ARRAY_A);
        $rets = [];
        foreach( $rows as $row ) {
            $idx = $row[IDX];
            $rets[] = user($idx)->shortProfile(firebaseUid: true);
        }
        return $rets;
    }

}



