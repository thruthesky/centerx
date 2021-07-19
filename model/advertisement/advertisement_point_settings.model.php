<?php
/**
 * @file advertisement.model.php
 */
/**
 * Class AdvertisementModel
 * @property-read string $countryCode
 * @property-read string $top
 * @property-read string $sidebar
 * @property-read string $square
 * @property-read string $line
 */
class AdvertisementPointSettingsModel extends Entity
{

    public function __construct(int $idx = 0)
    {
        parent::__construct('advertisement_point_settings', $idx);
    }

    /**
     * Set banner point.
     *
     * @note, only admin can change the banner point.
     *
     * @param $in
     * @return AdvertisementPointSettingsModel
     */
    public function edit($in): self {

        if (notLoggedIn()) return $this->error(e()->not_logged_in);
        if (!admin()) return $this->error(e()->you_are_not_admin);
        if (!isset($in[TOP_BANNER]) || empty($in[TOP_BANNER])) return $this->error(e()->empty_top_banner_point);
        if (!isset($in[SIDEBAR_BANNER]) || empty($in[SIDEBAR_BANNER])) return $this->error(e()->empty_sidebar_banner_point);
        if (!isset($in[SQUARE_BANNER]) || empty($in[SQUARE_BANNER])) return $this->error(e()->empty_square_banner_point);
        if (!isset($in[LINE_BANNER]) || empty($in[LINE_BANNER])) return $this->error(e()->empty_line_banner_point);

        if ($in[TOP_BANNER] < 0 || $in[SIDEBAR_BANNER]  < 0 || $in[SQUARE_BANNER]  < 0 || $in[LINE_BANNER] < 0) {
            return $this->error(e()->invalid_value);
        }

        return $this->_setPoints($in);
//
//        $a = new AdvertisementPointSettingsModel();
//
//        if (!isset($in[COUNTRY_CODE]) || empty($in[COUNTRY_CODE])) $in[COUNTRY_CODE] = '';
//
//        // If countryCode exists, in database table, update it.
//        if ($a->countryExists($in[COUNTRY_CODE])) {
//            $in[IDX] = $a->getIdxFromDB([COUNTRY_CODE => $in[COUNTRY_CODE]]);
//        }
//
//
//        if ( isset($in[IDX]) && $in[IDX] ) return (new AdvertisementPointSettingsModel($in[IDX]))->update($in);
//        else return $this->create($in);
    }

    /**
     * 광고 배너 포인트를 수정한다.
     * 주의: 이 함수는 관리자 권한 체크를 하지 않는다. 따라서 이 함수를 controller 에서 직접 쓰이지 않도록 해야 한다. 그런 의미로 함수명 앞에 언더바(_)를 붙였다.
     * @param $in
     * @return $this
     */
    private function _setPoints($in): self {

        $a = new AdvertisementPointSettingsModel();

        if (!isset($in[COUNTRY_CODE]) || empty($in[COUNTRY_CODE])) $in[COUNTRY_CODE] = '';

        // If countryCode exists, in database table, update it.
        if ($a->countryExists($in[COUNTRY_CODE])) {
            $in[IDX] = $a->getIdxFromDB([COUNTRY_CODE => $in[COUNTRY_CODE]]);
        }


        if ( isset($in[IDX]) && $in[IDX] ) return (new AdvertisementPointSettingsModel($in[IDX]))->update($in);
        else return $this->create($in);
    }

    /**
     * Resets banner point.
     * This is an alias of `setPoint()` and is set to public. So it can be used outside.
     * But be sure that this will not be called by controllers for security reason.
     *
     * 관리자 권한 설정 없이, DB 를 수정해서 곧 바로, 포인트 수정을 한다.
     * @param string $countryCode
     * @param int $top
     * @param int $sidebar
     * @param int $square
     * @param int $line
     */
    public function _resetPoints(string $countryCode = '', int $top = 0, int $sidebar = 0, int $square = 0, int $line = 0)
    {
        $this->_setPoints([
            COUNTRY_CODE => $countryCode,
            TOP_BANNER => $top,
            SIDEBAR_BANNER => $sidebar,
            SQUARE_BANNER => $square,
            LINE_BANNER => $line
        ]);
    }


    public function countryExists(string $countryCode): bool
    {
        return parent::exists([COUNTRY_CODE => $countryCode]);
    }
}
