<?php

//
const ROOT_DIR = __DIR__ . '/';
const VIEW_FOLDER_NAME = 'view';
const VIEW_DIR = ROOT_DIR . VIEW_FOLDER_NAME . '/';
const CONTROLLER_DIR = ROOT_DIR . 'controller/';


// Restful Api
require ROOT_DIR . 'etc/preflight.php';
// Kill wrong access or malicious access.
require ROOT_DIR . 'etc/kill-wrong-routes.php';

// Autoload for PHP Composer modules
require ROOT_DIR . 'vendor/autoload.php';

//
require_once ROOT_DIR . 'etc/core/functions.php';
require_once ROOT_DIR . 'etc/core/language.php';

require_once ROOT_DIR . 'etc/defines.php';
require_once ROOT_DIR . 'etc/translations.php';

// @todo remove theme
require_once ROOT_DIR . 'etc/core/view.php';


require_once ROOT_DIR . 'etc/core/mysqli.php';

require_once ROOT_DIR . 'etc/core/entity.php';
require_once ROOT_DIR . 'model/config/config.model.php';
require_once ROOT_DIR . 'model/country/country.model.php';
require_once ROOT_DIR . 'model/user/user.model.php';
require_once ROOT_DIR . 'model/meta/meta.model.php';
require_once ROOT_DIR . 'model/friend/friend.model.php';
require_once ROOT_DIR . 'model/category/category.model.php';
require_once ROOT_DIR . 'etc/core/forum.php';
require_once ROOT_DIR . 'model/post/post.model.php';
require_once ROOT_DIR . 'model/comment/comment.model.php';
require_once ROOT_DIR . 'model/push-notification/push-notification.tokens.model.php';
require_once ROOT_DIR . 'model/push-notification/push-notification.class.php';
require_once ROOT_DIR . 'model/file/file.model.php';
require_once ROOT_DIR . 'etc/core/error.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.defines.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.actions.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.base.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.model.php';


require_once ROOT_DIR . 'model/message/message.model.php';

require_once ROOT_DIR . 'model/vote/vote-history.model.php';
require_once ROOT_DIR . 'model/shopping-mall-order/shopping-mall-order.model.php';
require_once ROOT_DIR . 'model/cache/cache.model.php';
require_once ROOT_DIR . 'model/translation/translation.model.php';
require_once ROOT_DIR . 'etc/core/firebase.php';
require_once ROOT_DIR . 'etc/core/test.functions.php';
require_once ROOT_DIR . 'etc/core/data.php';
require_once ROOT_DIR . 'model/in-app-purchase/in-app-purchase.model.php';



require_once ROOT_DIR . 'model/advertisement/advertisement.model.php';
require_once ROOT_DIR . 'model/advertisement/advertisement_point_settings.model.php';


// cafe
require_once ROOT_DIR . 'model/cafe/cafe.defines.php';
require_once ROOT_DIR . 'model/cafe/cafe.model.php';



require_once ROOT_DIR . 'etc/core/hook.php';






// config.php 에는 theme config 도 실행되므로, 사실 모든 종류의 코드가 다 필요하다. 단, DB 에 직접 접속 할 수 없고, 정히 필요하다면, hook 이나 route 를 통해서 할 수 있다.
// 하지만, hook 이나 route 는 theme functions.php 에 저장되는 것이 좋다.
//
// Load global config.php that loads config.php in each theme.
require_once ROOT_DIR . 'config.php';

debug_log("_______ view(theme) folderName: " . view()->folderName );

// set error handler
if ( canHandleError() ) {
    set_error_handler("customErrorHandler");
}

// Load database model and connect to database.
require_once ROOT_DIR . 'etc/db.php';


/**
 * 입력 값 조정. README.md 참고
 */
adjust_http_input();


/**
 * @deprecated
 * @todo remove unused function since v2
 *
 * @see README.md
 */
function adjust_http_input() {
    if ( isset($_REQUEST) && count($_REQUEST) ) {
        foreach(array_keys($_REQUEST) as $k) {
            // convert .submit to `p` variable. @see README.md
            if ( str_ends_with($k, '_submit') ) {
                $_REQUEST['p'] = str_replace('_', '.', $k);
                unset($_REQUEST[$k]);
            }
        }
    }
}
/**
 * 각 Theme 의 theme-name.functions.php 가 존재하면, 실행한다.
 */
$_path = theme()->file( filename: 'functions', prefixThemeName: true );
if ( file_exists($_path) ) {
    debug_log("Loading view(theme) functions path: $_path");
    require_once $_path;
} else {
    debug_log("View funcitons php script not exists. View(theme) functions path: $_path");
}

cookieLogin();

// Leave a record, for stating that a new script run time begins.
leave_starting_debug_log();
