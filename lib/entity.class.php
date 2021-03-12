<?php
/**
 * @file entity.class.php
 */


use function ezsql\functions\{
    eq,
};


/**
 * Class Entity
 *
 *
 * - Taxonomy 는 데이터의 종류로서 하나의 테이블이라 생각하면 된다.
 * - Entity 는 하나의 레코드이다.
 * - Entity 를 객체화 할 때, $taxonomy 값(Taxonomy)은 필수이며, $idx (Entity 또는 레코드 번호) 값이 입력되면,
 *   해당 테이블의 해당 레코드 및 연결된 메타 데이터를 읽어 $this->data 에 저장한다.
 *   만약, $idx 에 해당하는 entity 를 찾을 수 없다면, entity_not_found 에러가 설정된다. 그리고 이는 entity(123)->notFound 와 같이 해서 확인 할 수 있다.
 *   즉, category(123), user(123) 과 같이 했을 때, 해당 $idx 에 맞는 레코드가 없으면 에러가 바로 설정이 된다.
 *   따라서, category(123)->exists() == false 와 같이 할 필요 없고, category(123)->hasError 와 같이 하면 된다.
 *   그런데, 카테고리가 존재하는지 안하는지를 확인하기 위해서 category(123) 과 같이 초기화하면, 레코드 전체를 읽으므로 쿼리가 느릴 수 있다.
 *   따라서, 존재하는지 안하는지 확인은 category()->exists([IDX => 123]) 이 낳다.
 *
 * @property-read bool $hasError 현재 객체(Entity instance)에 에러가 있으면 true 값을 가진다.
 * @property-read bool $ok $this->error 에 에러가 설정되지 않았으면, 즉, 아무 이상이 없으면 참을 리턴한다.
 * @property-read int $userIdx 테이블에 userIdx 가 있는 경우만 사용.
 * @property-read bool $notFound 처음 객체를 초기화 할 때, $this->idx 가 0 이거나 해당하는 레코드가 없으면 참을 리턴한다.
 *
 */

class Entity {

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var string 에러가 있으면 에러 메시지를 지정한다.
     */
    private string $error = '';

    /**
     * Entity constructor.
     * @param string $taxonomy
     * @param int $idx - 테이블(taxonomy)의 레코드(entity) idx. 예를 들어, 사용자의 경우, 사용자 번호.
     */
    public function __construct(public string $taxonomy, public int $idx)
    {
        /**
         * 객체 초기화. 현재 $this->idx 에 해당하는 entity 를 읽어 $this->data 에 저장.
         */
        if ( $this->idx ) {
            $this->read($this->idx);
        }
    }

    /**
     * Alias of setError(). 짧게 쓰기 위해서, error() 로 쓴다.
     * @param string $code
     * @return $this
     */
    public function error(string $code): self {
        return $this->setError($code);
    }

    /**
     * 에러 문자열을 설정한다. 즉, 에러가 있음을 표시하는 것이다.
     * @param string $code
     * @return $this
     */
    private function setError(string $code): self {
        $this->error = $code;
        return $this;
    }
    public function getError(): string {
        return $this->error;
    }
    public function resetError(): self {
        $this->error = '';
        return $this;
    }

    /**
     * 주의: 에러가 있으면 빈 배열 또는 null 이 리턴된다.
     * 따라서, 한번 에러가 발생하면, 더 이상 현재 객체를 사용하지 못한다. 그래서 같은 idx 로 새로운 객체를 만들어 다시 작업을 해야 한다.
     * 에러가 있는 상태에서, entity 삭제시, not your entity 등의 에러가 날 수 있다.
     * 이 부분에 실수 할 수 있으니 유의한다.
     *
     * @param string|null $field - 값이 주어지면, 특정 필드의 값 1개만 리턴한다.
     * @return array|int|float|string|null
     */
    public function getData(string $field=null): array|int|float|string|null
    {
        if ( $field ) {
            if ( $this->hasError ) return null;
            else return $this->data[$field] ?? null;
        } else {
            if ( $this->hasError ) return [];
            return $this->data;
        }
    }

