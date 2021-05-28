<?php
/**
 * @file push-notification.token.model.php
 */
/**
 * Class PushNotificationTokenModel
 *
 * @property-read string $topic
 * @property-read string $token
 */
class PushNotificationTokenModel extends Entity {
    public function __construct(public int $idx = 0)
    {
        parent::__construct(PUSH_NOTIFICATION_TOKENS, $idx);
    }


    /**
     *
     * Note, it may creates many records. so, the return data is an array of the class.
     *
     * @attention To update, entity.idx must be set properly.
     *
     *
     * @param array $in
     *  $in['token'] = 'token-abc...'
     *  $in['topic'] = 'Apple,Banana,Cherry'
     *
     * @return PushNotificationTokenModel[]
     */
    public function save(array $in): array {
        $token = $in[TOKEN];
        $multiTopics = $in[TOPIC] ?? DEFAULT_TOPIC;

        $topics = explode(',', $multiTopics);

        $rets = [];
        foreach($topics as $topic) {

            // Token is being saved (Even if it fails on subscribing to the topics)
            $obj = token()->findOne([TOKEN => $token, TOPIC => $topic]);
            if ( $obj->exists ) {
                $obj->update( [ USER_IDX => login()->idx ] );
            } else {
                $obj->create([
                    USER_IDX => login()->idx,
                    TOKEN => $token,
                    TOPIC => $topic,
                ]);
            }

            $re = subscribeTopic($topic, $token);

            if ($re) {
                foreach( $re as $_topic ) {
                    foreach( $_topic as $_token => $error ) {
                        if ( $error != 'OK' ) {
                            $obj->error(e()->topic_subscription . ':' . $error);
                            $rets[$obj->topic] = $obj->getError();
                        } else {
                            $rets[ $obj->topic ] = true;
                        }
                    }
                }
            } else {
                $rets[ $obj->topic ] = true;
            }
        }

        return $rets;
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
     * Returns tokens of login user in an array
     * @param int $userIdx
     * @return array
     * @throws Exception
     */
    function getTopics(int $userIdx) :array
    {
        $rows = parent::search(select: 'topic', where: "userIdx=?", params: [$userIdx]);
        return ids($rows, 'topic');
    }

    /**
     * @return array
     * @throws Exception
     */
    function myTokens(): array {
        return $this->getTokens( login()->idx );
    }

    /**
     * @return array
     * @throws Exception
     */
    function myTopics(): array {
        return $this->getTopics( login()->idx );
    }
}



/**
 * @param int|string $idx
 * @return PushNotificationTokenModel
 */
function token(int|string $idx=0): PushNotificationTokenModel
{
    if ( is_numeric($idx) ) return new PushNotificationTokenModel($idx);
    return (new PushNotificationTokenModel())->findOne([TOKEN => $idx]);
}

function sanitizedInput($in): array {
    if ( !isset($in[TITLE])) $in[TITLE] = '';
    if ( !isset($in[BODY])) $in[BODY] = '';
    if ( !isset($in[CLICK_ACTION])) $in[CLICK_ACTION] = '/';
    if ( !isset($in[IMAGE_URL])) $in[IMAGE_URL] = '';
    if ( !isset($in[SOUND])) $in[SOUND] = 'default';
    if ( !isset($in[CHANNEL])) $in[CHANNEL] = '';
    if ( !isset($in[DATA])) $in[DATA] = [];
    if ( !isset($in[DATA][IDX]) && isset($in[IDX])) $in[DATA][IDX] = $in[IDX];
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


