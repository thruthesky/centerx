<?php
/**
 * @file entity.class.php
 */
use function ezsql\functions\{
    eq,
    neq,
    ne,
    lt,
    lte,
    gt,
    gte,
    isNull,
    isNotNull,
    like,
    in,
    notLike,
    notIn,
    between,
    notBetween,

    orderBy,
    limit,
};

/**
 * Class Entity
 *
 * Entity 는 하나의 레코드이다. Taxonomy 는 데이터의 종류로서 하나의 테이블이라 생각하면 된다.
 * Entity 를 생성 할 때, Taxonomy 는 필수이며, $idx 값이 입력되면, 해당 테이블의 해당 레코드 번호로 인식하여, 해당 레코드에 대한 작업을 한다.
 */
class Entity {


    /**
     * Entity constructor.
     * @param string $taxonomy
     * @param int $idx - 테이블(taxonomy)의 레코드(entity) idx. 예를 들어, 사용자의 경우, 사용자 번호.
     */
    public function __construct(public string $taxonomy, public int $idx)
    {
    }


    /**
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
     * Create a entity(record) with given $in.
     *
     *
     * entity 에 필드를 저장한다.
     *
     * 만약, Taxonomy 테이블에 존재하지 않는 필드가 입력되면, 자동으로 metas 테이블에 저장한다.
     *
     * 주의: 필드명에 따라서 자동으로 저장할 값이 정해지므로, meta 테이블과 같이 필드가 code, value 인 경우에는 사용 할 수 없다.
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
     * @return array|string
     * @example
     * $idx = entity(CATEGORIES)->create($in);
     * return entity(CATEGORIES, $idx)->get();
     *
     *
     * @see readme for detail.
     *
     *
     */
    public function create( array $in ): array|string {

        if ( ! $in ) return e()->empty_param;

        /// If idx is set and has value, return error.
        if ( isset($in[IDX]) ) {
            if ( $in[IDX] ) return e()->idx_must_not_set;
            else unset($in[IDX]);
        }

        $record = $this->getRecordFields($in);
        $record[CREATED_AT] = time();
        $record[UPDATED_AT] = time();


        // Entity 생성 전 훅
        $re = hook()->run("{$this->taxonomy}_before_create", $record, $in);
        debug_log("훅 리턴 값:", $re);
        if ( isError($re) ) return $re;

        $idx = db()->insert( $this->getTable(), $record );

//        debug_log("IDX", $idx);

        if ( !$idx ) return e()->insert_failed;

        $this->createMetas($idx, $this->getMetaFields($in));


        $created = self::get(IDX, $idx);

        // Entity 생성 후 훅
        $re = hook()->run("{$this->taxonomy}_after_create", $created, $in);
        if ( isError($re) ) return $re;


        $this->__entities = [];
        return $created;
    }



