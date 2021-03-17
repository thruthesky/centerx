<?php

class FileRoute {

    public function upload($in) {
        return files()->upload($in)->response();
    }
    public function delete($in) {
        if ( !isset($in['idx']) ) return e()->idx_is_empty;
        return files($in)->delete()->response();
    }
}



