<?php

class AdvertisementController
{

    /**
     * returns banners with country code of current cafe and banners with 'all country' country code.
     */
    public function loadBanners($in): array|string
    {
        $banners = advertisement()->loadBanners($in);
        if ( isError($banners) ) return $banners;
        return advertisement()->responses($banners);

    }

    /**
     * 글 검색 후 리턴
     *
     * 참고, 입력 값은 `parsePostSearchHttpParams()` 를 참고한다.
     *
     * @param array $in - See `parsePostSearchHttpParams()` for detail input.
     * @return array|string
     * 
     * 
     * 
     */
    public function search(array $in): array|string
    {

        $re = parsePostSearchHttpParams($in);
        if (isError($re)) return $re;


        list($where, $params) = $re;
        $where = $where . " AND deletedAt=0";
        $in['where'] = $where;
        $in['params'] = $params;


        $banners = advertisement()->search(object: true, in: $in);
        $res = [];
        foreach ($banners as $banner) {
            $res[] = $banner->response();
        }
        return $res;
    }

    /**
     *
     * @param array $in
     *  - $in['idx'] 값이 문자열이면, path 로 인식하고, 숫자이면, idx 로 인식한다.
     * @return array|string
     */
    public function get(array $in)
    {
        if (!isset($in[IDX])) return e()->idx_is_empty;

        return advertisement($in[IDX])->response();
    }


    /**
     * @param $in
     * @return array|string
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     */
    public function edit($in): array | string
    {
        return advertisement()->edit($in)->response();
    }

    /**
     * @param $in
     * - $in['code'] - is the banner type(position)
     * - $in['countryCode'] is the cafe country.
     *   - this can be optional, since it will fall back to default banner point listing when not present in $in.
     * - $in[beginAt] - is the date string of begin date in format of 'YYYY-MM-dd'. ex) "2020-12-12"
     * - $in[endDate] - is the date string of end date.
     * @return array|string
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     *
     */
    public function start($in): array|string
    {
        return banner()->start($in)->response();
    }

    /**
     * Cancel advertisement.
     * 
     * Advertisement can be cancelled, if the begin date is not 
     * 
     * @param $in
     * - $in['idx'] - the advertisement idx.
     * 
     * This method handles refund.
     * 
     * It the advertisement begin date is future, it will cancel the advertisement with full refund.
     * If the begin date is today or past days, it will refund points equivalent to remaining days.
     * If the end date is past day or today, it will not refund points.
     */
    public function stop($in): array | string
    {
        return banner()->stop($in)->response();
    }

    /**
     * Delete advertisement
     * 
     * Advertisements can be deleted if it is inactive, meaning the user's point is refunded.
     * 
     * If the advertisement's status is either 'active' or 'waiting', it will return error.
     */
    public function delete($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $advertisement = advertisement($in[IDX]);
        if ($advertisement->isMine() == false) return  e()->not_your_advertisement;

        $status = advertisement()->getStatus($advertisement);
        if ($status == 'active' || $status == 'waiting') return e()->advertisement_is_active;

        return post($advertisement->idx)->markDelete()->response();
    }

    /**
     * Return advertisement settings like advertisement categories, points, etc.
     */
    public function settings()
    {
        $adv = advertisement();
        return [
            'types' => BANNER_TYPES,
            'maximumAdvertisementDays' => $adv->maximumAdvertisementDays(),
            'maxNoOnGlobalTopBanner' => $adv->maxNoOn(TOP_BANNER, ''),
            'maxNoOnCategoryTopBanner' => $adv->maxNoOn(TOP_BANNER, '.'),
            'maxNoOnGlobalSidebarBanner' => $adv->maxNoOn(SIDEBAR_BANNER, ''),
            'maxNoOnCategorySidebarBanner' => $adv->maxNoOn(SIDEBAR_BANNER, '.'),
            'maxNoOnGlobalSquareBanner' => $adv->maxNoOn(SQUARE_BANNER, ''),
            'maxNoOnCategorySquareBanner' => $adv->maxNoOn(SQUARE_BANNER, '.'),
            'maxNoOnGlobalLineBanner' => $adv->maxNoOn(LINE_BANNER, ''),
            'maxNoOnCategoryLineBanner' => $adv->maxNoOn(LINE_BANNER, '.'),
            'categoryArray' => $adv->advertisementCategoryArray(),
            'point' => $adv->advertisementPoints(),
            'globalBannerMultiplying' => $adv->globalBannerMultiplying(),
        ];
    }

    /**
     * Update the point settings for each banner for the countryCode.
     *
     * If the record does not exist, it will create new record. Otherwise, it will update that record.
     *
     * @note, default banner settings for global, the countryCode is empty string.
     * @param $in
     * - example of request
     * { countryCode: "yo", top: 100, sidebar: 200, square: 300, line: 400 }
     * @return array|string
     */
    public function setBannerPoint($in)
    {

        return (new AdvertisementPointSettingsModel())->edit($in)->response();
    }

    public function getBannerPoints($in)
    {
        return (new AdvertisementPointSettingsModel())->search(select: '*', order: COUNTRY_CODE, by: 'ASC');
    }

    public function deleteBannerPoint($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;
        if (!admin()) return e()->you_are_not_admin;
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;
        return (new AdvertisementPointSettingsModel($in[IDX]))->delete()->response();
    }
}
