<?php

class FileRoute {

    public function upload($in) {
        return files()->upload($in)->response();
    }
    public function delete($in) {
        return files()->remove($in)->response();
    }
}


