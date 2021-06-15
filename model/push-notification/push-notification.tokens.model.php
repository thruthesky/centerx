<?php
/**
 * @file push-notification.token.model.php
 */

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

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
        if (isset($in[TOPIC]) && $in[TOPIC]) {
            $multiTopics = $in[TOPIC];
        } else {
            $multiTopics = DEFAULT_TOPIC;
        }


//        $multiTopics = $in[TOPIC] ?? DEFAULT_TOPIC;

        $topics = explode(',', $multiTopics);
//        d($topics);
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

/**
 * Send messages to all users in $in['users'] and/or $in['emails']
 *
 * @param $in
 *  - $in['users'] is an array of user idx.
 *  - $in['emails'] is an array of user email.
 *
 *
 * @return array|string
 */
function send_message_to_users($in): array|string
{
    if (!isset($in[USERS]) && !isset($in[EMAILS])) return e()->users_and_emails_is_empty;
    if (!isset($in[TITLE])) return e()->title_is_not_exist;
    if (!isset($in[BODY])) return e()->body_is_not_exist;


    $users = [];

    /**
     * check if [emails] is exist and not empty
     * it get the user idx and pass to $users
     */
    if (isset($in[EMAILS]) && !empty($in[EMAILS])) {
        if (gettype($in[EMAILS]) == 'array') {
            $emails = $in[EMAILS];
        } else {
            $emails = preg_replace('/\s+/', '', $in[EMAILS]);
            $emails = explode(',', $emails);
        }

        // check if email exist and get user idx
        foreach ($emails as $email) {
            $u = user()->findOne([EMAIL => $email]);
            if ($u->hasError) continue; // if user() has error continue. entity not found
            $users[] = $u->idx;
        }

    }

    /**
     * check if [users] is exist and not empty
     * merge user idx to $users
     */
    if (isset($in[USERS]) && !empty($in[USERS])) {
        if (gettype($in[USERS]) == 'array') {
            $users = array_merge($users, $in[USERS]);
        } else {
            $users = preg_replace('/\s+/', '', $in[USERS]);
            $users = array_merge($users, explode(',', $users));
        }
    }

    $all_tokens = [];
    if($users) {
        // remove duplicate idx
        $users = array_unique($users);

        // get user tokens
        foreach ($users as $userIdx) {

            if (is_numeric($userIdx)) {
                $user = user($userIdx);
            } else {
                $user = user()->findOne(['firebaseUid'=> $userIdx]);
                if ($user->hasError) continue;
            }

            if ( isset($in[SUBSCRIPTION]) ) {
                if ( $user->v($in[SUBSCRIPTION]) == OFF ) continue;
            }

            $tokens = token()->getTokens($user->idx);
            $all_tokens = array_merge($all_tokens, $tokens);
        }
    }


    /// if no token to send then simply return empty array.
    if (empty($all_tokens)) return [];

    // remove duplicate tokens
    $all_tokens = array_unique($all_tokens);

    //send message to all unique tokens
    try {
        $re = sendMessageToTokens($all_tokens, $in);
    } catch (MessagingException | FirebaseException $e) {
        return err(e()->failed_send_message_to_tokens, $e);
    }

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


