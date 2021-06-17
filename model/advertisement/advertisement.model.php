<?php

class AdvertisementModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }


    private function bannerPoint($bannerType, string $countryCode=''): int {
        if (!$bannerType) return 0;

        if ( $countryCode ) {
            return ADVERTISEMENT_SETTINGS['point'][$countryCode][$bannerType];
        } else {
            return ADVERTISEMENT_SETTINGS['point']['default'][$bannerType];
        }
    }

    public function topBannerPoint(string $countryCode=''): int {
        return $this->bannerPoint(TOP_BANNER, $countryCode);
    }

    public function LineBannerPoint(string $countryCode=''): int {
        return $this->bannerPoint(LINE_BANNER, $countryCode);
    }

    public function SquareBannerPoint(string $countryCode=''): int {
        return $this->bannerPoint(SQUARE_BANNER, $countryCode);
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
