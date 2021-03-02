<?php

class PushNotificationTokens extends Entity {
    public function __construct(int $idx)
    {
        parent::__construct(PUSH_NOTIFICATION_TOKENS, $idx);
    }
}


/**
 * @param int|string $idx
 * @return PushNotificationTokens
 */
function token(int|string $idx=0) {
    if ( is_numeric($idx) ) return new PushNotificationTokens($idx);
    $record = entity(PUSH_NOTIFICATION_TOKENS, 0)->get(TOKEN, $idx);
    if ( ! $record ) return new PushNotificationTokens(0);
    return new PushNotificationTokens($record[IDX]);
}