<?php
use Kreait\Firebase\Messaging\MulticastSendReport;

class PushNotificationTokens extends Entity {
    public function __construct(public int $idx = 0)
    {
        parent::__construct(PUSH_NOTIFICATION_TOKENS, $idx);
    }


    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return PushNotificationTokens
     */
    public function update(array $in): self {

        $token = $in[TOKEN];
        $data = [
            USER_IDX => login()->idx,
            TOKEN => $token,
            DOMAIN => get_domain_name(),
        ];

        if ( $this->exists() == false ) {
            parent::create($data);
        } else {
            parent::update($data);
        }

        if (isset($in[TOPIC]) && !empty($in[TOPIC])) {
            $re = subscribeTopic($in[TOPIC], $token);
        } else {
            $re = subscribeTopic(DEFAULT_TOPIC, $token);
        }

        if ($re && isset($re['results']) && count($re['results']) && isset($re['results'][0]['error'])) {
            return $this->error(e()->topic_subscription);
        }

        return $this;
    }

    /**
     * Returns tokens of login user in an array
     * @param string $userIdx
     * @return array
     * @throws Exception
     */
    function getTokens(string $userIdx) :array
    {
        $rows = parent::search(where: "userIdx=$userIdx", select: 'token');
        return ids($rows, 'token');
    }

    /**
     * @return array
     * @throws Exception
     */
    function myTokens(): array {
        return $this->getTokens( login()->idx );
    }
}


/**
 * @param int|string $idx
 * @return PushNotificationTokens
 */
function token(int|string $idx=0): PushNotificationTokens
{
    if ( is_numeric($idx) ) return new PushNotificationTokens($idx);
    return (new PushNotificationTokens())->findOne([TOKEN => $idx]);

//    $record = entity(PUSH_NOTIFICATION_TOKENS, 0)->get(TOKEN, $idx);
//    if ( ! $record ) return new PushNotificationTokens(0);
//    return new PushNotificationTokens($record[IDX]);
}

function sanitizedInput($in): array {
    if ( !isset($in['title'])) $in['title'] = '';
    if ( !isset($in['body'])) $in['body'] = '';
    if ( !isset($in['click_action'])) $in['click_action'] = '/';
    if ( !isset($in['imageUrl'])) $in['imageUrl'] = '';
    if ( !isset($in['data'])) $in['data'] = [];
    $in['data']['senderIdx'] = login()->idx;
    return $in;
}

/**
 * Send messages to all users in $in['users']
 *
 * @param $in
 *  - $in['users'] is an array of user id.
 *
 *
 * @return array|string
 * @throws Exception
 */
function send_message_to_users($in): array|string
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
    foreach ($users as $userIdx) {
        if ( isset($in[SUBSCRIPTION]) ) {
            $re = user($userIdx)->get();
            if ( $re[$in[SUBSCRIPTION]] == 'N' ) continue;
        }
        $tokens = token()->getTokens($userIdx);
        $all_tokens = array_merge($all_tokens, $tokens);
    }
    /// If there are no tokens to send, then it will return empty array.
    if (empty($all_tokens)) return e()->token_is_empty;
    $in = sanitizedInput($in);
    $re = sendMessageToTokens($all_tokens, $in['title'], $in['body'], $in['click_action'], $in['data'], $in['imageUrl']);

    return [
        'tokens' => $all_tokens
    ];
}


/**
 * @param array $idxs
 * @param null $filter 'notifyComment' || 'notifyPost'
 * @return array
 */
function getTokensFromUserIDs($idxs = [], $filter = null): array
{
    $tokens = [];
    foreach ($idxs as $idx) {
        $rows = token()->getTokens($idx);
        if ($filter) {
            $user = user($idx)->getData();
            if (isset($user[$filter]) && $user[$filter] == 'N') {
            } else {
                foreach ($rows as $token) {
                    $tokens[] = $token;
                }
            }
        } else {
            foreach ($rows as $token) {
                $tokens[] = $token;
            }
        }
    }
    return $tokens;
}


