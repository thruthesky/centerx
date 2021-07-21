<?php
/**
 * @file file.model.php
 */
/**
 *
 * Class FileModel
 *
 * @property-read string path - file path
 * @property-read string url
 * @property-read string thumbnailUrl
 */
class FileModel extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(FILES, $idx);
    }


    /**
     * 파일 업로드
     *
     * HTTP FORM 으로 업로드 할 수 있고, 프로그램적으로도 업로드 할 수 있다. test 파일 참고
     *
     * @param array $in
     *  $in['deletePreviousUpload'] - 이 값이 Y 이면, 기존에 존재하는(업로드된) 파일을 삭제한다.
     *      즉, 기존의 파일을 자동으로 지우고, 하나의 파일만 유지하고자 할 때 사용한다. 이 때, 입력 값의 조합이 중요하다.
     *      "taxonomy + entity + userIdx" 조합 또는 "code + userIdx" 조합으로 기존 파일을 삭제할 수 있다.
     *      즉, deletePreviousUpload 값이 Y 이면,
     *          반드시 "taxonomy + entity + userIdx" 조합 또는 "code + userIdx" 조합이 들어와야 기존 파일이 삭제된다.
     *
     *  $in[taxonomy] - taxonomy 값이 들어간다.
     *      wc_files.taxonomy 에 저장될 값. 이 값은 deletePreviousUpdate 의 값이 Y 이든 아니든, 상관 없이, 저장된다.
     *
     *  $in[entity] - entity 값이 들어간다.
     *      wc_files.entity 에 저장될 값. 이 값은 deletePreviousUpdate 의 값이 Y 이든 아니든, 상관 없이, 저장된다.
     *
     *  $in[code] - code 값이 들어간다.
     *      wc_files.code 에 저장될 값. 이 값은 deletePreviousUpdate 의 값이 Y 이든 아니든, 상관 없이, 저장된다.
     *
     * @param array $userfile
     *  $_FILES 에 직접 값을 넣어 이 함수를 호출해도 된다. 테스트(tests/basic.file.test.php) 참고.
     *  하지만, $userfile 변수에 따로 값을 넣어 전달한다.
     *
     * @return self
     */
    public function upload(array $in, array $userfile = []): self {

        if ( $this->hasError ) return $this;
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);


        if ( empty($userfile) ) $userfile = $_FILES[USERFILE] ?? [];

        if ( !isset($userfile) || empty($userfile) ) return $this->error( e()->file_is_empty );
        if ( !isset($userfile[NAME]) || empty($userfile[NAME]) ) return $this->error( e()->file_name_is_empty );
        if ( !isset($userfile[SIZE]) || empty($userfile[SIZE]) ) return $this->error( e()->file_size_is_empty );
        if ( !isset($userfile[TYPE]) || empty($userfile[TYPE]) ) return $this->error( e()->file_type_is_empty );
        if ( !isset($userfile[TMP_NAME]) || empty($userfile[TMP_NAME]) ) return $this->error( e()->file_tmp_name_is_empty );

        $name = basename($userfile[NAME]);
        $path = $this->getPath($name);
        $orgPath = $userfile[TMP_NAME];

        /**
         * taxonomy 와 entity 에 동일한 값이 있으면, 삭제. 기존 사진을 삭제한다. README 참고.
         * code 값이 있으면 사용자 번호가 entity 에 있는 code 를 찾아 파일(들)을 삭제한다.
         */
        if ( isset($in['deletePreviousUpload']) && $in['deletePreviousUpload'] == 'Y' ) {
            if ( isset($in['code']) && $in['code'] ) {
                $files = $this->find([ CODE => $in[CODE], USER_IDX => login()->idx ]);
            } else {
                $files = $this->find([TAXONOMY => $in[TAXONOMY], ENTITY => $in[ENTITY], USER_IDX => login()->idx ]);
            }
            foreach( $files as $file ) {
                files($file->idx)->delete();
            }
        }


        // HTML FORM 데이터가 HTTP POST 방식으로 업로드 되었는가?
        if ( is_uploaded_file($orgPath) ) {
            if ( move_uploaded_file($orgPath, $path) == false ) {
                debug_log("FileModel::upload() -> move_uploaded_file() - Possible file upload attack!");
                return $this->error(e()->move_uploaded_file_failed);
            }
        } else {
            // 아니면, 로컬 파일으로 간주해서 파일 복사.
            if ( copy($orgPath, $path) == false ) {
                debug_log("FileModel::upload() -> copy() - failed");
                return $this->error(e()->copy_file_failed);
            }
        }

        $save = [
            USER_IDX => login()->idx,
            PATH => basename($path), // path is the name of the file under `files` folder.
            NAME => $userfile[NAME],
            SIZE => $userfile[SIZE],
            TYPE => $userfile[TYPE],
            TAXONOMY => $in[TAXONOMY] ?? '',
            ENTITY => $in[ENTITY] ?? 0,
            CODE => $in[CODE] ?? '',
        ];
        debug_log("save: ", $save);
        return $this->create($save);

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

        if ( $this->exists() === false ) return $this->error(e()->file_not_exists_in_db);
        if ( file_exists($this->path) === false ) {
            // the file exists in wc_files table, but actual file does not exists, so, it will delete the record.
            parent::delete();
            return $this->error(e()->file_not_exists_in_disk);
        }

        $re = @unlink($this->path);
        if ( $re === false ) return $this->error(e()->file_delete_failed);

        return parent::delete();
    }

    /**
     * 파일 데이터 읽기
     *
     * 기본 thumbnailUrl 을 추가해 준다. 이 때, /etc/thumbnail.php 를 이용한다.
     *
     * @note 주의, 이 함수에서 thumbnailUrl() 을 실행하면, 재귀 호출이 발생하여, 서버가 다운된다.
     *
     * @param int $idx
     * @return Entity
     */
    public function read(int $idx = 0): Entity
    {
        parent::read($idx);
        $url = UPLOAD_SERVER_URL . 'files/uploads/' . $this->v(PATH);// $data[PATH];
        $this->updateMemoryData('url', $url);
        $this->updateMemoryData('thumbnailUrl', UPLOAD_SERVER_URL . "etc/thumbnail.php?idx=$idx");
//        $this->updateMemoryData('thumbnailUrl', thumbnailUrl($this->idx));
        $this->updateMemoryData('path', UPLOAD_DIR . $this->path);


        // short date for the file create time
        // $this->createdAt can be undefined if being run in a test.
        $this->updateMemoryData('shortDate', short_date_time($this->createdAt ?? 0));
        return $this;
    }

    /**
     * This method adds user and post(or comment) information to response to the client.
     *
     * @note to make the return data slim, it only returns 128 chars of content.
     *
     * @usage Use this method when you need to display files(photos) with user and post information like
     *          display all uploaded photos in admin page.
     */
    public function responseWithUserAndPost() {
        if ( $this->hasError ) return $this->getError();
        $data = $this->getData();

        if ( isset($data[USER_IDX]) ) {
            $data['user'] = user($data[USER_IDX])->shortProfile(firebaseUid: true);
        } else {
            $data['user'] = [];
        }

        if($data[TAXONOMY] == POSTS) {
            $data['post'] = [
                'idx' => post($data[ENTITY])->idx,
                'title' => post($data[ENTITY])->title,
                'content' =>  mb_substr(post($data[ENTITY])->content, 0, 128),
            ];
        }
        return $data;
    }

    /**
     * @return array|string
     * This method adds user information and post data which give a extra accessing to database and returns extra data to client-end.
     */
