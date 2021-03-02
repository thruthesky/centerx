<?php

class FileRoute {

    public function upload($in) {
        return files()->upload($in);
    }
}


