<?php

class AdvertisementController
{




    /**
     * Returns active banners of the country of the cafe.
     *
     * @param array $in - See `parsePostSearchHttpParams()` for detail input.
     * @return array|string
     * - url
     * - clickUrl
     * - bannerUrl
     * - subcategory
     *
     * @attention if subcaetgory is empty, it is set to 'global'.
     */
    public function loadBanners(array $in): array|string
    {
        $cafe = cafe(domain: $in['cafeDomain']);
        $where = "countryCode=? AND code <> '' AND beginAt<? AND endAt>=? AND files<>''";
        $params = [$cafe->countryCode, time(), today()];

//        debug_log('tomorrow; ', tomorrow());

        $posts = advertisement()->search(where: $where, params: $params, order: 'endAt', object: true);
        $res = [];
        foreach ($posts as $post) {
            $res[] = [
                'idx' => $post->idx,
                'url' => $post->relativeUrl,
                'clickUrl' => $post->clickUrl,
                'bannerUrl' => $post->fileByCode('banner')->url,
                'subcategory' => $post->subcategory ? $post->subcategory : 'global',
                'code' => $post->code,
            ];
        }
        return $res;
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
        if ($in) {
            $re = parsePostSearchHttpParams($in);
            if (isError($re)) return $re;
            list($where, $params) = $re;
            $in['where'] = $where;
            $in['params'] = $params;
        }

        $posts = post()->search(object: true, in: $in);
        $res = [];
        foreach ($posts as $post) {
            $post->updateMemoryData('status', advertisement()->getStatus($post));
            $res[] = $post->response(comments: 0);
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

        $post = post($in[IDX]);
        $post->updateMemoryData('status', advertisement()->getStatus($post));
        return $post->response();
    }


    public function edit($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) {

            $post = post()->create($in);
            $post->updateMemoryData('status', 'inactive');
            return $post->response();
        } else {

            $post = post($in[IDX]);
            if ($post->isMine() == false) return  e()->not_your_post;

            $post->update($in);
            $post->updateMemoryData('status', advertisement()->getStatus($post));

            return $post->response();
        }
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
     * @todo do tests
     * @todo test - check input /
     * @todo test - check point deduction /
     * @todo test - check cancel /
     * @todo test - check refund /
     * @todo test - change dates after create banner and check days left.
     * @todo test - compare the point history. /
     * @todo test - get banners on a specific /
     *    - banner type/place (code) /
     *    - category(subcategory) /
     *    - and countryCode. /
     */
    public function start($in)
    {
        if (notLoggedIn()) return e()->not_logged_in;

        // check if post idx is present.
        if (!isset($in[IDX]) && empty($in[IDX])) return e()->idx_is_empty;

        // check if post is mine
        $post = post($in[IDX]);
        if ($post->isMine() == false) return  e()->not_your_post;

        // check code input
        if (!isset($in[CODE]) || empty($in[CODE])) return e()->code_is_empty;

        // check dates input
        if (!isset($in['beginDate']) || empty($in['beginDate'])) return e()->begin_date_empty;
        if (!isset($in['endDate']) || empty($in['endDate'])) return e()->end_date_empty;


        $in = $post->updateBeginEndDate($in);

        // add 1 to include beginning date.
        $days = daysBetween($in[BEGIN_AT], $in[END_AT]) + 1;
        if (ADVERTISEMENT_SETTINGS['maximum_advertising_days']) {
            if (ADVERTISEMENT_SETTINGS['maximum_advertising_days'] < $days) return e()->maximum_advertising_days;
        }

        // Save point per day. This will be saved in meta.
        $in['pointPerDay'] = 0;

        $settings = advertisement()->getAdvertisementSetting($in);

        $in['pointPerDay'] = $settings[$in[CODE]];

        // Save total point for the advertisement periods.
        $in['advertisementPoint'] = $in['pointPerDay'] * $days;

        // check if the user has enough point
        if (login()->getPoint() < $in['advertisementPoint']) {
            return e()->lack_of_point;
        }

        // Record for post creation and change point.
        $activity = userActivity()->changePoint(
            action: 'advertisement.start',
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: -$in['advertisementPoint'],
            taxonomy: POSTS,
            categoryIdx: $post->categoryIdx,
            entity: $post->idx,
        );

        debug_log("apply point; {$activity->toUserPointApply} != {$in['advertisementPoint']}");
        if ($activity->toUserPointApply != -$in['advertisementPoint']) {
            // @attention !! If this error happens, it is a critical problem.
            // The admin must investigate the database and restore user's point.
            // Then, it needs to rollback the SQL query and needs to have race condition test to prevent the same incident.
            return e()->advertisement_point_deduction_failed;
        }

        // Save total deducted point from user which the total point for the advertisement.

        $post = $post->update($in);
        $post->updateMemoryData('status', advertisement()->getStatus($post));
        return $post->response();
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
     * If the begin date is today or past days, it will deduct the points equivalent to served days of the advertisement.
     */
    public function stop($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $post = post($in[IDX]);
        if ($post->isMine() == false) return  e()->not_your_post;

        // get number of days to refund.
        $days = 0;
        $action = 'advertisement.stop';
        $pointToRefund = 0;

        // if days between now and beginAt is bigger than 0, it means begin date is future.
        // Full refund. 
        if (daysBetween(0, $post->beginAt) > 0) {
            $action = 'advertisement.cancel';
            $days = daysBetween($post->beginAt, $post->endAt) + 1;
        }
        // else, past days including today will be deducted.
        else {
            $days = daysBetween(0, $post->endAt);
            if ($days < 1) $days = 0;
            else $days++;
        }
        // get settings
        $in[COUNTRY_CODE] = $post->countryCode;
        $settings = advertisement()->getAdvertisementSetting($in);


        // get points to refund.
        $pointToRefund = $settings[$post->code] * $days;

        // set advertisementPoint to 0 when the advertisement has stopped.
        $in['advertisementPoint'] = '';

        // Record for change point.
        $activity = userActivity()->changePoint(
            action: $action,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $pointToRefund,
            taxonomy: POSTS,
            categoryIdx: $post->categoryIdx,
            entity: $post->idx
        );

        debug_log("refund apply point; {$activity->toUserPointApply} != {$pointToRefund}");
        if ($activity->toUserPointApply != $pointToRefund) {
            return e()->advertisement_point_refund_failed;
        }

        $post = $post->update($in);
        $post->updateMemoryData('status', 'inactive');
        return $post->response();
    }

    /**
     * Delete advertisement
     * 
     * Advertisements can be deleted if it is inactive, meaning the user's point is refunded.
     */
    public function delete($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $post = post($in[IDX]);
        if ($post->isMine() == false) return  e()->not_your_post;
        if ($post->advertisementPoint) return e()->advertisement_is_active;
        return post($in[IDX])->markDelete()->response();
    }
}
