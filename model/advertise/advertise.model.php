<?php

class AdvertiseModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }
}


/**
 *
 *
 * @param int $idx
 * @return AdvertiseModel
 */
function advertise(int $idx=0): AdvertiseModel
{
    return new AdvertiseModel($idx);
}
