<?php

class PushNotification {


    /**
     * @param $in
     *  if $in['tokens'] a string or an array of string to subscribe with the topic.
     *  If $in['tokens'] is not given, then it will use the login user's tokens to subscribe to the topic.
     * @return array|string
     * @throws Exception
     */
    public function subscribeTopic($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[TOPIC]) && empty($in[TOPIC]) ) return e()->topic_is_empty;
        if ( ! isset($in[TOKENS])) $in[TOKENS] = token()->myTokens();

        $res = subscribeTopic($in[TOPIC], $in[TOKENS]);
        return login()->update( [ $in[TOPIC] => 'Y' ]);
    }

    public function unsubscribeTopic($in) {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[TOPIC]) && empty($in[TOPIC]) ) return e()->topic_is_empty;
        if ( ! isset($in[TOKENS])) $in[TOKENS] = token()->myTokens();

        $res = unsubscribeTopic($in[TOPIC], $in[TOKENS]);
        return login()->update( [ $in[TOPIC] => 'N' ]);
    }




}

/**
 * @return PushNotification
 */
function pushNotification(): PushNotification {
    return new PushNotification();
}
