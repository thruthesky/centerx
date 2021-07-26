<?php

class Recommendation extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(RECOMMENDATION, $idx);
    }

    /*
    * @param $in
    * @return $this|Entity|Friend
    */
    public function add($in){

        debug_log('addRecommendation', $in['otherIdx']);
        debug_log('login()->idx', login()->idx);

        if ($in['otherIdx'] == login()->idx) return $this->error(e()->cannot_add_oneself_as_recommendation);

        login()->update(['recommendation' => $in['otherIdx']]);
        AToken() -> recommend($in);
        return  user(login()->idx) -> profile();


    }

    public function getNickname():array|String{

        if(login()->recommendation == null) return e()->recommendation_is_empty;
        $recommendation = [];
        $recommendation = user(login()->recommendation) -> profile();
        debug_log('getNickname:',$recommendation);
        return $recommendation;
    }

}

function recommendation(int $idx=0):Recommendation {
    return new Recommendation($idx);
}
