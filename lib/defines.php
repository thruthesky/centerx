<?php
/**
 * @file defines.php
 */




/**
 * A taxonomy must be a table name.
 */
define('CONFIG', 'config');
define('METAS', 'metas');
define('TAXONOMY', 'taxonomy');
define('ENTITY', 'entity');
define('CATEGORIES', 'categories');
define('USERS', 'users');

/**
 * The `comments` is the same taxonomy as `posts`.
 */
define('POSTS', 'posts');

define('COMMENTS', 'comments');

define('FILES', 'files');

define('PUSH_NOTIFICATION_TOKENS', 'push_notification_tokens');
define('POINT_HISTORIES', 'point_histories');

define('POST_VOTE_HISTORIES', 'post_vote_histories');
define('SHOPPING_MALL_ORDERS', 'shopping_mall_orders');

define('TRANSLATIONS', 'translations');



define('ROUTE', 'route');

define('ADMIN', 'admin');

define('IDX', 'idx');
define('ID', 'id');
define('CATEGORY', 'category');
define('CATEGORY_IDX', 'categoryIdx');
define('CATEGORY_ID', 'categoryId');
define('PARENT_IDX', 'parentIdx');
define('ROOT_IDX', 'rootIdx');

define('USER', 'user');
define('USER_IDX', 'userIdx');
define('EMAIL', 'email');
define('PASSWORD', 'password');
define('NAME', 'name');
define('SIZE', 'size');
define('TYPE', 'type');

define('PHONE_NO', 'phoneNo');
define('CODE', 'code');
define('DATA', 'data');
define('CREATED_AT', 'createdAt');
define('UPDATED_AT', 'updatedAt');
define('DELETED_AT', 'deletedAt');
define('SESSION_ID', 'sessionId');
define('NICKNAME', 'nickname');
define('PROFILE_PHOTO_URL', 'profilePhotoUrl');

define('TITLE', 'title');
define('CONTENT', 'content');
define('DESCRIPTION', 'description');
define('PATH', 'path');
define('DEPTH', 'depth');

define('TOKEN', 'token');
define('TOKENS', 'tokens');
define('TOPIC', 'topic');
define('DOMAIN', 'domain');
define('POINT', 'point');
define('CHOICE', 'choice');



define('OPTION', 'option');

/**
 * For push notification topics and prefixes
 */
define('DEFAULT_TOPIC', 'defaultTopic');
define('DEFAULT_NOTIFY_PREFIX', 'notify');
define('NOTIFY_POST', DEFAULT_NOTIFY_PREFIX . 'Post_');
define('NOTIFY_COMMENT', DEFAULT_NOTIFY_PREFIX . 'Comment_');
define('NEW_COMMENT_ON_MY_POST_OR_COMMENT', 'newCommentUserOption');

define('SUBSCRIPTION', 'subscription');

define('BODY', 'body');
define('CLICK_ACTION', 'click_action');
define('IMAGE_URL', 'imageUrl');


define('USERFILE', 'userfile');
define('SHOPPING_MALL', 'shopping_mall');

/**
 * Meta 에 저장되지 말아야 할 키 목록
 *
 * ROUTE - route
 * SESSION_ID - user serssion id
 * p - page
 * w - widget
 * cw - child widget
 * mode - form submit mode
 * MAX_FILE_SIZE - form file size limit
 * TOKEN - the push token
 */
define('META_CODE_EXCEPTIONS', [
    ROUTE,
    SESSION_ID,
    CATEGORY_ID, // 글 작성시 카테고리 아이디가 넘어 옴. 저장 할 필요 없음.
    'reload',
    'p', 'w', 'cw', 'mode', 'MAX_FILE_SIZE',
    TOKEN,
    'returnTo', // to return where after form submit.
    'userfile', // file upload form name.
]);


define('ADMIN_SETTINGS', 1);


/// HOME_URL 이 설정되지 않고, 접속 URL 이 없는 경우, 사용될 기본 URL. 예를 들어 CLI 작업이나 테스팅하는 경우,
/// 주의, URL 이 슬래시(/)로 끝나야 한다.
define('DEFAULT_HOME_URL', 'http://default.home.url/');
