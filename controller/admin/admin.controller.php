<?php
/**
 * @file admin.controller.php
 */

/**
 * Class AdminController
 *
 * 관리자만 쓸 수 이쓴 컨트롤러
 */
class AdminController
{

    // 관리자가, 로컬 호스트에서만, 글/파일 정보 테이블을 다 지울 수 있다. 테스트 전용.
    public function truncatePostsTable(): array | string {
        if ( ! isLocalhost() ) return e()->not_localhost;
        if ( ! admin() ) e()->you_are_not_admin;
        db()->query("TRUNCATE " . post()->getTable());
        db()->query("TRUNCATE " . files()->getTable());
        return ['success' => true];
    }

}
