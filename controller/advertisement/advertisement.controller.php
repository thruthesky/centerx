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
     */
    public function edit($in)
    {
        if (isset($in['idx']) && $in['idx']) {

            $post = post($in[IDX]);
            if ($post->isMine() == false) return  e()->not_your_post;
            return $post->update($in)->response();
        } else {
            $in['pointPerDay'] = 0;
            $beginAt = dateToTime($in[BEGIN_AT] ?? '');
            $endAt = dateToTime($in[END_AT] ?? '');
            $days = daysBetween($beginAt, $endAt);

            if (isset(ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]])) {
                $settings = ADVERTISEMENT_SETTINGS['point'][$in[COUNTRY_CODE]];
            } else {
                $settings = ADVERTISEMENT_SETTINGS['point']['default'];
            }

            $pointPerDay = $settings[$in[CODE]];

            $pointToDeduct = $pointPerDay * $days;

            // check if the user has enough point
            if (login()->getPoint() < $pointToDeduct) {
                return e()->lack_of_point;
            }

            $category = category(ADVERTISE_CATEGORY);

            // Record for post creation and change point.
            $activity = userActivity()->changePoint(
                action: 'advertisement',
                fromUserIdx: 0,
                fromUserPoint: 0,
                toUserIdx: login()->idx,
                toUserPoint: -$pointToDeduct,
                taxonomy: POSTS,
                categoryIdx: $category->idx,
            );

            $in[CATEGORY_ID] = ADVERTISE_CATEGORY;
            $post = post()->create($in);

            $activity->update([ENTITY => $post->idx]);
            return $post->response();
        }
    }
    public function delete($in)
    {
        $post = post($in[IDX]);
        if ($post->endAt) return e()->advertisement_is_active;
        return post($in[IDX])->markDelete()->response();
    }
}
