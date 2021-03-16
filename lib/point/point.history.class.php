<?php

/**
 * Class PointHistory
 *
 * @property-read int $fromUserIdx
 * @property-read int $toUserIdx
 * @property-read string $reason
 * @property-read string $taxonomy
 * @property-read int $entity
 * @property-read int categoryIdx
 * @property-read int fromUserPointApply
 * @property-read int fromUserPointAfter
 * @property-read int toUserPointApply
 * @property-read int toUserPointAfter
 * @property-read int createdAt
 * @property-read int updatedAt
 */
class PointHistory extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POINT_HISTORIES, $idx);
    }


    /**
     * @param $taxonomy
     * @param $entity
     * @return PointHistory
     * @throws Exception
     */
    public function last($taxonomy, $entity, $reason=''): PointHistory {
        $q = '';
        if ( $reason ) $q = "reason='$reason' AND ";
        $histories = $this->search(where: $q . TAXONOMY . "='$taxonomy' AND entity=$entity", limit: 1);
        if ( count($histories) ) return pointHistory($histories[0][IDX]);
        return pointHistory();
    }
}




/**
 * Returns PointHistory instance.
 *
 *
 * @param int $idx - The `point_histories.idx`.
 * @return PointHistory
 */
function pointHistory(int $idx=0): PointHistory
{
    return new PointHistory($idx);
}




