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
        if ( !isset($in[TOKENS]) ) return e()->tokens_is_empty;
        $in = sanitizedInput($in);
        return sendMessageToTokens($in[TOKENS], $in[TITLE], $in[BODY], $in[CLICK_ACTION], $in[DATA], $in[IMAGE_URL]);
    }




    /**
     * @param $in
     * @return array|string
     */
    public function sendMessageToTopic($in): array|string {
        if ( !isset($in[TOPIC]) ) return e()->topic_is_empty;
        $in = sanitizedInput($in);
        return sendMessageToTopic($in[TOPIC], $in[TITLE], $in[BODY], $in[CLICK_ACTION], $in[DATA], $in[IMAGE_URL]);
    }


    /**
     * @param $in
     * @return array|string
     * @throws Exception
     */
    public function sendMessageToUsers($in):array|string {
        return send_message_to_users($in);
    }


    /**
     * @param $in
     *  $in['tokens'] can be a string of tokens or an array of tokens.
     *  If $in['tokens'] is not provided, then it will subscribe all the tokens of login user to the topic.
     * @return array|string
     * @throws Exception
     */
    public function subscribeTopic($in): array|string
    {
        return pushNotification()->subscribeTopic($in);
    }




    /**
     * @param $in
     *  $in['tokens'] can be a string of tokens or an array of tokens.
     *  If $in['tokens'] is not provided, then it will unsubscribe all the tokens of login user from the topic.
     * @return array|string
     * @throws Exception
     */
    public function unsubscribeTopic($in): array|string
    {
        return pushNotification()->unsubscribeTopic($in);
    }


    /**
     * @param $in
     * @return array|string
     * @throws Exception
     */
    public function topicSubscription($in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[TOPIC]) && empty($in[TOPIC]) ) return e()->topic_is_empty;
        if ( my($in[TOPIC]) == "Y") {
            return $this->unsubscribeTopic($in);
        } else {
            return $this->subscribeTopic($in);
        }
    }


}