//    public function response(string $fields = null): array|string {
//        if ( $this->hasError ) return $this->getError();
//        $data = $this->getData();
//
//        if ( isset($data[USER_IDX]) ) {
//            $data['user'] = user($data[USER_IDX])->shortProfile(firebaseUid: true);
//        } else {
//            $data['user'] = [];
//        }
//
//        if($data[TAXONOMY] == POSTS) {
//            $data['post'] = [
//                'idx' => post($data[ENTITY])->idx,
//                'title' => post($data[ENTITY])->title,
//                'content' =>    post($data[ENTITY])->content
//            ];
//        }
//        return $data;
//    }

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
     *
     * 파일이 존재하지 않으면, entity_not_found 에러가 설정된 객체를 리턴된된다. 이 때, (에러가 설정되면면,) $this->idx 는 0, $this->url 은 null 의 값을 가진다.
     *
     * 참고, code 만 입력해서 검색 할 수 있지만, taxonomy, entity 로 검색 할 수 있다.
     *
     * @param string $code
     *
     * @return $this
     */
    public function getByCode(string $code): self {
        return $this->getBy(code: $code);
    }

    /**
     *
     * taxonomy, entity, code 전체 또는 일부를 입력 받아 조건에 맞는 파일 하나를 리턴한다.
     *
     * 사용 예, 특정 게시글의 특정 첨부 파일 코드
     *
     * @param string $taxonomy
     * @param int $entity
     * @param string $code
     * @return $this
     *  - 파일이 존재하지 않으면, entity_not_found 에러가 설정된 객체를 리턴된된다.
     *      이 때, (에러가 설정되면면,) $this->idx 는 0, $this->url 은 null 의 값을 가진다.
     */
    public function getBy(string $taxonomy='', int $entity=0, string $code=''): self {
        $conds = [];
        if ( $taxonomy ) $conds[TAXONOMY] = $taxonomy;
        if ( $entity ) $conds[ENTITY] = $entity;
        if ( $code ) $conds[CODE] = $code;
        return $this->findOne($conds);
    }

}


/**
 * Returns File instance.
 *
 * @note the function name is `files` since `file` exists as in PHP built-in function.
 *
 * @param array|int $idx - The `posts.idx` which is considered as comment idx. Or an array of the comment record.
 * @return FileModel
 */
function files(array|int $idx=0): FileModel
{
    if ( is_array($idx) ) return new FileModel($idx[IDX]);
    else return new FileModel($idx);
}

