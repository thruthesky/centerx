<?php

class PushNotificationTokens extends Entity {
    public function __construct(int $idx)
    {
        parent::__construct(PUSH_NOTIFICATION_TOKENS, $idx);
    }


    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string {


        $userIdx = my(IDX) ?? 0;
        if ( $this->exists() == false ) {
            $res = parent::create([
                USER_IDX => $userIdx,
                TOKEN => $in[TOKEN],
            ]);
        } else {
            $res = parent::update([
                USER_IDX => $userIdx,
                TOKEN => $in[TOKEN],
            ]);
        }

        // @TODO add topic subscription

        return $res;
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