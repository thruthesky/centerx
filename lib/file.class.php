<?php

class File extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(FILES, $idx);
    }


    /**
     * @param $in
     * @return array|string
     */
    public function upload($in) {

        if ( notLoggedIn() ) return e()->not_logged_in;
        $name = basename($_FILES[USERFILE]['name']);
        $path = $this->getPath($name);

        if (move_uploaded_file($_FILES[USERFILE]['tmp_name'], $path)) {
            $save = [
                USER_IDX => my(IDX),
                PATH => basename($path), // path is the name of the file under `files` folder.
                NAME => $_FILES[USERFILE][NAME],
                SIZE => $_FILES[USERFILE][SIZE],
                TYPE => $_FILES[USERFILE][TYPE],
            ];
            debug_log("save: ", $save);
            $record = $this->create($save);
            debug_log("saved record: ", $record);
            return files($record)->get();
        } else {
            debug_log("move_uploaded_file() - Possible file upload attack!");
            return e()->move_uploaded_file_failed;
        }
    }

    /**
     * @param $in
     * @return string
     *
     * @todo update `files` field on entity if exists.
     */
    public function remove($in) {
        $this->setIdx($in[IDX]);
        if ( $this->exists() === false ) return e()->file_not_exists;
        if ( $this->isMine() === false ) return e()->not_your_file;

        $record = parent::get(IDX, $in[IDX]);

        $path = UPLOAD_DIR . $record[PATH];
        if ( file_exists($path) === false ) return e()->file_not_exists;

        $re = @unlink($path);
        if ( $re === false ) return e()->file_delete_failed;
        return $this->delete();
    }

    /**
     * if `$files` is empty, then it returns the file information of $this->idx.
     * Or the $files must be a string of file.idx(es) separated by comma(,)
     *
     * @param string|null $files
     * @param mixed|null $_
     * @param string $select
     * @return mixed
     */
    public function get(string $files = null, mixed $_ = null, string $select = '*'): mixed
    {
        if ( empty($files) && $this->idx ) {
            $got = parent::get(IDX, $this->idx, $select);
            if ( !$got ) return $got;
            $got['url'] = UPLOAD_URL . $got[PATH];
            $got[PATH] = UPLOAD_DIR . $got[PATH];
            return $got;
        } else {
            $files = trim($files);
            if ( empty($files) ) return [];
            $arr = explode(',', $files);
            if ( empty($arr) ) return [];
            $rets = [];
            foreach( $arr as $idx ) {
                $got = parent::get(IDX, $idx, $select);
                if ( ! $got ) continue;
                $got['url'] = UPLOAD_URL . $got[PATH];
                $got[PATH] = UPLOAD_DIR . $got[PATH];
                $rets[] = $got;
            }
            return $rets;
        }
    }


    /**
     * Returns unique seo friendly url for the post.
     *
     * It returns empty string for comment.
     *
     * @return string
     */
    private function getPath(string $name): string {
        $name = safeFilename($name);
        $path = UPLOAD_DIR . $name;
        $count = 0;
        while ( true ) {
            if ( file_exists($path) ) {
                $count ++;
                $pi = pathinfo($name);
                $path = UPLOAD_DIR . "$pi[filename]-$count" . '.' . $pi['extension'];
            } else {
                return $path;
            }
        }
    }
}


/**
 * Returns File instance.
 *
 * @note the function name is `files` since `file` exists as in PHP built-in function.
 *
 * @param array|int $idx - The `posts.idx` which is considered as comment idx. Or an array of the comment record.
 * @return File
 */
function files(array|int $idx=0): File
{
    if ( is_array($idx) ) return new File($idx[IDX]);
    else return new File($idx);
}

