<?php

class AdvertisementController
{

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
        if (!isset($in[CODE]) || empty($in[CODE])) return e()->empty_code;

        // check dates input
        if ( !isset($in['beginDate']) || empty($in['beginDate']) ) return e()->empty_begin_date;
        if ( !isset($in['endDate']) || empty($in['endDate']) ) return e()->empty_end_date;

        // Save point per day. This will be saved in meta.
        $in['pointPerDay'] = 0;

        $in = $post->updateBeginEndDate($in);

        // add 1 to include beginning date.
        $days = daysBetween($in[BEGIN_AT], $in[END_AT]) + 1;

        if (isset($in[COUNTRY_CODE]) && isset(ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]])) {
            $settings = ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]];
        } else {
            $settings = ADVERTISEMENT_SETTINGS['point']['default'];
        }

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
     * It checks if the advertisement
     */
    public function stop($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $post = post($in[IDX]);


        // reset advertisementPoint marking it as inactive.
        $in['advertisementPoint'] = 0;

        if (isset(ADVERTISEMENT_SETTINGS['point'][$post->countryCode])) {
            $settings = ADVERTISEMENT_SETTINGS['point'][$post->countryCode];
        } else {
            $settings = ADVERTISEMENT_SETTINGS['point']['default'];
        }

        // get number of days to refund.
        $days = 0;
        $pointToRefund = 0;
        // if days between now and beginAt is bigger than 0, it means begin date is future.
        // Full refund. 
        if (daysBetween(0, $post->beginAt) > 0) {
            $days = daysBetween($post->beginAt, $post->endAt) + 1;
        }
        // else, past days including today will be deducted.
        // will only count 
        else {
            $days = daysBetween(0, $post->endAt);
            if ($days < 1) $days = 0;
            else $days++;
        }

        // get points to refund.
        $pointToRefund = $settings[$post->code] * $days;

        // Record for change point.
        $activity = userActivity()->changePoint(
            action: 'advertisement.stop',
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
        return $post->response();
    }

    /**
     * Delete advertisement
     * 
     * Advertisements can be deleted if it is inactive, meaning the user's point is refunded.
     * 
     * @todo test to see if the advertisement is active
     */
    public function delete($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $post = post($in[IDX]);
        if ($post->endAt) return e()->advertisement_is_active;
        return post($in[IDX])->markDelete()->response();
    }
}