    /**
     * @param $attr
     * @return float|array|bool|int|string|null
     * @deprecated Use getData($field)
     */
    public function getAttribute($attr): float|array|bool|int|string|null
    {
        return $this->getData($attr);
//        if ( $this->hasError ) return null;
//        if ( isset($this->data[$attr]) ) return isset($this->data[$attr]);
//        else return null;
    }


    public function setData(array $data) {
        $this->data = $data;
    }

    /**
     * $this->data 배열을 업데이트한다. 키가 존재하지 않으면 추가한다.
     * @param $k
     * @param $v
     *
     * @example
     * category(123)->updateData('subcategories', separateByComma($this->subcategories));
     */
    public function updateData($k, $v) {
        $this->data[$k] = $v;
    }





    /**
     * 필드를 가져오는 magic getter
     *
     * posts 테이블과 meta 테이블에서 데이터를 가져오고, 레코드가 없으면 null 를 리턴한다.
     * @attention 주의 할 것은,
     *  1. 객체 초기화를 할 때, init() 함수에서
     *  2. posts 테이블의 필드는 멤버 변수로 설정하고,
     *  3. 그리고 posts 테이블과 meta 테이블의 모든 값은 $data 에 저장한다.
     *  4. magic getter 로 값을 읽을 때, 새로 DB 에서 가져오는 것이 아니라, (멤버 변수로 설정되지 않았다면, 즉, meta 의 경우,) $data 에서 가져온다.
     *     (참고로, 멤버 변수는 magic getter 호출에 사용되지 않는다.)
     *  5 $this->update() 를 하면, 다시 init() 을 호출 한다.
     *
     * 주의: 에러가 있으면 null 이 리턴된다.
     *
     * @param $name
     * @return mixed
     *
     * @example
     *  $post->update(['eat' => 'apple pie']);
     *  isTrue($post->eat == 'apple pie', 'Must eat apple pie');
     */
    public function __get($name): mixed
    {
        /// `$this->hasError` 에러가 있으면 true 를 리턴
        if ( $name == 'hasError' ) {
            return $this->error !== '';
        }
        /// $this->error 에 에러가 설정되지 않았으면, 즉, 아무 이상이 없으면 참을 리턴한다.
        if ( $name == 'ok' ) {
            return ! $this->hasError;
        }

        /// 처음 객체를 초기화 했을 때,
        /// - $this->idx 가 0 이거나,
        /// - $this->idx 에 해당하는 레코드를 찾지 못하면
        /// 곧 바로 entity_not_found 가 설정되는데, $this->notFound 가 참을 리턴한다.
        if ( $name == 'notFound' ) {
            if ( $this->idx == 0 ) return true;
            else if ( $this->getError() == e()->entity_not_found ) return true;
            else return false;
        }

        /// 필드 값을 가져오려고 할 때, 현재 객체에 에러가 있으면, null 을 리턴.
        if ( $this->hasError ) return null;

        /// 에러가 없으면 값을 리턴. 값이 없으면 null 리턴.
        if ( $this->data && isset($this->data[$name]) ) return $this->data[$name];
        else return null;
    }


