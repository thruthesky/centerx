<?php

/**
 * Class AToken
 *
 */
class AToken
{


    public function register(User $user)
    {
        $user->update(['atoken' => 300]);
        $this->log();
    }

    public function inAppPurchase($point = 0)
    {
        $saving = $point / 2 * 0.01;
        $atoken = login()->atoken;
        login()->update(['atoken' => $atoken + $saving]);
        $this->log();
    }

    /**
     * @param User $user 추천 받는 사용자.
     */
    public function recommend(User $user) {
        login()->update(['atoken' => login()->atoken + 150]);
        $this->log();
    }


    public function log() {

    }

}

function aToken() {
    return new AToken();
}