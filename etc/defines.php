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
define('CACHE', 'cache');
define('COUNTRIES', 'countries');
define('FRIENDS', 'friends');
define('USERS', 'users');
define('IN_APP_PURCHASE', 'in_app_purchase');
define('USER_ACTIVITIES', 'user_activities');

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

const IDX = 'idx';
const ID = 'id';
const CATEGORY = 'category';
const CATEGORY_IDX = 'categoryIdx';
const CATEGORY_ID = 'categoryId';
const PARENT_IDX = 'parentIdx';
const ROOT_IDX = 'rootIdx';
const SEARCH_KEY = 'searchKey';

const USER = 'user';
const USER_IDX = 'userIdx';
const OTHER_USER_IDX = 'otherUserIdx';
const EMAIL = 'email';
const PASSWORD = 'password';
const NAME = 'name';
const TMP_NAME = 'tmp_name';
const SIZE = 'size';
const TYPE = 'type';

const PHONE_NO = 'phoneNo';
const CODE = 'code';
const CURRENT_CODE_NAME = 'currentCodeName';
const DATA = 'data';
const CREATED_AT = 'createdAt';
const UPDATED_AT = 'updatedAt';
const DELETED_AT = 'deletedAt';
const READ_AT = 'readAt';
const BEGIN_AT = 'beginAt';
const END_AT = 'endAt';

const SESSION_ID = 'sessionId';
const NICKNAME = 'nickname';
const PROFILE_PHOTO_URL = 'profilePhotoUrl';

const TITLE = 'title';
const CONTENT = 'content';

const NO_OF_VIEWS = 'noOfViews';



const PRIVATE_TITLE = 'privateTitle';
const PRIVATE_CONTENT = 'privateContent';


define('DESCRIPTION', 'description');
define('PATH', 'path');
define('DEPTH', 'depth');

define('TOKEN', 'token');
define('TOKENS', 'tokens');
define('TOPIC', 'topic');
define('DOMAIN', 'domain');
define('POINT', 'point');
define('CHOICE', 'choice');


define('ON', 'on');
define('OFF', 'off');



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
define('SOUND', 'sound');
define('CHANNEL', 'channel');


define('USERFILE', 'userfile');
define('SHOPPING_MALL', 'shopping_mall');


const RETURN_URL = 'return_url';


const AD_TOP = 'ad_top';
const AD_POST_LIST_SQUARE = 'ad_post_list_square';
const AD_POST_LIST_THUMBNAIL = 'ad_post_list_thumbnail';
const AD_WING = 'ad_wing';


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
const META_CODE_EXCEPTIONS = [
    ROUTE,
    SESSION_ID, 'session_id',
    CATEGORY_ID, // 글 작성시 카테고리 아이디가 넘어 옴. 저장 할 필요 없음.
    'reload',
    'p', 'w', 'cw', 'mode', 'MAX_FILE_SIZE',
    TOKEN,
    RETURN_URL,
    'returnTo', // returnTo 는 더 이상 사용되지 않음. 없애도 됨.
    'userfile', // file upload form name.
    'nsub', // category list tracking.
    'photoIdx', // 이 키는 meta 로 저장되면 안되고, user()->read() 에서 프로그램적으로 임의로 생성된다.
];


const ADMIN_SETTINGS = 1;


/// HOME_URL 이 설정되지 않고, 접속 URL 이 없는 경우, 사용될 기본 URL. 예를 들어 CLI 작업이나 테스팅하는 경우,
/// 주의, URL 이 슬래시(/)로 끝나야 한다.
define('DEFAULT_HOME_URL', 'http://default.home.url/');

define('SUCCESS','success');
define('FAILURE','failure');
define('PENDING','pending');


define('API_CALL', in(ROUTE) != null);



define('PROVIDER_NAVER', 'naver');
define('PROVIDER_KAKAO', 'kakao');

define('PROVIDERS', [PROVIDER_NAVER, PROVIDER_KAKAO]);

define('VERIFIER_PASSLOGIN', 'passlogin');
define('VERIFIER_DANAL', 'danal');
define('VERIFIERS', [VERIFIER_DANAL, VERIFIER_PASSLOGIN]);