    /**
     * 주의: $this->data 배열 이 외의 것은 이 함수로 호출되지 않는다. 실제 존재하는 멤버 변수는 이 함수로 호출되지 않는다.
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }








    /**
     * Create a entity(record) with given $in.
     *
     *
     * entity 에 필드를 저장한다.
     *
     * 만약, Taxonomy 테이블에 존재하지 않는 필드가 입력되면, 자동으로 metas 테이블에 저장한다.
     *
     * 주의: $in 배열 변수의 키와 레코드 필드 명이 동일해야합니다.
     * 참고: 만약, 레코드 필드명에 존재하지 않는 키가 있으면, meta 테이블의 code, value 에 키/값이 저장된다.
     *
     * 생성 후, 현재 객체에 보관한다. $this->idx 도 현재 생성된 객체로 변경된다.
     *
     * @param array $in
     *
     *
     * - error string on error.
     * - entity record on success.
     *
     *
     * @note user is_success() to check if it was success()
     *
     *
     * @example
     * $idx = entity(CATEGORIES)->create($in);
     * return entity(CATEGORIES, $idx)->get();
     *
     *
     * @see readme for detail.
     *
     *
     */
    public function create( array $in ): self {

        if ( ! $in ) return $this->error(e()->empty_param);

        /// If idx is set and has value, return error.
        if ( isset($in[IDX]) ) {
            if ( $in[IDX] ) return $this->error(e()->idx_must_not_set);
            else unset($in[IDX]); /// isset() 인데, falsy 이면, unset.
        }

        //
        $record = $this->getRecordFields($in);
        $record[CREATED_AT] = time();
        $record[UPDATED_AT] = time();


        // Entity 생성 전 훅
        $re = hook()->run("{$this->taxonomy}-before-create", $record, $in);
//        debug_log("훅 리턴 값:", $re);
        if ( isError($re) ) return $this->error($re);

        if ( isDebugging() ) db()->debugOn();
        $idx = db()->insert( $this->getTable(), $record );
        if ( isDebugging() ) db()->debug();

//        debug_log("IDX", $idx);

        if ( !$idx ) return $this->error(e()->insert_failed);

        addMeta($this->taxonomy, $idx, $this->getMetaFields($in));


        /// 현재 객체에 정보 저장.
        $this->read($idx);

        // Entity 생성 후 훅
        $re = hook()->run("{$this->taxonomy}-after-create", $record, $in);
        if ( isError($re) ) return $this->error($re);

        return $this;
    }




    /**
     * Update an entity.
     * @attention entity.idx must be set.
     *
     * 업데이트를 하기 위해서는 `$this->idx` 가 지정되어야 하며, $in 에 업데이트 할 값을 지정하면 된다.
     * 참고, $in 이 빈 값으로 들어 올 수 있다. 그러면 updatedAt 만 업데이트를 한다.
     *
     * Taxonomy 에 존재하지 않는 필드는 meta 에 자동 저장(추가 또는 업데이트)된다.
     *
     * 참고, 업데이트 후 $this->read() 를 통해서 현재 객체의 $this->data 에 DB 로 부터 새로 데이터를 다시 읽는다.
     * 참고, 이전에 에러가 있었으면 그냥 현재 객체를 리턴한다.
     *
     * @param $in
     *
     * @return self
     * - error string on error.
     * - or the entity record.
     *
     *
     * 예제)
     *  d(user(77)->update(['name'=>'name 77', 'a' => 'apple', 'color' => 'myColor']));
     *
     * 예제) 로그인 한 사용자의 프로필 정보를 FORM 으로 입력 받아 수정
     *  login()->update(in());
     *  d(login()->profile());
     *
     * 예제)
     *  $this->idx = 123;
     *  $this->update(['color' => 'blue']);
     *
     * @todo 훅 처리
     */
    public function update(array $in): self {
        if ( $this->hasError ) return $this;

        if ( ! $this->idx ) return $this->error(e()->idx_not_set);

        // 레코드에 있는 필드들을 업데이트
        $up = $this->getRecordFields($in);
        $up[UPDATED_AT] = time();
        $re = db()->update($this->getTable(), $up, eq(IDX, $this->idx ));
        if ( $re === false ) return $this->error(e()->update_failed);

        // 레코드에 없는 필드들은 메타에 업데이트
        updateMeta($this->taxonomy, $this->idx, $this->getMetaFields($in));

        return $this->read();
    }

