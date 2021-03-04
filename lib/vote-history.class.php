<?php

class VoteHistory extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(POST_VOTE_HISTORIES, $idx);
    }

    public function by($userIdx, $taxonomy, $entity) {
        $idx = db()->get_var("SELECT idx FROM " . $this->getTable() . " WHERE userIdx=$userIdx AND taxonomy='$taxonomy' AND entity=$entity");
        if ( $idx ) return voteHistory($idx);
        else return voteHistory(0);
    }

}


/**
 * Returns VoteHistory instance.
 *
 *
 * @param int $idx - The `point_histories.idx`.
 * @return VoteHistory
 */
function voteHistory(int $idx=0): VoteHistory
{
    return new VoteHistory($idx);
}


