<?php

class RecommendationRoute
{
    public function add($in){
        if ( notLoggedIn() ) return e()->not_logged_in;
        return Recommendation()->add($in);
    }

    public function getNickname():array|string{
        if ( notLoggedIn() ) return e()->not_logged_in;
        return Recommendation()->getNickname();
    }


}

