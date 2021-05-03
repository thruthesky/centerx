<?php

class PushNotification {


    /**
     * @param $in
     *  if $in['tokens'] a string or an array of string to subscribe with the topic.
     *  If $in['tokens'] is not given, then it will use the login user's tokens to subscribe to the topic.
     * @return array|string
     * @throws Exception
     */
    public function subscribeTopic($in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[TOPIC]) && empty($in[TOPIC]) ) return e()->topic_is_empty;
        if ( ! isset($in[TOKENS])) $in[TOKENS] = token()->myTokens();

        $res = subscribeTopic($in[TOPIC], $in[TOKENS]);
        return login()->switchOn($in[TOPIC])->response();
    }

    public function unsubscribeTopic($in): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[TOPIC]) && empty($in[TOPIC]) ) return e()->topic_is_empty;
        if ( ! isset($in[TOKENS])) $in[TOKENS] = token()->myTokens();

        $res = unsubscribeTopic($in[TOPIC], $in[TOKENS]);
        return login()->switchOff($in[TOPIC])->response();
    }





    /**
     * $tokens can be a string of a token or an array of tokens
     *
     *  http://domain/index.php?route=notification.sendMessageToTokens&tokens=ebyHPOGMSqmwEMeK2PE7jx%3AAPA91bEBTmyYTWxUXKdypgeC5jKxJ6nXL27EQN9NTe1U6GTSlchv2ZGKVXKfjk_yA6T-hfHh-vRxqJzFb_rrWVSxQJKB5ZNBHQ21kLd_Dt-4PAguVF1hh13HeH2NPGFyaaLwFAxYMh5v&title=Dalgona+Push+notification+token&body=This+is+a+test+push+notification+token&imageUrl&sessionId=6-e420d272e3c91ab7c15b3c5cdc2d8d62
     *
     * @return array|string
     */
    public function send(array|string $tokens='', string $title='', string $body='', string $clickAction='/',
                                        string $imageUrl='', array $data=[]): array|string {
        if ( !isset($tokens) ) return e()->tokens_is_empty;
        $data['senderIdx'] = login()->idx;
        $re = sendMessageToTokens($tokens, $title, $body, $clickAction, $data, $imageUrl);
        $res = [];
        foreach($re->getItems() as $item) {
            $res[] = $item->result();
        }
        // @todo handle invalid/unknown tokends..
        // @how to properly return response here.
        return $res;
    }



}

/**
 * @return PushNotification
 */
function pushNotification(): PushNotification {
    return new PushNotification();
}
