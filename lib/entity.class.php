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
 * Entity 는 하나의 레코드이다. Taxonomy 는 데이터의 종류로서 하나의 테이블이라 생각하면 된다.
 * Entity 를 생성 할 때, Taxonomy 는 필수이며, $idx 값이 입력되면, 해당 테이블의 해당 레코드 번호로 인식하여, 해당 레코드에 대한 작업을 한다.
 */
class Entity {

    /**
     * @var array
     */
    private array $data = [];

    private string $error = '';
    public bool $hasError = false;

    /**
     * Entity constructor.
     * @param string $taxonomy
     * @param int $idx - 테이블(taxonomy)의 레코드(entity) idx. 예를 들어, 사용자의 경우, 사용자 번호.
     */
    public function __construct(public string $taxonomy, public int $idx)
    {
        if ( $this->idx ) {
//            d($this->idx);
            // @todo
//            $this->read($this->idx);

        }
    }

    public function error(string $code): self {
        $this->error = $code;
        $this->hasError = true;
        return $this;
    }
    public function getError(): string {
        return $this->error;
    }

    /**
     * 주의: 에러가 있으면 빈 배열이 리턴된다.
     * @return array
     */
    public function getData() {
        if ( $this->hasError ) return [];
        return $this->data;
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
    public function __get($name) {
//        if ( $name == 'hasError' ) {
//            return $this->error !== '';
//        }
        if ( $this->hasError ) return null;
        if ( $this->data && isset($this->data[$name]) ) return $this->data[$name];
        else return null;
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
            else unset($in[IDX]);
        }

        $record = $this->getRecordFields($in);
        $record[CREATED_AT] = time();
        $record[UPDATED_AT] = time();


        // Entity 생성 전 훅
        $re = hook()->run("{$this->taxonomy}_before_create", $record, $in);
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
        $re = hook()->run("{$this->taxonomy}_after_create", $this, $in);
        if ( isError($re) ) return $this->error($re);

        return $this;
    }




    /**
     * Update an entity.
     *
     * @attention entity.idx must be set.
     *
     * `idx` 가 지정되어야 한다.
     * $in 이 빈 값으로 들어 올 수 있다. 그러면 updatedAt 만 업데이트를 한다.
     *
     * Taxonomy 에 존재하지 않는 필드는 meta 에 자동 저장(추가 또는 업데이트)된다.
     *
     * 참고로, 'idx=123' 과 같이 'idx' 로 저장된, 캐시 정보를 삭제한다. 즉, 다음 사용 할 때, 다시 캐시를 한다.
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
     * Delete entity(record).
     *
     * The entity `idx` must be set to delete.
     */
    public function delete() {
        if ( ! $this->idx ) return e()->idx_not_set;
        $record = self::get();
        if ( ! $record ) return e()->entity_not_exists;
        $re = db()->delete($this->getTable(), eq(IDX, $this->idx));
        if ( $re === false ) return e()->delete_failed;



        $this->__entities = [];

        return $record;
    }

    /**
     * It does not delete the record. It only updates deletedAt.
     *
     * You may empty the content of the record when that is deleted.
     *
     * @attention `idx` must be set.
     *
     * @return array|string
     * - error string on error.
     * - the deleted record on success.
     *
     */
    public function markDelete(): self|string {
        if ( ! $this->idx ) return e()->idx_not_set;
        if ( $this->deletedAt > 0 ) return e()->entity_deleted_already;
        return self::update([DELETED_AT => time()]);
    }

    /**
     * Entity 를 읽어 현재 객체에 보관한다.
     *
     * $idx 가 주어지면, 해당 $idx 를 읽어, 현재 객체에 보관하고, $this->idx = $idx 와 같이 보관한다.
     * 에러가 있으면 문자열을 리턴하고 그렇지 않으면 현재 객체를 리턴한다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self {
        if ( $this->hasError ) return $this;

        if ( ! $idx ) $idx = $this->idx;

        if ( ! $idx ) return $this->error(e()->idx_not_set);

        $q = "SELECT * FROM {$this->getTable()} WHERE idx=$idx";
        $record = db()->get_row($q, ARRAY_A);
        if ( $record ) {
            $meta = getMeta($this->taxonomy, $record['idx']);
            $this->data = array_merge($record, $meta);
        } else {
            $this->data = [];
        }
        $this->idx = $this->data['idx'];
        return $this;
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
     * @throws Exception
     */
    public function my(int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='*'): array {
        return $this->search("userIdx=" . login()->idx, $page, $limit, $order, $by, $select);
    }


    /**
     * Returns true if the entity exists. or false.
     *
     * The entity.idx must be set or it will return false.
     *
     * @return bool
     */
    public function exists(): bool {
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
     * Returns true if the entity is belong to the login user.
     *
     * @attention The entity(entity) idx must be set and the record must have `userIdx` field or false will be returned.
     *
     * @usage Use this method to check if the post or comment, file are belong to the login user.
     *
     * @return bool
     */
    public function isMine(): bool {
        if ( notLoggedIn() ) return false;
        if ( ! $this->idx ) return false;
        $record = self::get(cache: false);
        if ( ! $record ) return false;
        if ( ! isset($record) ) return false;
        if ( ! $record[USER_IDX] ) return false;
        return $record[USER_IDX] == my(IDX);
    }

    /**
     * 현재 Taxonomy 를 검색한다.
     *
     * - $where 에 필요한 조건식을 다 만들어 넣는다.
     * - 만약, meta 데이터를 포함한 전체 값이 다 필요하다면, 이 함수를 통해서 'idx' 만 추출한 다음, user(idx)->get() 와 같이 한다.
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @param array $in
     * @return mixed
     *  - empty array([]), If there is no record found.
     * @throws Exception
     *
     *
     * 예제)
     *  $users = user()->search();
     *  user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 2, limit: 3, select: 'idx, name');
     *
     * 예제) 사용자 idx 만 추출해서 전체 정보 출력
     *   $users = user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 1, limit: 3);
     *   foreach( $users as $user) {
     *      d( user( $user[IDX])->profile() );
     *   }
     *
     */
    public function search(
        string $where='1', int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='idx'
    ): mixed {
        $table = $this->getTable();
        $from = ($page-1) * $limit;
        $q = " SELECT $select FROM $table WHERE $where ORDER BY $order $by LIMIT $from,$limit ";
        if ( isDebugging() ) d($q);
        $rows = db()->get_results($q, ARRAY_A);
        return $rows;
    }

    /**
     * @param string $where
     */
    public function count(string $where) {
        $table = $this->getTable();
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
     */
    private $fields = [];
    public function getTableFieldNames(): array {
        $table = $this->getTable();
        if ( isset($this->fields[$table]) ) return $this->fields[$table];
        $q = "SELECT column_name FROM information_schema.columns WHERE table_schema = '".DB_NAME."' AND table_name = '$table'";
        $rows = db()->get_results($q, ARRAY_A);
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
    ///
    ///
    /// 여기 아래는 버리는 함수
    ///
    ///
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
     * @deprecated
     * 현재 entity 의 taxonomy 가 users 라면, 그냥 $this->idx 를 리턴하고,
     * 그렇지 않으면 entity 의 userIdx 필드를 리턴한다.
     * @return int
     */
    public function userIdx(): int {
        if ( $this->taxonomy == USERS ) return $this->idx;
        else return $this->value(USER_IDX);
    }

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
