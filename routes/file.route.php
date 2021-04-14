<?php

class FileRoute {

    public function upload($in) {
        return files()->upload($in)->response();
    }

    /**
     * 글 또는 코멘트 번호를 입력하면, 연결된 사진 정보를 리턴한다.
     * @param $in
     *  - $in['idx'] 글 또는 코멘트 번호
     * @return File[]
     *
     * @example 클라이언트에서 호출 예제
     * ```
     *   request('file.byPostIdx', {'idx': this.postIdx}, function(res) {
     *     console.log('res, ', res);
     *   }, alert);
     * ```
     */
    public function byPostIdx($in) {
        return post($in['idx'])->files(response: true);
    }

    /**
     * 해당 글 또는 코멘트에 연결된 사진(파일) 중 특정 code 의 것만 리턴한다.
     * @param $in
     *  - $in['idx'] 글 또는 코멘트 번호
     *  - $in['code'] 글 또는 코멘트에 연결된 code. 여러 사진(파일) 중 하나만 원할 때.
     *
     * @return array|File
     *
     * @example 클라이언트에서 호출 예제
     * ```
     *  request('file.byPostCode', {idx: this.postIdx, code: this.code}, function(res) {
     *    console.log('res, ', res);
     *  }, alert);
     * ```
     */
    public function byPostCode($in) {
        $files = post($in['idx'])->files(response: true);
        foreach( $files as $file ) {
            if ( $file['code'] == $in['code'] ) return $file;
        }
        return [];
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



