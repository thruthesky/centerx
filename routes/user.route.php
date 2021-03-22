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
        return login()->response();
    }

    public function update($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->update($in)->response();
    }

    public function switch($in) {
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
     *
     * @param $in
     * @return mixed
     * @throws Exception
     */
    public function point($in) {
        $myIdx = login()->idx;
        return pointHistory()->search(where: "fromUserIdx=$myIdx OR toUserIdx=$myIdx", limit: 200, select: '*');
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
        );
        $rets = [];
        foreach( $users as $user ) {
            $rets[] = $user->shortProfile();
        }
        return $rets;
    }
}



