<?php

define('ROOT_DIR', __DIR__ . '/');

require ROOT_DIR . 'etc/preflight.php';
require ROOT_DIR . 'etc/kill-wrong-routes.php';

require ROOT_DIR . 'vendor/autoload.php';

require_once ROOT_DIR . 'library/core/functions.php';

require_once ROOT_DIR . 'etc/defines.php';

require_once ROOT_DIR . 'library/core/theme.php';

require_once ROOT_DIR . 'library/core/mysqli.php';

require_once ROOT_DIR . 'library/core/entity.php';
require_once ROOT_DIR . 'library/taxonomy/config/config.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/country/country.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/user/user.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/meta/meta.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/friend/friend.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/category/category.taxonomy.php';
require_once ROOT_DIR . 'library/core/forum.php';
require_once ROOT_DIR . 'library/taxonomy/post/post.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/comment/comment.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/push-notification/push-notification.tokens.class.php';
require_once ROOT_DIR . 'library/taxonomy/push-notification/push-notification.class.php';
require_once ROOT_DIR . 'library/taxonomy/file/file.taxonomy.php';
require_once ROOT_DIR . 'library/core/error.php';
require_once ROOT_DIR . 'library/core/user_activity.php';
require_once ROOT_DIR . 'lib/point/point.defines.php';
require_once ROOT_DIR . 'lib/point/point.class.php';
require_once ROOT_DIR . 'lib/point/point.history.class.php';
require_once ROOT_DIR . 'library/taxonomy/vote/vote-history.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/shopping-mall-order/shopping-mall-order.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/cache/cache.taxonomy.php';
require_once ROOT_DIR . 'library/taxonomy/translation/translation.taxonomy.php';
require_once ROOT_DIR . 'library/core/firebase.php';
require_once ROOT_DIR . 'library/core/data.php';
require_once ROOT_DIR . 'library/taxonomy/in-app-purchase/in-app-purchase.taxonomy.php';
require_once ROOT_DIR . 'library/core/hook.php';




// config.php 에는 theme config 도 실행되므로, 사실 모든 종류의 코드가 다 필요하다. 단, DB 에 직접 접속 할 수 없고, 정히 필요하다면, hook 이나 route 를 통해서 할 수 있다.
// 하지만, hook 이나 route 는 theme functions.php 에 저장되는 것이 좋다.
require_once ROOT_DIR . 'config.php';


// set error handler
if ( canHandleError() ) {
    set_error_handler("customErrorHandler");
}

require_once ROOT_DIR . 'etc/db.php';


/**
 * 각 Theme 의 theme-name.functions.php 가 존재하면, 실행한다.
 */
$_path = theme()->file( filename: 'functions', prefixThemeName: true );
debug_log("Theme functions path: $_path");
if ( file_exists($_path) ) {
    require_once $_path;
}

live_reload();


debug_log('-- start -- boot.code.php: ', date('r'));
debug_log('in();', in());

if ( API_CALL == false ) {
    setUserAsLogin(getProfileFromCookieSessionId());
}


