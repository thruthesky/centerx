<?php

class AdvertisementController {

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
    public function edit($in) {
        if ( isset($in['idx']) && $in['idx'] ) {
            // @todo check point


            $in['pointPerDay'] = 0;




            return post()->create($in)->response();
        } else {
            $post = post($in[IDX]);
            if ( $post->isMine() == false ) return  e()->not_your_post;
            return $post->update($in)->response();
        }
    }
    public function delete($in) {
        $post = post($in[IDX]);
        if ( $post->endAt ) return e()->advertisement_is_active;
        return post($in[IDX])->markDelete()->response();
    }

}