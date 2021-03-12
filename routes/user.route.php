<?php

class UserRoute {

    public function login($in) {
        return user()->login($in);
    }

    public function register($in) {
        return user()->register($in);
    }

    public function loginOrRegister($in) {
        return user()->loginOrRegister($in);
    }

    public function profile($in) {
        return login()->profile();
    }


    public function update($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->update($in);
    }

    public function updateOptionSetting($in) {
        return login()->updateOptionSetting($in);
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
}



