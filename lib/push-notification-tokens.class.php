<?php
use Kreait\Firebase\Messaging\MulticastSendReport;

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

        $token = $in[TOKEN];
        $data = [
            USER_IDX => my(IDX) ?? 0,
            TOKEN => $token,
            DOMAIN => get_domain_name(),
        ];

        if ( $this->exists() == false ) {
            $res = parent::create($data);
        } else {
            $res = parent::update($data);
        }

        if (isset($in[TOPIC]) && !empty($in[TOPIC])) {
            $re = subscribeTopic($in[TOPIC], $token);
        } else {
            $re = subscribeTopic(DEFAULT_TOPIC, $token);
        }

        if ($re && isset($re['results']) && count($re['results']) && isset($re['results'][0]['error'])) {
            return e()->topic_subscription;
        }

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

function sanitizedInput($in): array {
    if ( !isset($in['title'])) $in['title'] = '';
    if ( !isset($in['body'])) $in['body'] = '';
    if ( !isset($in['click_action'])) $in['click_action'] = '/';
    if ( !isset($in['imageUrl'])) $in['imageUrl'] = '';
    if ( !isset($in['data'])) $in['data'] = [];
    $in['data']['senderId'] = my(IDX);
    return $in;
}

/**
 * Send messages to all users in $in['users']
 *
 * @param $in
 *  - $in['users'] is an array of user id.
 *
 *
 * @return MulticastSendReport|string
 */
function send_message_to_users($in): MulticastSendReport|string
{
    if (!isset($in['users'])) return e()->users_is_empty;
    if (!isset($in['title'])) return e()->title_is_not_exist;
    if (!isset($in['body'])) return e()->body_is_not_exist;
    $all_tokens = [];

    if (gettype($in[USERS]) == 'array') {
        $users = $in[USERS];
    } else {
        $users = explode(',', $in[USERS]);
    }
        foreach ($users as $IDX) {
            if ( isset($in[SUBSCRIPTION]) ) {
                $re = user($IDX)->get( $in['subscription'], true);
                if ( $re == 'N' ) continue;
            }
            $tokens = get_user_tokens($IDX);
            $all_tokens = array_merge($all_tokens, $tokens);
        }
        /// If there are no tokens to send, then it will return empty array.
        if (empty($all_tokens)) return e()->token_is_empty;
        if (!isset($in['imageUrl'])) $in['imageUrl'] = '';

        if ( !isset($in['data'])) $in['data'] = [];
        if ( !isset($in['click_action'])) $in['click_action'] = '/';
        $in['data']['senderId'] =  my(IDX);
        $re = sendMessageToTokens($all_tokens, $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);
//    print_r($re);
        return [
            'tokens' => $all_tokens
        ];
}

/**
 * Returns tokens of login user in an array
 * @return array|object|null
 *
 */
function get_user_tokens($IDX = null) :array|object|null
{
    global $wpdb;
    if ($IDX) $user_ID = $IDX;
    else $user_ID = my(IDX);

//    $rows = $wpdb->get_results("SELECT * FROM " . PUSH_TOKENS_TABLE .  " WHERE user_ID='$user_ID'", ARRAY_A);
    $rows = token()->search();
    return ids($rows, 'token');
}