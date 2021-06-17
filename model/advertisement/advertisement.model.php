<?php

class AdvertisementModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }


    public function topBannerPoint(string $countryCode=''): int {
        if ( $countryCode ) {
            return ADVERTISEMENT_SETTINGS['point'][$countryCode][TOP_BANNER];
        } else {
            return ADVERTISEMENT_SETTINGS['point']['default'][TOP_BANNER];
        }
    }
}


/**
 *
 *
 * @param int $idx
 * @return AdvertisementModel
 */
function advertisement(int $idx=0): AdvertisementModel
{
    return new AdvertisementModel($idx);
}
