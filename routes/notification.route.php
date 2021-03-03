<?php



class NotificationRoute {

    /**
     *
     * @param $in
     *
     * @example how to access
     *
     * http://domain/index.php?route=notification.updateToken&token=ebyHPOGMSqmwEMeK2PE7jx%3AAPA91bEBTmyYTWxUXKdypgeC5jKxJ6nXL27EQN9NTe1U6GTSlchv2ZGKVXKfjk_yA6T-hfHh-vRxqJzFb_rrWVSxQJKB5ZNBHQ21kLd_Dt-4PAguVF1hh13HeH2NPGFyaaLwFAxYMh5v&topic
     *
     * @return array|string
     *
     * @note expected result
     *
     * {"response":{"idx":"1","userIdx":"0","token":"ebyHPOGMSqmwEMeK2PE7jx:APA91bEBTmyYTWxUXKdypgeC5jKxJ6nXL27EQN9NTe1U6GTSlchv2ZGKVXKfjk_yA6T-hfHh-vRxqJzFb_rrWVSxQJKB5ZNBHQ21kLd_Dt-4PAguVF1hh13HeH2NPGFyaaLwFAxYMh5v","domain":"192.168.100.17","createdAt":"1614768786","updatedAt":"1614771526"},"request":{"route":"notification.updateToken","token":"ebyHPOGMSqmwEMeK2PE7jx:APA91bEBTmyYTWxUXKdypgeC5jKxJ6nXL27EQN9NTe1U6GTSlchv2ZGKVXKfjk_yA6T-hfHh-vRxqJzFb_rrWVSxQJKB5ZNBHQ21kLd_Dt-4PAguVF1hh13HeH2NPGFyaaLwFAxYMh5v","topic":""}}
     *
     */
    public function updateToken($in): array|string
    {
        if (!isset($in[TOKEN])) return e()->token_is_empty;
        return token($in[TOKEN])->update($in);
    }

    /**
     * @param $in
     * $in['tokens'] can be a string of a token or an array of tokens
     *
     * @return array|string
     */
    public function sendMessageToTokens($in): array|string {
        if ( !isset($in['tokens']) ) return e()->token_is_empty;
        $in = sanitizedInput($in);
        return sendMessageToTokens($in['tokens'], $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);
    }




    /**
     * @param $in
     * @return array|string
     */
    public function sendMessageToTopic($in): array|string {
        if ( !isset($in['topic']) ) return e()->topic_is_empty;
        $in = sanitizedInput($in);
        return sendMessageToTopic($in['topic'], $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);
    }


    /**
     * @param $in
     * @return MulticastSendReport|string
     */
    public function sendMessageToUsers($in):MulticastSendReport|string {
        return send_message_to_users($in);
    }



//
//    /**
//     * @param $in
//     *  $in['tokens'] can be a string of tokens or an array of tokens.
//     *  If $in['tokens'] is not provided, then it will subscribe all the tokens of login user to the topic.
//     * @return mixed
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     */
//    public function subscribeTopic($in) {
//        if ( ! is_user_logged_in() ) return ERROR_LOGIN_FIRST;
//        if ( ! isset($in['topic']) && empty($in['topic']) ) return ERROR_EMPTY_TOPIC;
//        if ( isset($in['tokens'] ) ) $tokens = $in['tokens'];
//        else {
//            $tokens = get_user_tokens();
//        }
//        if ( empty($tokens) ) return ERROR_EMPTY_TOKENS;
//        $re = subscribeTopic($in['topic'], $tokens);
//        user_update_meta(wp_get_current_user()->ID, [ $in['topic'] => 'Y' ]);
//        return $re;
//    }
//
//
//    /**
//     * @param $in
//     *  $in['tokens'] can be a string of tokens or an array of tokens.
//     *  If $in['tokens'] is not provided, then it will unsubscribe all the tokens of login user from the topic.
//     * @return mixed
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     */
//    public function unsubscribeTopic($in) {
//        if ( ! is_user_logged_in() ) return ERROR_LOGIN_FIRST;
//        if ( ! isset($in['topic']) && empty($in['topic']) ) return ERROR_EMPTY_TOPIC;
//        if ( isset($in['tokens'] ) ) $tokens = $in['tokens'];
//        else {
//            $tokens = get_user_tokens();
//        }
//        $re = unsubscribeTopic($in['topic'], $tokens);
//        delete_user_meta(wp_get_current_user()->ID, $in['topic']);
//        return $re;
//    }
//
//    public function topicSubscription($in) {
//        if ( ! is_user_logged_in() ) return ERROR_LOGIN_FIRST;
//        if ( ! isset($in['topic']) && empty($in['topic']) ) return ERROR_EMPTY_TOPIC;
//        $sub = get_user_meta(wp_get_current_user()->ID, $in['topic'], true) == "Y";
//        if ( !$sub ) {
//            $this->subscribeTopic($in);
//        } else {
//            $this->unsubscribeTopic($in);
//        }
//        return profile();
//    }
//
//    /**
//     * Chat does not subscribe topic! When there is a new messages, it gets all tokens of the user and send push notificatoin.
//     *
//     * @param $in
//     * @return array|string
//     */
//    public function chatSubscription($in) {
//        if ( ! is_user_logged_in() ) return ERROR_LOGIN_FIRST;
//        if ( ! isset($in['topic']) && empty($in['topic']) ) return ERROR_EMPTY_TOPIC;
//        $sub = get_user_meta(wp_get_current_user()->ID, $in['topic'], true);
//        if ( $sub == "Y" ) {
//            user_update_meta(wp_get_current_user()->ID, [ $in['topic'] => 'N' ]);
//        } else {
//            user_update_meta(wp_get_current_user()->ID, [ $in['topic'] => 'Y' ]);
//        }
//        return profile();
//    }

}