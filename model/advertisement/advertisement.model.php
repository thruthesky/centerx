<?php
/**
 * @file advertisement.model.php
 */
/**
 * Class AdvertisementModel
 * @property-read string $clickUrl
 */
class AdvertisementModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }

    public function getAdvertisementSetting($in): array
    {
        if (isset($in[COUNTRY_CODE]) && isset(ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]])) {
            $setting = ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]];
        } else {
            $setting = ADVERTISEMENT_SETTINGS['point']['default'];
        }
        return $setting;
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

    public function getStatus(PostModel $post): string
    {
        $now = time();
        if (isset($post->advertisementPoint) && $post->advertisementPoint) {
            if (daysBetween($now, $post->beginAt) > 0) return 'waiting';
            else if (isBetweenDay($now, $post->beginAt, $post->endAt)) return 'active';
            else return 'inactive';
        }
        return 'inactive';
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
