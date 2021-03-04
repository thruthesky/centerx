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
define('COMMENTS_TAXONOMY', 'posts');
define('COMMENTS', 'comments');

define('FILES', 'files');

define('PUSH_NOTIFICATION_TOKENS', 'push_notification_tokens');
define('POINT_HISTORIES', 'point_histories');

define('POST_VOTE_HISTORIES', 'post_vote_histories');






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
define('DOMAIN', 'domain');
define('POINT', 'point');
define('CHOICE', 'choice');



define('USERFILE', 'userfile');
define('SHOPPING_MALL', 'shopping_mall');

define('META_CODE_EXCEPTIONS', [ROUTE, SESSION_ID, 'reload', 'p', 'w', 'cw', 'mode', 'MAX_FILE_SIZE', TOKEN]);

