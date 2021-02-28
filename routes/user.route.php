<?php

class UserRoute {

    public function login($in) {
        return user()->login($in[EMAIL], $in[PASSWORD]);
    }

    public function profile($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        return login()->profile();
    }
}