    /**
     * 레코드 삭제
     *
     * 참고, 이전에 에러가 발생했으면, 삭제하지 않고, 그냥 현재 객체를 리턴한다.
     * 참고, 삭제 후, $this->data 는 빈 배열로 되지만, $this->idx 값은 유지한다.
     * 참고, 에러가 있으면 에러가 설정된다.
     *
     * @return self
     *
     * @todo entity 레코드 뿐만아니라, 메타 데이터도 삭제를 해야한다. 그리고 첨부 파일도 같이 삭제를 해야 한다.
     */
    public function delete(): self {
        if ( $this->hasError ) return $this;
        if ( ! $this->idx ) return $this->error(e()->idx_not_set);
        $re = db()->delete($this->getTable(), eq(IDX, $this->idx));
        if ( $re === false ) return $this->error(e()->delete_failed);
        $this->setData([]);
        return $this;
    }


    /**
     * It does not delete the record. But mark it as deleted by updating deletedAt.
     *
     * You may empty the content of the record when that is deleted.
     *
     * @attention `idx` must be set.
     *
     * @return self
     * - error string on error.
     * - the deleted record on success.
     *
     */
    public function markDelete(): self {
        if ( $this->hasError ) return $this;
        if ( ! $this->idx ) return $this->error(e()->idx_not_set);
        if ( $this->deletedAt > 0 ) return $this->error(e()->entity_deleted_already);
        return self::update([DELETED_AT => time()]);
    }

    /**
     * 현재 Taxonomy 를 유지한 채, entity 만 바꾸고자 할 때 사용.
     * 사실 이것은 read(123) 와 같은 것이다.
     *
     * 주의, 기존 에러 설정을 없앤다. 즉, 기존에 에러가 있었던 객체에 reset() 을 하면 에러가 사라지고,
     * 입력된 $idx 로 초기화 된다.
     *
     * @param int $idx
     * @return $this
     *
     * @example 삭제 실패한 코멘트를 다시 삭제 표시만 하기
     *  isTrue($comment->delete()->getError() == e()->comment_delete_not_supported);
     *  isTrue($comment->reset($comment->idx)->markDelete()->deletedAt > 0);
     */
    public function reset(int $idx): self {
        $this->setError('');
        return $this->read($idx);
    }


    /**
     * Entity(레코드와 메타)를 DB 로 부터 읽어 현재 객체에 보관한다.
     *
     * $idx 가 주어지면, 해당 $idx 를 읽어, 현재 객체의 $data 에 보관하고, $this->idx = $idx 와 같이 entity idx 도 업데이트 한다.
     * $idx 가 주어지지 않았거나, 객체를 생성 할 때, $idx 가 주어지지 않았다면, 빈 배열을 보관한다.
     *
     * $idx 가 주어졌는데, 레코드를 찾을 수 없다면, entity_not_found 에러를 저장한다.
     *
     * 주의: 이 함수 호출 이전에 에러가 있었으면, 그대로 리턴한다. 즉, 에러가 있으면 이 함수를 사용 할 수가 없다.
     * 따라서, login(), register() 등의 함수에서 필요한 작업을 하기 전에 미리 이전 에러를 초기화 해 줄 필요가 있다.
     *
     * @usage 처음 객체 생성시, read() 를 한번 호출한다.
     *  그 후에 $idx 를 주어서 $entity->read(123) 과 같이 호출 하면, entity.idx 와 data 를 바꾼다.
     *  또는 데이터베이스로 부터 새로 정보를 읽고자 할 때 사용한다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self {

        if ( $this->hasError ) return $this;

        if ( ! $idx ) $idx = $this->idx;

        $q = "SELECT * FROM {$this->getTable()} WHERE idx=$idx";
        if ( isDebugging() ) d("read() q: $q");
        $record = db()->get_row($q, ARRAY_A);
        if ( $record ) {
            $meta = getMeta($this->taxonomy, $record['idx']);
            $this->setData(array_merge($record, $meta));
            $this->idx = $this->data['idx'];
        } else {
            $this->error( e()->entity_not_found );
            $this->setData([]);
        }

        return $this;
    }


    /**
     * DB 레코드에서 idx 를 읽어서 존재하는지 아닌지 검사한다.
     *
     * 참고, $conds 에 값이 넘어오면, 해당 조건에 존재하는 레코드가 있는지 확인한다.
     * 이 때, search() 함수를 사용하는데, search() 함수의 특성에 따라 $conds 조건에 맞는 여러개의 레코드가 존재 할 수 있다.
     * 하지만, $this->idx 로 검사하는 경우, 오직 현재 레코드가 존재하는지만 검사한다.
     *
     * 참고, DB 접속을 매번하므로, 원격 DB의 경우 connection 시간이 걸릴 수 있다.
     *
     * $this->idx 가 설정되어야 한다. 아니면 false 리턴.
     *
     *
     * 참고, 카테고리가 존재하는지 안하는지를 확인하기 위해서 category(123) 과 같이 초기화하면, 레코드 전체를 읽으므로 쿼리가 느릴 수 있다.
     * 따라서, 존재하는지 안하는지 확인은 category()->exists([IDX => 123]) 이 낳다.
     * 예) 카테고리 존재하면 에러
     *  if ( category()->exists([ ID=>$in[ID] ]) ) return $this->error(e()->category_exists);
     *
     * @param array $conds
     * @param string $conj
     * @return bool
     *
     * @example
     *  $found = $this->exists([EMAIL=>$in[EMAIL]]);
     */
    public function exists(array $conds = [], string $conj = 'AND'): bool {
        if ( $conds ) {
            $arr = self::search(conds: $conds, conj: $conj);
            return count($arr) > 0;
        }
        if ( ! $this->idx ) return false;
        $q = "SELECT " . IDX . " FROM " . $this->getTable() . " WHERE " . IDX . " = {$this->idx} ";
        $re = db()->get_var($q);
        if ( $re ) return true;
        else return false;
    }

