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

    /**
     * Returns true if the advertisement has started.
     * Checks 'beginAt' if is equivalent to today or past days.
     * @return bool
     */
    public function started(): bool {
        return isTodayOrPast( $this->beginAt );
    }

    /**
     * Returns true if the advertisement is expired, meaning the end date is either past or today.
     * Checks 'endAt' if is equivalent to today or past days.
     * @return bool
     */
    public function expired(): bool {
        return isTodayOrPast( $this->endAt );
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