    /**
     * Update an entity.
     *
     * @attention entity.idx must be set.
     *
     * Taxonomy 에 존재하지 않는 필드는 meta 에 자동 저장(추가 또는 업데이트)된다.
     *
     * 참고로, 'idx=123' 과 같이 'idx' 로 저장된, 캐시 정보를 삭제한다. 즉, 다음 사용 할 때, 다시 캐시를 한다.
     * @param $in
     *
     * @return array|string
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
     */
    public function update(array $in): array|string {

        if ( ! $in ) return e()->empty_param;

        //
        if ( ! $this->idx ) return e()->idx_not_set;

        $up = $this->getRecordFields($in);
        $up[UPDATED_AT] = time();


        $re = db()->update($this->getTable(), $up, eq(IDX, $this->idx ));

        if ( $re === false ) return e()->update_failed;


        $this->updateMetas($this->idx, $this->getMetaFields($in));

        $fv = "idx=" . $this->idx;


        $this->__entities = [];

        $got = self::get();


        return $got;
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
    public function markDelete(): array|string {
        if ( ! $this->idx ) return e()->idx_not_set;
        $record = self::get();
        if ( $record[DELETED_AT] ) return e()->entity_deleted_already;
        self::update([DELETED_AT => time()]);
        return $record;
    }


    /**
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
    private $__entities = [];
//    private $cnt = 0;
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
     * 단순히, updateMeta() 를 재 지정한 것이다.
     *
     * 현재 테이블(taxonomy)와 레코드(entity)로 키, 값을 저장한다.
     *
     * 예를 들면, 사용자의 경우, taxonomy 는 users, entity 는 회원 번호(idx) 가 된다.
     *
     * @param int $idx - taxonomy.idx 이다. 회원 가입 등에서 taxonomy entity 가 새로 생성되는 경우를 위해서, taxonomy entity idx 값을 입력 받는다.
     * @param array $in
     * @return array
     * - 코드를 생성한 결과를 리턴한다. 키는 taxonomy.entity.idx, 값은 생성되었으면, meta 테이블의 idx 실패면, false.
     */
    public function createMetas(int $idx, array $in): array
    {
        return $this->updateMetas($idx, $in);
    }


    /**
     * meta 값 들을 추가 또는 업데이트 한다.
     *
     * - 해당 taxonomy, entity, code 가 존재하지 않으면 추가한다.
     *
     * @param int $idx
     * @param array $in
     * @return array
     */
    public function updateMetas(int $idx, array $in): array
    {
        $table = entity(METAS)->getTable();
        $rets = [];
        foreach( $in as $k=>$v) {
            $result = db()->select($table, 'idx', eq(TAXONOMY, $this->taxonomy), eq(ENTITY, $idx), eq(CODE, $k));
            if ( $result ) {
                $metaIdx = $this->updateMeta($idx, $k, $v);
            } else {
                $metaIdx = $this->setMeta($idx, $k, $v);
            }
            $rets[$idx] = $metaIdx;
        }
        return $rets;
    }


    /**
     * 현재 taxonomy 에서 meta 값을 리턴한다.
     * Returns a meta value of the taxonomy and entity.
     *
     *
     * Note that, it works without the real taxonomy table. That means, you can use this method even if the taxonomy table does not exist.
     * Read the readme for details.
     *
     * @param string $code
     * @return mixed
     * - If record does not exists, it returns null.
     * - Or meta value
     *
     * @todo 더 많은 테스트 코드를 작성 할 것.
     */
    public function getMeta(string $code, mixed $data = null): mixed {

        $q = "SELECT data FROM " . entity(METAS)->getTable() . " WHERE taxonomy='{$this->taxonomy}' AND entity={$this->idx} AND code='$code'";

//          echo("Q: $q\n");
        $data = db()->get_var($q);
        $un = $this->_unserialize($data);
        return $un;
    }


    /**
     * 현재 taxonomy 에서 code=$code AND data=$data 와 같이 비교해서, data 값이 맞으면 entity 를 리턴한다.
     * 이 때에는 현재 idx 는 사용하지 않는다(무시된다).
     * 현재 idx 값을 모르고, taxonomy 와 code, 그리고 data 를 알고 있는데, entity(userIdx 등)을 몰라서 찾고자 하는 경우 사용 할 수 있다.
     *
     * @attention 주의 할 점은, 맨 마지막 정보의 entity 값을 리턴한다.
     *
     * @param string $code
     * @param mixed $data
     *
     * @return int
     *
     * @example
     *  user()->getMetaEntity('plid', $user['plid']);
     *
     * @todo $data 에 따옴표가 들어 갈 때, 에러가 나는지 확인 할 것.
     */
    public function getMetaEntity(string $code, mixed $data ): int {
        $q = "SELECT entity FROM " . entity(METAS)->getTable() . " WHERE taxonomy='{$this->taxonomy}' AND code='$code' AND data='$data' ORDER BY idx DESC LIMIT 1";
//          echo("Q: $q\n");
        return db()->get_var($q) ?? 0;
    }







    /**
     * 현재 테이블(taxonomy)과 연결되는, 그리고 입력된 entity $idx 와 연결되는 meta 값 1개를 저장한다.
     *
     * - 주의: 존재해도 생성을 하려한다. 그래서 에러가 난다. 만약, 존재하면 업데이트를 하려면 updateMetas() 함수를 사용한다.
     *      이 부분에서 실수를 할 수 있으므로 각별히 주의한다.
     *
     * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
     *
     *
     * @attention Don't save null.
     *
     * @param int $idx - taxonomy.idx 이다. 새로운 entity 가 생성될 때, 그 entity 로 연결하거나, 다른 entity 로 연결 할 수 있다.
     * @param string $code
     * @param mixed $data
     * @return mixed
     */
    public function setMeta(int $idx, string $code, mixed $data): mixed
    {
        if ( in_array($code, META_CODE_EXCEPTIONS) ) return false;
        $table = entity(METAS)->getTable();
        return db()->insert($table, [
            TAXONOMY => $this->taxonomy,
            ENTITY => $idx,
            CODE => $code,
            DATA => $this->_serialize($data),
            CREATED_AT => time(),
            UPDATED_AT => time(),
        ]);
    }

    /**
     * Add(or set) a meta & value only if it does not exists. If the meta exists already, then it doesn't do anything.
     *
     * Note, since `idx` is passed over parameter, entity.`idx` is ignored.
     *
     * @attention Don't save null.
     *
     * @param int $idx
     * @param string $code
     * @param mixed $data
     * @return mixed
     *  - false if the meta was not added.
     *  - idx number if the meta was added.
     */
    public function setMetaIfNotExists(int $idx, string $code, mixed $data): mixed {
        $re = entity($this->taxonomy, $idx)->getMeta($code);
        if ( $re === null ) {
            return $this->setMeta($idx, $code, $data);
        }
        return false;
    }
    /// Alias of setMetaIfNotExists()
    public function addMetaIfNotExists(int $idx, string $code, mixed $data): mixed {
        return $this->setMetaIfNotExists($idx, $code, $data);
    }

    /**
     * 현재 테이블(taxonomy)의 $idx 에 연결되는 meta 데이터를 업데이트한다.
     *
     * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
     *
     * - 주의: 존재하지 않아도 업데이트 하려한다. 만약, 존재하지 않으면 생성하려 한다면, updateMetas() 함수를 사용한다.
     *      이 부분에서 실수를 할 수 있으므로 각별히 주의한다.
     *
     * @param int $idx
     * @param string $code
     * @param mixed $data
     * @return bool|mixed
     */
    public function updateMeta(int $idx, string $code, mixed $data) {
        if ( in_array($code, META_CODE_EXCEPTIONS) ) return false; // This may not be needed since it only updates and META_CODE_EXCEPTIONS are not saved at very first.
        $table = entity(METAS)->getTable();
        return db()->update(
            $table,
            [DATA => $this->_serialize($data), UPDATED_AT => time()],
            db()->where(
                eq(TAXONOMY, $this->taxonomy),
                eq(ENTITY, $idx),
                eq(CODE, $code)
            )
        );
    }


    /**
     * Returns a meta value based on current taxonomy and entity.
     * So, entity idx must be set.
     * You may instantiate another object with entity.idx if you only have taxonomy.
     *
     *
     * @return array
     *
     * 예제)
     *  entity($this->taxonomy, $record['idx'])->getMetas();
     */
    public function getMetas(): array {
        $q = "SELECT code, data FROM " . entity(METAS)->getTable() . " WHERE taxonomy='{$this->taxonomy}' AND entity={$this->idx}";
        $rows = db()->get_results($q, ARRAY_A);
        $rets = [];
        foreach($rows as $row) {
            $rets[$row['code']] = $this->_unserialize($row['data']);
        }
        return $rets;
    }

    /**
     * Return serialzied string if the input $v is not an int, string, or double.
     * @param $v
     */
    public function _serialize(mixed $v): mixed {
        if ( is_int($v) || is_numeric($v) || is_float($v) || is_string($v) ) return $v;
        else return serialize($v);
    }
    public function _unserialize(mixed $v): mixed {
        if ( is_serialized($v) ) return unserialize($v);
        else return $v;
    }


    /**
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
     * 현재 entity 의 taxonomy 가 users 라면, 그냥 $this->idx 를 리턴하고,
     * 그렇지 않으면 entity 의 userIdx 필드를 리턴한다.
     * @return int
     */
    public function userIdx(): int {
        if ( $this->taxonomy == USERS ) return $this->idx;
        else return $this->value(USER_IDX);
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
