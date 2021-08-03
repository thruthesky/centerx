<?php
/**
 * @file defines.php
 */

/**
 * 이 파일에는 변경이 되지 않는 상수를 저장한다.
 * 설정이 필요한 상수 또는 define 은 config 에 저장하도록 한다.
 */

/**
 * 에러 구분 문자열
 */
const ERROR_SEPARATOR = '---';

/**
 * A taxonomy must be a table name.
 */
const CONFIG = 'config';
const METAS = 'metas';
const TAXONOMY = 'taxonomy';
const ENTITY = 'entity';
const CATEGORIES = 'categories';
const CACHE = 'cache';
const COUNTRIES = 'countries';
const FRIENDS = 'friends';
const USERS = 'users';
const IN_APP_PURCHASE = 'in_app_purchase';
const USER_ACTIVITIES = 'user_activities';

/**
 * The `comments` is the same taxonomy as `posts`.
 */
const POSTS = 'posts';

const COMMENTS = 'comments';

const FILES = 'files';
const FILE_IDXES = 'fileIdxes';

const CHAT_MESSAGE = 'chat_message';
const CHAT_ROOM = 'chat_room';

const NO_OF_COMMENTS = 'noOfComments';
const RELATIVE_URL = 'relativeUrl';


const PUSH_NOTIFICATION_TOKENS = 'push_notification_tokens';
const POINT_HISTORIES = 'point_histories';

const POST_VOTE_HISTORIES = 'post_vote_histories';
const SHOPPING_MALL_ORDERS = 'shopping_mall_orders';

const TRANSLATIONS = 'translations';

const COUNTRY_CODE = 'countryCode';


const ROUTE = 'route';

const ADMIN = 'admin';

const IDX = 'idx';
const ID = 'id';
const IDS = 'ids';
const IDXES = 'idxes';
const CATEGORY = 'category';
const SUB_CATEGORY = 'subcategory';
const CATEGORY_IDX = 'categoryIdx';
const CATEGORY_ID = 'categoryId';
const PARENT_IDX = 'parentIdx';
const ROOT_IDX = 'rootIdx';
const SEARCH_KEY = 'searchKey';
const FULLTEXT_SEARCH = 'fulltextSearch';


const USER = 'user';
const USER_IDX = 'userIdx';
const OTHER_USER_IDX = 'otherUserIdx';
const EMAIL = 'email';
const PASSWORD = 'password';
const PROVIDER = 'provider';
const NAME = 'name';
const TMP_NAME = 'tmp_name';
const SIZE = 'size';
const TYPE = 'type';
const THUMBNAIL_URL = 'thumbnailUrl';
const URL = 'url';

const PHONE_NO = 'phoneNo';
const GENDER = 'gender';
const BIRTH_DATE = 'birthdate';
const CODE = 'code';
const CURRENT_CODE_NAME = 'currentCodeName';
const DATA = 'data';
const CREATED_AT = 'createdAt';
const UPDATED_AT = 'updatedAt';
const DELETED_AT = 'deletedAt';
const READ_AT = 'readAt';
const BEGIN_AT = 'beginAt';
const END_AT = 'endAt';
const BEGIN_DATE = 'beginDate';
const END_DATE = 'endDate';
const SHORT_DATE = 'shortDate';

const SESSION_ID = 'sessionId';
const NICKNAME = 'nickname';
const PHOTO_URL = 'photoUrl';
const PROFILE_PHOTO = 'profilePhoto';
const PROFILE_PHOTO_URL = PHOTO_URL;

const TITLE = 'title';
const CONTENT = 'content';

const NO_OF_VIEWS = 'noOfViews';

// see readme.
const LAST_VIEW_CLIENT_IP = 'lastViewClientIp';



const PRIVATE_TITLE = 'privateTitle';
const PRIVATE_CONTENT = 'privateContent';

const MAXIMUM_ADVERTISING_DAYS = 'maximumAdvertisementDays';
const ADVERTISEMENT_CATEGORIES = 'advertisementCategories';
const ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING = 'globalBannerMultiplying';

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

const BODY = 'body';
const CLICK_ACTION = 'click_action';
const CLICK_URL = 'clickUrl';
const IMAGE_URL = 'imageUrl';
const BANNER_URL = 'bannerUrl';
const SOUND = 'sound';
const CHANNEL = 'channel';


const EMAILS = 'emails';


const UIDS = 'uids';


define('USERFILE', 'userfile');
define('SHOPPING_MALL', 'shopping_mall');


const RETURN_URL = 'return_url';




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
    'nsub', // category list tracking. This is not being used on 2.x. delete on 3.x
    'sc', //
    'photoIdx', // 이 키는 meta 로 저장되면 안되고, user()->read() 에서 프로그램적으로 임의로 생성된다.
    'test',
    FILES, FILE_IDXES,
];


/**
 * ConfigModel 에서 관리자 설정이라는 것을 표시.
 */
const ADMIN_SETTINGS = 1;

///
/// HOME_URL 이 설정되지 않고, 접속 URL 이 없는 경우, 사용될 기본 URL. 예를 들어 CLI 작업이나 테스팅하는 경우,
/// 주의, API 서버의 URL 이 http 로 시작하고, 슬래시(/)로 끝나야 한다. 예) https://www.abc.com/
define('DEFAULT_HOME_URL', 'http://default.home.url/');

define('SUCCESS','success');
define('FAILURE','failure');
define('PENDING','pending');


define('API_CALL', in(ROUTE) != null);


const PROVIDER_NAVER = 'naver';
const PROVIDER_KAKAO = 'kakao';
const PROVIDER_GOOGLE = 'google';
const PROVIDER_FACEBOOK = 'facebook';
const PROVIDER_APPLE = 'apple';
const FIREBASE_UID = 'firebaseUid';


define('PROVIDERS', [PROVIDER_NAVER, PROVIDER_KAKAO]);

const VERIFIER = 'verifier';
const VERIFIER_PASSLOGIN = 'passlogin';
const VERIFIER_DANAL = 'danal';
const VERIFIERS = [VERIFIER_DANAL, VERIFIER_PASSLOGIN];




