<?php

class UserRoute {

    public function login($in) {
        return user()->login($in);
    }

    public function register($in) {
        return user()->register($in);
    }

    public function profile($in) {
        return user()->profile();
    }


    public function update($in) {
        return login()->update($in);
    }

}