    /// Helper function of eixsts()
    public function notExists(): bool {
        return !$this->exists();
    }

    /**
     * 특정 레코드를 1개 찾아 현재 객체로 넣어 리턴한다.
     *
     * $this->exits() 와 다른 점은 exists() 는 주어진 조건에 맞는 레코드가 존재하는지 확인하여 boolean 을 리턴한다.
     *  만약, 주어진 조건이 없으면 현재 $this->idx 의 레코드가 존재하는지 확인해서 boolean 을 리턴한다.
     *
     * $this->find() 는 주어진 조건에 맞는 레코드 들 중 1개를 현재 객체에 넣어, 현재 객체를 리턴한다.
     *  이 때, 현재 객체 $this->idx 는 무시된다.
     *  만약, 주어진 조건에 레코드를 찾지 못하면 에러가 설정된다.
     *
     * @param array $conds
     * @param string $conj
     * @return self
     *
     * @example
     *  $user = user()->find([EMAIL => $uid]); // Find user by email
     */
    public function findOne(array $conds, string $conj = 'AND'): self {
        $arr = $this->search(conds: $conds, conj: $conj);
        if ( ! $arr ) return $this->error(e()->entity_not_found);
        $idx = $arr[0][IDX];
        return $this->read($idx);
    }


    /**
     * 현재 Taxonomy 에서 1개의 레코드를 검색해서, 1개의 필드 값을 리턴한다.
     *
     * @param string $select - 1개의 필드만 입력해야 한다. 그 필드의 값을 리턴한다.
     * @param array $conds
     * @param string $conj
     * @return mixed
     *
     * 예제) 현재 글(코멘트)의 루트 글의 카테고리 값 얻기
     *  post()->getVar(CATEGORY_IDX, [IDX => $rootIdx]);
     *
     * 예제) 현재 객체(예: 사용자 entity)의 point 필드의 값 얻기. 사용자의 포인트 값을 얻을 때 사용.
     *  $this->getVar(POINT, [IDX => $this->idx]);
     */
    public function getVar(string $select, array $conds, string $conj='AND'): mixed {
        $arr = self::search(select: $select, limit: 1, conds: $conds, conj: $conj);
        if ( ! $arr ) return $this->error(e()->entity_not_found);
        return $arr[0][$select];
    }



