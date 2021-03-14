<?php

/**
 * Class File
 *
 * @property-read string path - file path
 * @property-read string url
 */
class File extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(FILES, $idx);
    }


    /**
     * @param $in
     * @return self
     */
    public function upload($in): self {

        if ( $this->hasError ) return $this;
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        $name = basename($_FILES[USERFILE]['name']);
        $path = $this->getPath($name);

        if (move_uploaded_file($_FILES[USERFILE]['tmp_name'], $path)) {
            $save = [
                USER_IDX => login()->idx,
                PATH => basename($path), // path is the name of the file under `files` folder.
                NAME => $_FILES[USERFILE][NAME],
                SIZE => $_FILES[USERFILE][SIZE],
                TYPE => $_FILES[USERFILE][TYPE],
            ];
            debug_log("save: ", $save);
            return $this->create($save);
        } else {
            debug_log("move_uploaded_file() - Possible file upload attack!");
            return $this->error(e()->move_uploaded_file_failed);
        }
    }

    /**
     *
     * 주의, 현재 $this->idx 에 대해서만 삭제를 한다.
     * 주의, 현재 객체에 에러가 설정되어져 있으면 그냥 현재 객체 리턴.
     *
     * @param $in
     * @return self
     *
     * @todo update `files` field on entity if exists.
     */
    public function remove($in): self
    {
        if ( $this->hasError ) return $this;
        if ( $this->exists() === false ) return $this->error(e()->file_not_exists);
        if ( $this->isMine() === false ) return $this->error(e()->not_your_file);


        if ( file_exists($this->path) === false ) return $this->error(e()->file_not_exists);

        $re = @unlink($this->path);
        if ( $re === false ) return $this->error(e()->file_delete_failed);
        return $this->delete();
    }

    public function read(int $idx = 0): Entity
    {
        parent::read($idx);
        $url = UPLOAD_URL . $this->v(PATH);// $data[PATH];
        $this->updateData('url', $url);
        return $this;
    }

    /**
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        $data = $this->getData();

        return $data;
    }

    /**
     * '1,2,3' 과 같이 idx 들을 문자열로 입력 받아, 해당하는 File 객체를 배열에 담아 리턴한다.
     *
     * 참고로, 글의 첨부 파일은 1,2,3 과 같이 저장되어져 있다.
     * @param string $idxes
     * @param bool $object - true 이면 객체로 리턴하고, false 이면 배열로 리턴한다.
     * @return File[]
     * - 만약, 파일이 없으면 빈 배열이 리턴된다.
     */
    public function fromIdxes(string $idxes, bool $object = true): array {
        $arr = separateByComma($idxes);
        $rets = [];
        foreach( $arr as $idx ) {
            if ( $object ) $rets[] = files($idx);
            else $rets[] = files($idx)->response();
        }
        return $rets;

    }

    /**
     * @deprecated
     *
     * if `$files` is empty, then it returns the file information of $this->idx.
     * Or the $files must be a string of file.idx(es) separated by comma(,)
     *
     * @param string|null $files
     * @param mixed|null $_
     * @param string $select
     * @param bool $cache
     * @return mixed
     */
//    public function get(string $files = null, mixed $_ = null, string $select = '*', bool $cache=true): mixed
//    {
//        if ( empty($files) && $this->idx ) {
//            $got = parent::get(IDX, $this->idx, $select, $cache);
//            if ( !$got ) return $got;
//            $got['url'] = UPLOAD_URL . $got[PATH];
//            $got[PATH] = UPLOAD_DIR . $got[PATH];
//            return $got;
//        } else {
//            $files = trim($files);
//            if ( empty($files) ) return [];
//            $arr = explode(',', $files);
//            if ( empty($arr) ) return [];
//            $rets = [];
//            foreach( $arr as $idx ) {
//                $got = parent::get(IDX, $idx, $select, $cache);
//                if ( ! $got ) continue;
//                $got['url'] = UPLOAD_URL . $got[PATH];
//                $got[PATH] = UPLOAD_DIR . $got[PATH];
//                $rets[] = $got;
//            }
//            return $rets;
//        }
//    }


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
                $count = rand($count, $count * 10); // 동일한 파일이 존재하면, 0~9 사이에서 나온 수가 5이면 -5 파일이 있은면, 5~50에서 랜덤을 찾는다. 자세한 로직은 post()->getPath() 참고.
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

