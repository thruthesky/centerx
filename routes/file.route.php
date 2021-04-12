<?php

class FileRoute {

    public function upload($in) {
        return files()->upload($in)->response();
    }

    /**
     * 파일 삭제 라우트
     *
     * 파일 삭제는 오직 이 라우트를 통해서만 이루어져야 한다. PHP 프로그램적으로 삭제해서도 안되고, 오직 이 라우트를 통해서만 삭제한다.
     *
     * @param $in
     * @return array|string
     */
    public function delete($in) {
        if ( !isset($in['idx']) ) return e()->idx_is_empty;
        return files($in)->permissionCheck()->delete()->response();
    }
}



