<?php

class PointHistory extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POINT_HISTORIES, $idx);
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




