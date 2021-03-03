<?php

class NotificationRoute {

//    /**
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     *
//     * @example how to access
//     *
//     * http://local.wordpress.org/wordpress-api-v2/php/api.php?method=pushNotification.tokenUpdate&token=c36jia8q_4qMm05fRhQ0_r:APA91bGB0en7xx3h1QF8jGaGF84qalp1JDzbfI5Kt9Klx02y3BUfaEloP57sfyYOXXpuTTMU3Fw7DJ-kNsf5qkGnA2V1NqwhLH7vlLQCCpeJgz-kqfhYBauhycOwVkkEIx6Z8yVO7nWe&topic=abc
//     *
//     * @note expected result
//     *
//     * {"code":0,"data":{"token":"c36jia8q_4qMm05fRhQ0_r:APA91bGB0en7xx3h1QF8jGaGF84qalp1JDzbfI5Kt9Klx02y3BUfaEloP57sfyYOXXpuTTMU3Fw7DJ-kNsf5qkGnA2V1NqwhLH7vlLQCCpeJgz-kqfhYBauhycOwVkkEIx6Z8yVO7nWe","user_ID":"0","type":"","stamp":"1579611552"},"method":"pushNotification.tokenUpdate"}
//     *
//     */
    public function updateToken($in)
    {
        if (!isset($in[TOKEN])) return e()->token_is_empty;
        return token($in[TOKEN])->update($in);
    }

//    /**
//     *
//     * $in['tokens'] can be a string of a token or an array of tokens
//     *
//     * @return array|string
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     */
//    public function sendMessageToTokens($in) {
//        if ( !isset($in['tokens']) ) return ERROR_EMPTY_TOKENS;
//        if ( !isset($in['title'])) $in['title'] = '';
//        if ( !isset($in['body'])) $in['body'] = '';
//        if ( !isset($in['click_action'])) $in['click_action'] = '/';
//        if ( !isset($in['imageUrl'])) $in['imageUrl'] = '';
//
//        if ( !isset($in['data'])) $in['data'] = [];
//        $in['data']['senderId'] = wp_get_current_user()->ID;
//        return sendMessageToTokens($in['tokens'], $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);
//    }
//
//    /**
//     * @param $in
//     * @return array|string
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     */
//    public function sendMessageToTopic($in) {
//        if ( !isset($in['topic']) ) return ERROR_EMPTY_TOPIC;
//        if ( !isset($in['title'])) $in['title'] = '';
//        if ( !isset($in['body'])) $in['body'] = '';
//        if ( !isset($in['click_action'])) $in['click_action'] = '/';
//        if ( !isset($in['imageUrl'])) $in['imageUrl'] = '';
//
//        if ( !isset($in['data'])) $in['data'] = [];
//        $in['data']['senderId'] = wp_get_current_user()->ID;
//        return sendMessageToTopic($in['topic'], $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);
//    }
//
//
//    /**
//     * @param $in
//     * @return \Kreait\Firebase\Messaging\MulticastSendReport
//     * @throws \Kreait\Firebase\Exception\FirebaseException
//     * @throws \Kreait\Firebase\Exception\MessagingException
//     */
//    public function sendMessageToUsers($in) {
//        return send_message_to_users($in);
//    }
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