    /**
     * Returns true if the entity is belong to the login user.
     *
     * @attention The entity(entity) idx must be set and the record must have `userIdx` field or false will be returned.
     *   So, login()->isMine() will not work since user record has no `userIdx` field.
     *
     * @usage Use this method to check if the post or comment, file are belong to the login user.
     *
     * @return bool
     */
    public function isMine(): bool {
        if ( notLoggedIn() ) return false;
        if ( ! $this->idx ) return false;

        if ( $this->userIdx == null ) return false;

        return $this->userIdx == login()->idx;
    }


    /**
     * 현재 Taxonomy 를 검색해서 idx 를 배열로 리턴한다.
     *
     * - $where 에 필요한 조건식을 다 만들어 넣는다.
     * - 만약, meta 데이터를 포함한 전체 값이 다 필요하다면, 이 함수를 통해서 'idx' 만 추출한 다음, user(idx)->get() 와 같이 한다.
     * - 이 함수는 객체 배열이 아닌, 결과를 가지고 있는 레코드들의 idx 만 리턴한다.
     * - 원한다면 select: 'name' 또는 select: '*' 와 같이 특정 레코드 또는 전체 레코드를 배열로 리턴 할 수 있다.
     * - 하나의 레코드 또는 하나의 필드를 가져오고자 할 때 사용 할 수 있다.
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @param array $conds - 키/값 조건문.
     * @param string $conj - $conds 의 키/값을 연결할 조건식. 기본 AND.
     * @return array
     *  - empty array([]), If there is no record found.
     *
     * @example tests/next.entity.search.test.php 에 많은 예제가 있다.
     *
     * 예제) 로그인 시, 특장 사용자의 비밀번호를 찾아 비교하기 위해서, 비밀번호 가져오기.
     *  $users = $this->search(select: PASSWORD, conds: [EMAIL => $in[EMAIL]]);
     *  if ( !$users ) return $this->error(e()->user_not_found_by_that_email);
     *  $password = $users[0][PASSWORD];
     *
     * 예제)
     *  user()->search();
     *  user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 2, limit: 3, select: 'idx, name');
     *
     * 예제) 사용자 idx 만 추출해서 전체 정보 출력
     *   $users = user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 1, limit: 3);
     *   foreach( $users as $user) {
     *      d( user( $user[IDX] )->profile() );
     *   }
     *
     * @todo SQL injection
     * @todo $where 에 따옴표 처리.
     */
    public function search(
        string $select='idx',
        string $where='1',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        array $conds=[],
        string $conj = 'AND',
    ): array {
        $table = $this->getTable();
        $from = ($page-1) * $limit;
        if ( $conds ) $where = sqlCondition($conds, $conj);
        $q = " SELECT $select FROM $table WHERE $where ORDER BY $order $by LIMIT $from,$limit ";
        if ( isDebugging() ) d($q);
        return db()->get_results($q, ARRAY_A);
    }



    /**
     * Returns login user's records in array.
     *
     * Helper class for search().
     * It does very much the same as search(), but returns login user's record only.
     *
     *
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @return array
     */
    public function my($select='*', int $page=1, string $order='idx', string $by='DESC', int $limit=10 ): array {
        return $this->search($select, "userIdx=" . login()->idx, $order, $by, $page, $limit);
    }


    /**
     * @param string $where
     * @param array $conds
     * @param string $conj
     * @return int
     */
    public function count(string $where='1', array $conds=[], string $conj = 'AND'): int {
        $table = $this->getTable();
        if ( $conds ) $where = sqlCondition($conds, $conj);
        return db()->get_var(" SELECT COUNT(*) FROM $table WHERE $where");
    }


    public function getTable(): string {
        return DB_PREFIX . $this->taxonomy;
    }


