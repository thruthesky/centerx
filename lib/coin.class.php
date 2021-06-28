<?php

class Coin {
    public function register(User $user) {
        $user->update(['coin' => 300]);
    }
    public function inAppPurchase($point = 0) {
        $saving = $point / 2 * 0.01;
        $point = login()->getPoint();
        login()->update(['coin' => $point + $saving]);
    }

}


function coin() {
    return new Coin();
}