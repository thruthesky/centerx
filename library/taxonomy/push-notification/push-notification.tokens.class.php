<?php
use Kreait\Firebase\Messaging\MulticastSendReport;

class PushNotificationTokenTaxonomy extends Entity {
    public function __construct(public int $idx = 0)
    {
        parent::__construct(PUSH_NOTIFICATION_TOKENS, $idx);
    }


    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return PushNotificationTokenTaxonomy
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
     * @param int $userIdx
     * @return array
     * @throws Exception
     */
    function getTokens(int $userIdx) :array
    {
        $rows = parent::search(select: 'token', where: "userIdx=?", params: [$userIdx]);
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
 * @return PushNotificationTokenTaxonomy
 */
function token(int|string $idx=0): PushNotificationTokenTaxonomy
{
    if ( is_numeric($idx) ) return new PushNotificationTokenTaxonomy($idx);
    return (new PushNotificationTokenTaxonomy())->findOne([TOKEN => $idx]);

//    $record = entity(PUSH_NOTIFICATION_TOKENS, 0)->get(TOKEN, $idx);
//    if ( ! $record ) return new PushNotificationTokenTaxonomy(0);
//    return new PushNotificationTokenTaxonomy($record[IDX]);
}

function sanitizedInput($in): array {
    if ( !isset($in[TITLE])) $in[TITLE] = '';
    if ( !isset($in[BODY])) $in[BODY] = '';
    if ( !isset($in[CLICK_ACTION])) $in[CLICK_ACTION] = '/';
    if ( !isset($in[IMAGE_URL])) $in[IMAGE_URL] = '';
    if ( !isset($in[SOUND])) $in[SOUND] = 'default';
    if ( !isset($in[CHANNEL])) $in[CHANNEL] = '';
    if ( !isset($in[DATA])) $in[DATA] = [];
    $in[DATA]['senderIdx'] = login()->idx;
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
    if (!isset($in[USERS])) return e()->users_is_empty;
    if (!isset($in[TITLE])) return e()->title_is_not_exist;
    if (!isset($in[BODY])) return e()->body_is_not_exist;
    $all_tokens = [];

    if (gettype($in[USERS]) == 'array') {
        $users = $in[USERS];
    } else {
        $users = explode(',', $in[USERS]);
    }
    foreach ($users as $userIdx) {

        if (is_numeric($userIdx)) {
            $user = user($userIdx);
        } else {
            $user = user()->findOne(['firebaseUid'=> $userIdx]);
        }

        if ( isset($in[SUBSCRIPTION]) ) {
            if ( $user->v($in[SUBSCRIPTION]) == OFF ) continue;
        }

        $tokens = token()->getTokens($user->idx);
        $all_tokens = array_merge($all_tokens, $tokens);
    }
    /// If there are no tokens to send, then it will return empty array.
//    if (empty($all_tokens)) return e()->token_is_empty;

    /// if no token to send then simply return empty array.
    if (empty($all_tokens)) return [];
    $in = sanitizedInput($in);
    $re = sendMessageToTokens($all_tokens, $in[TITLE], $in[BODY], $in[CLICK_ACTION], $in[DATA], $in[IMAGE_URL], $in[SOUND]);
    $res = [];
    foreach($re->getItems() as $item) {
        $res[] = $item->result();
    }

    // @todo handle invalid/unknown tokends..
    // @how to properly return response here.

    return $res;
}


/**
 * Return user tokens of the users who want to have notifications based on their settings.
 * If a user does not want get notification, then the tokens of the user will not be returned.
 *
 * @param array $idxs
 * @param null $filter
 * @return array
 * @throws Exception
 */
function getTokensFromUserIDs($idxs = [], $filter = null): array
{
    $tokens = [];
    foreach ($idxs as $idx) {
        $rows = token()->getTokens($idx);
        if ($filter) {
            if (user($idx)->v($filter) == OFF) {
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


