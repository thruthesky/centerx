<?php


use Kreait\Firebase\Messaging\SendReport;

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
        return token($in[TOKEN])->update($in)->getData();
    }

    /**
     * @param $in
     * $in['tokens'] can be a string of a token or an array of tokens
     *
     *  http://domain/index.php?route=notification.sendMessageToTokens&tokens=ebyHPOGMSqmwEMeK2PE7jx%3AAPA91bEBTmyYTWxUXKdypgeC5jKxJ6nXL27EQN9NTe1U6GTSlchv2ZGKVXKfjk_yA6T-hfHh-vRxqJzFb_rrWVSxQJKB5ZNBHQ21kLd_Dt-4PAguVF1hh13HeH2NPGFyaaLwFAxYMh5v&title=Dalgona+Push+notification+token&body=This+is+a+test+push+notification+token&imageUrl&sessionId=6-e420d272e3c91ab7c15b3c5cdc2d8d62
     *
     * @return array|string
     */
    public function sendMessageToTokens($in): array|string {
        if ( !isset($in[TOKENS]) ) return e()->tokens_is_empty;
        $in = sanitizedInput($in);
        $re = sendMessageToTokens($in[TOKENS], $in[TITLE], $in[BODY], $in[CLICK_ACTION], $in[DATA], $in[IMAGE_URL], $in[SOUND], $in[CHANNEL]);
//        d($re->getItems());exit;
        $res = [
            'success' => [],
            'error' => []
        ];
        foreach($re->getItems() as $item) {
            if ($item->isSuccess()) $res['success'][] = $item->result();
            else if ($item->isFailure()) $res['error'][] = $item->error()->getMessage();
        }

        return $res;
    }




    /**
     * @param $in
     *
     * @example
     *
     * http://domain/index.php?route=notification.sendMessageToTopic&topic=defaultTopic123&title=Dalgona+Push+notification+DefaultTopic&body=This+is+a+test+push+notification+DefaultTopic&imageUrl&sessionId=6-e420d272e3c91ab7c15b3c5cdc2d8d62
     *
     *
     * @return array|string
     */
    public function sendMessageToTopic($in): array|string {
        if ( !isset($in[TOPIC]) ) return e()->topic_is_empty;
        $in = sanitizedInput($in);
        return sendMessageToTopic($in[TOPIC], $in[TITLE], $in[BODY], $in[CLICK_ACTION], $in[DATA], $in[IMAGE_URL], $in[SOUND], $in[CHANNEL]);
    }


    /**
     *
     * @example
     *
     * http://domain/index.php?route=notification.sendMessageToUsers&users=6&title=Dalgona+Push+notification+DefaultTopic&body=This+is+a+test+push+notification+DefaultTopic&imageUrl&sessionId=6-e420d272e3c91ab7c15b3c5cdc2d8d62
     *
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
    public function topicSubscription(array $in): array|string
    {
        if (login()->v($in[TOPIC]) == ON) {
            return $this->unsubscribeTopic($in);
        } else {
            return $this->subscribeTopic($in);
        }
    }


}