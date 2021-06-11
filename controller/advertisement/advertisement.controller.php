<?php

class AdvertisementController
{

    /**
     * @param $in
     * - $in['code'] - is the banner type(position)
     * - $in['countryCode'] is the cafe country.
     * - $in[beginAt] - is the date string of begin date in format of 'YYYY-MM-dd'. ex) "2020-12-12"
     * - $in[endDate] - is the date string of end date.
     * @return array|string
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     *
     * @todo do tests
     * @todo test - check input
     * @todo test - check point deduction
     * @todo test - check cancel
     * @todo test - check refund
     * @todo test - change dates after create banner and check days left.
     * @todo test - compare the point history.
     */
    public function edit($in)
    {

        if (!isset($in[CODE]) || empty($in[CODE])) return e()->empty_code;

        if (isset($in['idx']) && $in['idx']) {
            $post = post($in[IDX]);
            if ($post->isMine() == false) return  e()->not_your_post;
            return $post->update($in)->response();
        } else {

            // Save point per day. This will be saved in meta.
            $in['pointPerDay'] = 0;

            $in = post()->updateBeginEndDate($in);

            $days = daysBetween($in[BEGIN_AT], $in[END_AT]);

            if (isset(ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]])) {
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

            $category = category(ADVERTISE_CATEGORY);

            // Record for post creation and change point.
            $activity = userActivity()->changePoint(
                action: 'advertisement',
                fromUserIdx: 0,
                fromUserPoint: 0,
                toUserIdx: login()->idx,
                toUserPoint: -$in['advertisementPoint'],
                taxonomy: POSTS,
                categoryIdx: $category->idx,
            );

            debug_log("apply point; {$activity->toUserPointApply} != {$in['advertisementPoint']}");
            if ($activity->toUserPointApply != -$in['advertisementPoint']) {
                // @attention !! If this error happens, it is a critical problem.
                // The admin must investigate the database and restore user's point.
                // Then, it needs to rollback the SQL query and needs to have race condition test to prevent the same incident.
                return e()->advertisement_point_deduction_failed;
            }

            $in[CATEGORY_ID] = ADVERTISE_CATEGORY;


            // Save total deducted point from user which the total point for the advertisement.

            $post = post()->create($in);

            $activity->update([ENTITY => $post->idx]);
            return $post->response();
        }
    }

    /**
     * @param $in
     * - $in['idx'] - the advertisement idx.
     */
    public function cancel($in)
    {
        if (!isset($in[IDX]) || empty($in[IDX])) return e()->idx_is_empty;

        $post = post($in[IDX]);

        // update Begin and End date to 0, marking it as inactive advertisement.
        $in = $post->updateBeginEndDate([]);

        if (isset(ADVERTISEMENT_SETTINGS['point'][$post->countryCode])) {
            $settings = ADVERTISEMENT_SETTINGS['point'][$post->countryCode];
        } else {
            $settings = ADVERTISEMENT_SETTINGS['point']['default'];
        }

        // get points to refund.
        $days = daysBetween($post->beginAt, $post->endAt);
        $pointToRefund = $settings[$post->code] * $days;

        // Record for post creation and change point.
        $activity = userActivity()->changePoint(
            action: 'advertisement',
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

    public function delete($in)
    {
        $post = post($in[IDX]);
        if ($post->endAt) return e()->advertisement_is_active;
        return post($in[IDX])->markDelete()->response();
    }
}
