<?php

class ATokenRoute
{
    public function exchangeAToken($in): array|string {

        if ( notLoggedIn() ) return e()->not_logged_in;
        return ['changed' => aToken()->exchangeToken($in) ];
    }

}