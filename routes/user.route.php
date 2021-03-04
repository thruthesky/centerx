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
        return login()->update($in);
    }

    public function updateOptionSetting($in) {
        return login()->updateOptionSetting($in);
    }

}



