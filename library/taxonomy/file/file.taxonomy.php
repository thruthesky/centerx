<?php

/**
 * Class File
 *
 * @property-read string path - file path
 * @property-read string url
 */
class FileTaxonomy extends Entity {


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

        /**
         * taxonomy 와 entity 에 동일한 값이 있으면, 삭제. 기존 사진을 삭제한다. README 참고.
         * code 값이 있으면 사용자 번호가 entity 에 있는 code 를 찾아 파일(들)을 삭제한다.
         */
        if ( isset($in['deletePreviousUpload']) && $in['deletePreviousUpload'] == 'Y' ) {
            if ( isset($in['code']) && $in['code'] ) {
                $files = $this->find([ CODE => $in[CODE], USER_IDX => login()->idx ]);
            } else {
                $files = $this->find([TAXONOMY => $in[TAXONOMY], ENTITY => $in[ENTITY]]);
            }
            foreach( $files as $file ) {
                files($file->idx)->delete();
            }
        }


        if (move_uploaded_file($_FILES[USERFILE]['tmp_name'], $path)) {
            $save = [
                USER_IDX => login()->idx,
                PATH => basename($path), // path is the name of the file under `files` folder.
                NAME => $_FILES[USERFILE][NAME],
                SIZE => $_FILES[USERFILE][SIZE],
                TYPE => $_FILES[USERFILE][TYPE],
                TAXONOMY => $in[TAXONOMY] ?? '',
                ENTITY => $in[ENTITY] ?? 0,
                CODE => $in[CODE] ?? '',
            ];
            debug_log("save: ", $save);
            return $this->create($save);
        } else {
            debug_log("move_uploaded_file() - Possible file upload attack!");
            return $this->error(e()->move_uploaded_file_failed);
        }
    }




    /**
     * 파일 삭제
     *
     * 주의, 현재 $this->idx 에 대해서만 삭제를 한다.
     * 주의, 현재 객체에 에러가 설정되어져 있으면 그냥 현재 객체 리턴.
     * 주의, 퍼미션 검사를 하지 않고 무조건 삭제한다. 따라서 이 함수 호출 이전에 퍼미션 검사가 되어져 있어야 한다.
     *
     * 참고, posts.files 와 같이 필드에 해당 글과 연관된 첨부 파일이 기록되는데, 여기서 글을 삭제할 때, 그 files 필드 정보를 업데이트하지 않는다.
     * 따라서, 각 글이나 entity 에 연결된 첨부 파일을 추출 할 때에는 fromIndexes() 대신, find() 함수를 쓴다.
     *
     * @return self
     *
     * @todo update `files` field on entity if exists.
     */
    public function delete(): self
    {
        if ( $this->hasError ) return $this;

        if ( $this->exists() === false ) return $this->error(e()->file_not_exists);

        if ( file_exists($this->path) === false ) return $this->error(e()->file_not_exists);

        $re = @unlink($this->path);
        if ( $re === false ) return $this->error(e()->file_delete_failed);
        return parent::delete();
    }

    /**
     * @param int $idx
     * @return Entity
     */
    public function read(int $idx = 0): Entity
    {
        parent::read($idx);
        $url = UPLOAD_URL . $this->v(PATH);// $data[PATH];
        $this->updateData('url', $url);
        $this->updateData('path', UPLOAD_DIR . $this->path);
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
     * @param bool $object - true 이면 객체로 리턴하고, false 이면 response 배열로 리턴한다.
     * @return self[]
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


    /**
     * code 에 맞는 (아무) 파일 하나를 리턴한다.
     * 파일이 존재하지 않으면, entity_not_found 에러가 설정된 객체를 리턴된된다. 이 때, (에러가 있다면,) $this->idx 는 0, $this->url 은 null 의 값을 가진다.
     *
     * @param string $code
     * @return $this
     */
    public function getByCode(string $code): self {
        return $this->findOne(['code' => $code]);
    }

}


/**
 * Returns File instance.
 *
 * @note the function name is `files` since `file` exists as in PHP built-in function.
 *
 * @param array|int $idx - The `posts.idx` which is considered as comment idx. Or an array of the comment record.
 * @return FileTaxonomy
 */
function files(array|int $idx=0): FileTaxonomy
{
    if ( is_array($idx) ) return new FileTaxonomy($idx[IDX]);
    else return new FileTaxonomy($idx);
}

