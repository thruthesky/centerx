<?php
define('ROOT_DIR', __DIR__ . '/');

require ROOT_DIR . 'etc/preflight.php';
require ROOT_DIR . 'etc/kill-wrong-routes.php';

require ROOT_DIR . 'vendor/autoload.php';

require_once ROOT_DIR . 'etc/core/functions.php';
require_once ROOT_DIR . 'etc/core/language.php';

require_once ROOT_DIR . 'etc/defines.php';
require_once ROOT_DIR . 'etc/translations.php';

require_once ROOT_DIR . 'etc/core/theme.php';

require_once ROOT_DIR . 'etc/core/mysqli.php';

require_once ROOT_DIR . 'etc/core/entity.php';
require_once ROOT_DIR . 'model/config/config.taxonomy.php';
require_once ROOT_DIR . 'model/country/country.taxonomy.php';
require_once ROOT_DIR . 'model/user/user.taxonomy.php';
require_once ROOT_DIR . 'model/meta/meta.taxonomy.php';
require_once ROOT_DIR . 'model/friend/friend.taxonomy.php';
require_once ROOT_DIR . 'model/category/category.taxonomy.php';
require_once ROOT_DIR . 'etc/core/forum.php';
require_once ROOT_DIR . 'model/post/post.taxonomy.php';
require_once ROOT_DIR . 'model/comment/comment.taxonomy.php';
require_once ROOT_DIR . 'model/push-notification/push-notification.tokens.class.php';
require_once ROOT_DIR . 'model/push-notification/push-notification.class.php';
require_once ROOT_DIR . 'model/file/file.taxonomy.php';
require_once ROOT_DIR . 'etc/core/error.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.defines.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.actions.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.base.php';
require_once ROOT_DIR . 'model/user_activity/user_activity.taxonomy.php';


require_once ROOT_DIR . 'model/message/message.taxonomy.php';

require_once ROOT_DIR . 'model/vote/vote-history.taxonomy.php';
require_once ROOT_DIR . 'model/shopping-mall-order/shopping-mall-order.taxonomy.php';
require_once ROOT_DIR . 'model/cache/cache.taxonomy.php';
require_once ROOT_DIR . 'model/translation/translation.taxonomy.php';
require_once ROOT_DIR . 'etc/core/firebase.php';
require_once ROOT_DIR . 'etc/core/test.functions.php';
require_once ROOT_DIR . 'etc/core/data.php';
require_once ROOT_DIR . 'model/in-app-purchase/in-app-purchase.taxonomy.php';
require_once ROOT_DIR . 'etc/core/hook.php';






// config.php 에는 theme config 도 실행되므로, 사실 모든 종류의 코드가 다 필요하다. 단, DB 에 직접 접속 할 수 없고, 정히 필요하다면, hook 이나 route 를 통해서 할 수 있다.
// 하지만, hook 이나 route 는 theme functions.php 에 저장되는 것이 좋다.
require_once ROOT_DIR . 'config.php';


// set error handler
if ( canHandleError() ) {
    set_error_handler("customErrorHandler");
}

require_once ROOT_DIR . 'etc/db.php';


/**
 * 입력 값 조정. README.md 참고
 */
adjust_http_input();


/**
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
debug_log("Theme functions path: $_path");
if ( file_exists($_path) ) {
    require_once $_path;
}

// Live reload.
// @see README.md how to control live reload.
live_reload();


// Leave a record, for stating that a new script run time begins.
leave_starting_debug_log();

if ( API_CALL == false ) {
    setUserAsLogin(getProfileFromCookieSessionId());
}