    /**
     * 입력된 $in 에서 현재 테이블의 레코드 필드인 것만 리턴한다.
     * 예를 들어, 사용자 테이블에 'email', 'password', 'name' 필드가 있는데, $in 이 ['email'=>'..', 'name'=>'..', 'yourColor'=>'blue']
     * 의 값이 들어오면, ['email' => '..', 'password'=>'..'] 가 리턴된다.
     * @param $in
     * @return array
     * - 리턴할 값이 없으면 빈 배열이 리턴된다.
     *
     * 예제)
     * d(entity(USERS)->getRecordFields(['email' => 'email@address.com', 'name' => 'name', 'yourColor' => 'blue']));
     * 결과)
     *  Array ( [email] => email@address.com [name] => name )
     */
    public function getRecordFields($in): array {
        $fields = entity($this->taxonomy)->getTableFieldNames();
        $diffs = array_diff(array_keys($in), $fields);
        return array_filter( $in, fn($v, $k) => !in_array($k, $diffs), ARRAY_FILTER_USE_BOTH );
    }



    /**
     * @return array
     *
     * 예제)
     *  d(entity(USERS)->getTableFieldNames());
     * 결과)
     * Array ( [0] => idx [1] => email [2] => password [3] => name [4] => createdAt [5] => updatedAt )
     *
     * @note 메모리 캐시를 한다.
     *
     * @todo EzSQL 의 col_info 를 사용해서, 다른 DB 도 지원 할 수 있도록 한다.
     */
    private $fields = [];
    public function getTableFieldNames(): array {
        $table = $this->getTable();
        if ( isset($this->fields[$table]) ) return $this->fields[$table];
        $q = "SELECT column_name FROM information_schema.columns WHERE table_schema = '".DB_NAME."' AND table_name = '$table'";
        $rows = db()->get_results($q, ARRAY_A);
        $names = [];
        foreach($rows as $row) {
            $names[] = $row['column_name'];
        }
        $this->fields[$table] = $names;
        return $this->fields[$table];
    }

