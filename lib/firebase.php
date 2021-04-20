<?php
/**
 * @file firebase.php
 */

use Kreait\Firebase\Database;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;

/**
 * This returns the firebase factory (instance)
 * @return Factory
 *
 * @example
 *  $factory = getFirebase();
 *
 */
function getFirebase() {
    return (new Factory)->withServiceAccount(FIREBASE_ADMIN_SDK_SERVICE_ACCOUNT_KEY_PATH);
}


/**
 * @return \Kreait\Firebase\Contract\Messaging
 *
 * @example
 *  $messaging = getMessaging()
 */
function getMessaging() {
    return getFirebase()->createMessaging();
}

/**
 * Returns Firebase Realtime Database instance.
 *
 * @return \Kreait\Firebase\Contract\Database
 */
function getRealtimeDatabase() {
    return getFirebase()->createDatabase();
}


/**
 * @param string $tokens
 * @param string $title
 * @param string $body
 * @param string $click_action
 * @param array $data
 * @param string $imageUrl
 * @param string $sound
 * @param string $channel
 * @return \Kreait\Firebase\Messaging\MulticastSendReport
 * @throws \Kreait\Firebase\Exception\FirebaseException
 * @throws \Kreait\Firebase\Exception\MessagingException
 */
function sendMessageToTokens(
    string $tokens,
    string $title,
    string $body,
    string $click_action,
    array $data = [],
    string $imageUrl="",
    string $sound = "default",
    string $channel = ''
) {
//    if ( get_phpunit_mode() ) return null;
    $message = CloudMessage::fromArray([
        'notification' => getNotificationData($title, $body, $click_action, $data, $imageUrl),
        'webpush' => getWebPushData($title, $body, $click_action, $data, $imageUrl),
        'android' => getAndroidPushData($channel, $sound),
        'apns' => getIosPushData($title, $body, $sound)->withBadge(1)->jsonSerialize(),
        'data' => $data,
    ]);
//    debug_log($message);

    $arrTokens = explode(',', $tokens);
    return getMessaging()->sendMulticast($message, $arrTokens);
}

/**
 * @param string $topic
 * @param string $title
 * @param string $body
 * @param string $click_action
 * @param array $data
 * @param string $imageUrl
 * @param string $sound
 * @param string $channel
 * @return array
 * @throws \Kreait\Firebase\Exception\FirebaseException
 * @throws \Kreait\Firebase\Exception\MessagingException
 */
function sendMessageToTopic(
    string $topic,
    string $title,
    string $body,
    string $click_action,
    array $data = [],
    string $imageUrl="",
    string $sound = "default",
    string $channel = ''
): array {
    /// If it's phpunit test mode, then don't send it.
    if ( isTesting() ) return [];
    $message = CloudMessage::fromArray([
        'topic' => $topic,
        'notification' => getNotificationData($title, $body, $click_action, $data, $imageUrl),
        'webpush' => getWebPushData($title, $body, $click_action, $data, $imageUrl),
        'android' => getAndroidPushData($channel, $sound),
        'apns' => getIosPushData($title, $body, $sound)->withBadge(1)->jsonSerialize(),
        'data' => $data,
    ]);

    return getMessaging()->send($message);
}

/**
 * @param $topic
 * @param $tokens - a token or an array of tokens
 * @return array
 */
function subscribeTopic($topic, $tokens): array {
    if ( isTesting() ) return [];
    return getMessaging()->subscribeToTopic($topic, $tokens);
}
/**
 * @param $topics - array of topics
 * @param $tokens - a token or an array of tokens
 * @return array
// * @throws \Kreait\Firebase\Exception\FirebaseException
// * @throws \Kreait\Firebase\Exception\MessagingException
 */
function subscribeTopics($topics, $tokens): array {
    if ( isTesting() ) return [];
    return getMessaging()->subscribeToTopics($topics, $tokens);
}

/**
 * @param $tokens - a token or an array of tokens
 * @return array
// * @throws \Kreait\Firebase\Exception\FirebaseException
// * @throws \Kreait\Firebase\Exception\MessagingException
 */
function unsubscribeFromAllTopics($tokens) {
    if ( isTesting() ) return [];
    return getMessaging()->unsubscribeFromAllTopics($tokens);
}

/**
 * @param $topic
 * @param $tokens - a token or an array of tokens
 * @return array
// * @throws \Kreait\Firebase\Exception\FirebaseException
// * @throws \Kreait\Firebase\Exception\MessagingException
 */
function unsubscribeTopic($topic, $tokens): array {
    if ( isTesting() ) return [];
    return getMessaging()->unsubscribeFromTopic($topic, $tokens);
}

/**
 * it look like data and notification is redundant but this is needed here specially for onResume and onLaunch
 * because onResume and onLaunch notification became empty. so we can rely on data to display on ui
 *
 * @param $title
 * @param $body
 * @param $imageUrl
 * @param $clickUrl
 * @param $data
 * @return array
 */
function getData($title, $body, $clickUrl, $data, $imageUrl) {
    $notification = [
        'title' => $title,
        'body' => $body,
        'image' => $imageUrl,
        'click_action' => $clickUrl,
        'data' => $data
    ];
    return $notification;
}

function getNotificationData($title, $body, $clickUrl, $data, $imageUrl) {
    $notification = Notification::fromArray([
        'title' => $title,
        'body' => $body,
        'image' => $imageUrl,
        'click_action' => $clickUrl,
        'data' => $data,
    ]);
    return $notification;
}

function getWebPushData($title, $body, $clickUrl, $data, $imageUrl) {
    $title = mb_strcut($title, 0, 64);
    $body = mb_strcut($body, 0, 128);
    return [
        'notification' => [
            'title' => $title,
            'body' => $body,
            'icon' => $imageUrl,
            'click_action' => $clickUrl ?? "/",
            'data' => $data
        ],
        'fcm_options' => [
            'link' => $clickUrl ?? "/",
        ],
    ];
}


function getIosPushData($title, $body, $sound): ApnsConfig
{
    return ApnsConfig::fromArray([
        'headers' => [
            'apns-priority' => '10',
        ],
        'payload' => [
            'aps' => [
                'alert' => [
                    'title' => $title,
                    'body' => $body,
                ],
            ],
        ],
    ])->withSound($sound);
}

/**
 * @param $channel
 * @param $sound
 * @return AndroidConfig
 */
function getAndroidPushData($channel, $sound): AndroidConfig
{
    $data = [
        'notification' => [
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'channel_id' => 'PUSH_NOTIFICATION', // channel_id is the same as the id you register on the channelMap
//            'notification_count' => 1
        ],
    ];
    if (!empty($channel)) $data['channel_id'] = $channel;
    return AndroidConfig::fromArray($data)->withSound($sound);
}


/**
 * @deprecated Do not use firebase realtime database
 * Update the document under 'notification' in Firebase RealTime Database.
 *
 * @attention $documentPath must begin with `/`.
 *
 * @param string $documentPath database document path. ie) notifications/translations
 * @param mixed $data data to set
 * @throws \Kreait\Firebase\Exception\DatabaseException
 *
 *
 */
function setRealtimeDatabaseDocument($documentPath, $data) {
//    if ( isTesting() ) return;
//    $db = getRealtimeDatabase();
//    $reference = $db->getReference($documentPath);
//    $reference->set($data);
}