    /**
     * 입력된 $in 에서 현재 테이블의 레코드 필드가 아닌 것들을 리턴한다.
     *
     * 예를 들어, 사용자 테이블에 'email', 'password', 'name' 필드가 있는데, $in 이 ['email'=>'..', 'name'=>'..', 'yourColor'=>'blue']
     * 의 값이 들어오면, ['yourColor' => 'blue'] 가 리턴된다.
     *
     * @param $in
     * @return array
     * - 모두, 레코드 필드이면, 빈 배열을 리턴한다.
     *
     * 예제)
     * d(entity(USERS)->getMetaFields(['email' => 'email@address.com', 'name' => 'name', 'yourColor' => 'blue']));
     * 결과)
     * Array ( [yourColor] => blue )
     *
     */
    public function getMetaFields($in): array {
        $fields = entity($this->taxonomy)->getTableFieldNames();
        $diffs = array_diff(array_keys($in), $fields);
        return array_filter( $in, fn($v, $k) => in_array($k, $diffs), ARRAY_FILTER_USE_BOTH );
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    ///
    /// 여기 아래는 버리는 함수
    ///
    ///
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





    /**
     * @deprecated
     * Set (record) idx of current entity.
     *
     * 현재 instance 에 `idx` 지정이 안되어 있어 지정하거나 변경을 할 수 있다.
     *
     * @param int $idx
     *
     * @return static
     *  - 현재 instance(자식 클래스 instance)를 리턴한다.
     *
     * 예제)
     *      $tt = new TaxonomyTest(123);
     *      isTrue(get_class($tt) == 'TaxonomyTest');
     *      $child = $tt->setIdx(456);
     *      isTrue(get_class($child) == 'TaxonomyTest');
     *
     * 예제)
     *  files()->setIdx(1)->delete();
     */
    public function setIdx(int $idx): static
    {
        $this->idx = $idx;
        return $this;
    }



    /**
     * @deprecated
     * @var array
     */
    private $__entities = [];

    /**
     * @deprecated use read()
     * Returns an entity(record) of a taxonomy(table) and its meta data.
     *
     * If $field and $value are set, then it will return a record and its meta based on that $field and value.
     * If $field and $value are not set, then it wil return the record and its meta based on current `idx`.
     * If a field of entity exists in meta table, then the value of meta table will be used.
     *
     * @attention It does memory cache.
     *  It is important to memory cache if SQL server is far away from PHP application server.
     *  Each query needs to connect to SQL server even if SQL server does some internal query.
     *  It caches based on `$field=$value` pattern.
     *  That means,
     *  `user(77)->profile();` will cache with `idx=77` as `$field=$value` pair.
     *  `user()->get('email', 'user10@gmail.com');` will cache with `email=user10@gmail.com` pair.
     *
     *  Note that, this is only for reading performance improvement. And if there is any data changes on any entity,
     *  Then, it will volatilize and re-cache again. For instance, [user-entity][idx=1] is cached, and
     *  [file-entity][idx] is updated, then all the caches include all other entities will be volatilized..
     *
     * @attention even though the record does not exists, it caches with empty array record.
     *
     * @param string $field
     * @param mixed $value
     * @return mixed
     * - The return type is `mixed` due to the overridden methods returns different data types.
     * - *empty array if the entity does not exists.*
     * - or entity record as array.
     * - It does not return error string or any error.
     *
     * 예제)
     * user()->get('email', 'user10@gmail.com');
     */
    public function get(string $field=null, mixed $value=null, string $select='*', bool $cache = true): mixed {


        if ($field == null ) {
            $field = 'idx';
            $value = $this->idx;
        }
        $fv = "$field=$value";
        if ( $cache && isset($this->__entities[$this->taxonomy]) && isset($this->__entities[$this->taxonomy][$fv]) ) {
//            debug_log("cached: $fv");
//            $this->cnt ++; echo " (cached count: {$this->cnt}) ";

            return $this->__entities[$this->taxonomy][$fv];
        }

        $q = "SELECT $select FROM {$this->getTable()} WHERE `$field`='$value'";
        debug_log($q);
//        d($q);

        $record = db()->get_row($q, ARRAY_A);
        if ( $record ) {
            /**
             * If $select does not have `idx`, then it will not get meta tags.
             */
            if (isset($record['idx'])) {
                $meta = entity($this->taxonomy, $record['idx'])->getMetas();
                $record = array_merge($record, $meta);
            }
        } else {
            $record = [];
        }
        /**
         * If $field is null, then don't cache.
         */
        if ( $field ) {
            if ( ! isset($this->__entities[$this->taxonomy]) ) $this->__entities[$this->taxonomy] = [];
            $this->__entities[$this->taxonomy][$fv] = $record;
            return $this->__entities[$this->taxonomy][$fv];
        } else {
            return $record;
        }
    }


    /**
     * @deprecated
     * Returns a value of a field (of entity table) or meta field(of metas table).
     *
     *
     *
     * @param string $field
     * @param mixed|null $default_value
     *  - default value to be returned if field not exists.
     * @param bool $cache
     *  - to use cached data if exists in cache.
     * @return mixed
     * - null if field not exist in taxonomy or meta.
     * - or value.
     */
    public function value(string $field, mixed $default_value = null, bool $cache = true): mixed {
        $got = self::get(cache: $cache);
        if ( isset($got[$field]) && $got[$field] ) return $got[$field];
        else return $default_value;
    }

    /**
     * @deprecated
     * Short for $this->value();
     * @param string $field
     * @param mixed|null $default_value
     * @param bool $cache
     * @return mixed
     */
    public function v(string $field, mixed $default_value = null, bool $cache = true): mixed {
        return $this->value($field, $default_value, $cache);
    }

    /**
     * @deprecated - use $this->userIdx
     * 현재 entity 의 taxonomy 가 users 라면, 그냥 $this->idx 를 리턴하고,
     * 그렇지 않으면 entity 의 userIdx 필드를 리턴한다.
     * @return int
     */
//    public function userIdx(): int {
//        if ( $this->taxonomy == USERS ) return $this->idx;
//        else return $this->value(USER_IDX);
//    }

}


/**
 * Entity 는 taxonomy 가 입력되므로, 항상 객체를 생성해서 리턴한다.
 * @param string $taxonomy
 * @param int $idx
 * @return Entity
 */
function entity(string $taxonomy, int $idx=0): Entity
{
    return new Entity($taxonomy, $idx);
}
