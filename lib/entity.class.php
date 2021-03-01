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
     * @param int $idx
     */
    public function setIdx(int $idx) {
        $this->idx = $idx;
    }


    /**
     * entity 에 필드를 저장한다.
     *
     * 만약, Taxonomy 테이블에 존재하지 않는 필드가 입력되면, 자동으로 metas 테이블에 저장한다.
     *
     * 주의: 필드명에 따라서 자동으로 저장할 값이 정해지므로, meta 테이블과 같이 필드가 code, value 인 경우에는 사용 할 수 없다.
     *
     * @param array $in
     * @return int|false - 성공이면, 마지막으로 입력된 idx 를 리턴한다.
     *      - 성공이면, 마지막으로 입력된 idx 를 리턴한다.
     *      - 실패하면 false 가 리턴된다.
     *
     *
     *
     * @note user is_success() to check if it was success()
     *
     * @see readme for detail.
     */
    public function create( array $in ): int|false|string {
        if ( ! $in ) return e()->empty_param;
        if ( isset($in['idx']) ) return e()->idx_must_not_set;

        $record = $this->getRecordFields($in);
        $record[CREATED_AT] = time();
        $record[UPDATED_AT] = time();

        $idx = db()->insert( $this->getTable(), $record );

        if ( !$idx ) return e()->insert_failed;

        $this->createMetas($idx, $this->getMetaFields($in));
        return $idx;
    }


    /**
     * Taxonomy 에 존재하지 않는 필드는 meta 에 자동 저장(추가 또는 업데이트)된다.
     *
     * 참고로, 'idx=123' 과 같이 'idx' 로 저장된, 캐시 정보를 삭제한다. 즉, 다음 사용 할 때, 다시 캐시를 한다.
     * @param $in
     *
     * @return array|string
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
        global $entities;
        if ( ! $in ) return e()->empty_param;
        if ( isset($in['idx']) ) return e()->idx_not_set;

        $up = $this->getRecordFields($in);
        $up[UPDATED_AT] = time();




        $re = db()->update($this->getTable(), $up, eq(IDX, $this->idx ));
        if ( !$re ) return e()->update_failed;

        $this->updateMetas($this->idx, $this->getMetaFields($in));


        $fv = "idx=" . $this->idx;
        unset($entities[ $this->taxonomy ][ $fv ]);

        return $this->get();
    }



    /**
     * Returns an entity(record) of a taxonomy(table).
     *
     * 현재 Taxonomy 테이블 뿐만아니라, 그 meta 값들을 모두 같이 리턴한다.
     *
     * 참고로 사용자(게시글 등) 정보를 검색하는 경우 등을 위해서, $field 와 $value 로 값을 얻을 수 있다.
     * 다만, $field, $value 값이 지정되지 않으면, 현재 taxonomy 의 entity 정보를 리턴한다.
     *
     * @attension 주의해야 할 것은
     *  - Taxonomy 테이블 필드 이름과 meta code(이름)이 겹치면, Taxonomy 필드명을 사용한다.
     *  - 메모리 캐시를 한다. MariaDB 자체적으로 동일한 쿼리를 캐시하지만, DB 서버가 원격에 있다면, 접속하는 것 자체만으로 시간이 많이 걸리므로 캐시하는 것이 맞다.
     *      캐시는 $field=$value 가 맞아야 한다.
     *      예를 들어, 아래의 두 코드에서 동일한 사용자라고 해도, 서로 다르게 캐시된다.
    user(77)->profile(); // idx=77 로 캐시
    user()->get('email', 'user10@gmail.com'); email=user10@gmail.com 으로 캐시
     *
     *
     * @param string $field
     * @param mixed $value
     * @return mixed
     *
     * 예제)
     * user()->get('email', 'user10@gmail.com');
     */
    private $entities = [];
    public function get(string $field=null, mixed $value=null): mixed {
        global $entities;
        if ($field == null ) {
            $field = 'idx';
            $value = $this->idx;
        }
        $fv = "$field=$value";
        if ( isset($entities[$this->taxonomy]) && isset($entities[$this->taxonomy][$fv]) ) return $entities[$this->taxonomy][$fv];
        $q = "SELECT * FROM {$this->getTable()} WHERE `$field`='$value'";
//        debug_log($q);

        $record = db()->get_row($q, ARRAY_A);
        if ( !$record ) return $record;
        $meta = entity($this->taxonomy, $record['idx'])->getMetas();
        $rets = array_merge($record, $meta);
        $entities[$this->taxonomy][$fv] = $rets;
        return $entities[$this->taxonomy][$fv];
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
     * @return mixed
     * @throws Exception
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
    public function search(string $where='1', int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='idx'): mixed {

        $table = $this->getTable();
        $from = ($page-1) * $limit;
        $rows = db()->get_results(" SELECT $select FROM $table WHERE $where ORDER BY $order $by LIMIT $from,$limit ", ARRAY_A);
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
        $fields = entity(USERS)->getTableFieldNames();
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
        $fields = entity(USERS)->getTableFieldNames();
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
     * 현재 테이블의 taxonomy 와 entity idx 와 연결되는 meta 값 1개를 리턴한다.
     *
     * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
     *
     * @param string $code
     * @return bool|int|mixed|null
     */
    public function getMeta(string $code) {
        $q = "SELECT data FROM " . entity(METAS)->getTable() . " WHERE taxonomy='{$this->taxonomy}' AND entity={$this->idx} AND code='$code'";
        $data = db()->get_var($q);
        return unserialize($data);
    }


    /**
     * 현재 테이블(taxonomy)과 연결되는, 그리고 입력된 entity $idx 와 연결되는 meta 값 1개를 저장한다.
     *
     * - 주의: 존재해도 생성을 하려한다. 그래서 에러가 난다. 만약, 존재하면 업데이트를 하려면 updateMetas() 함수를 사용한다.
     *      이 부분에서 실수를 할 수 있으므로 각별히 주의한다.
     *
     * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
     *
     * @param int $idx - taxonomy.idx 이다. 새로운 entity 가 생성될 때, 그 entity 로 연결하거나, 다른 entity 로 연결 할 수 있다.
     * @param string $code
     * @param mixed $data
     * @return mixed
     */
    public function setMeta(int $idx, string $code, mixed $data): mixed
    {
        $table = entity(METAS)->getTable();
        return db()->insert($table, [
            TAXONOMY => $this->taxonomy,
            ENTITY => $idx,
            CODE => $code,
            DATA => serialize($data),
            CREATED_AT => time(),
            UPDATED_AT => time(),
        ]);
    }

    /**
     * 해당 메타가 존재하지 않을 때만, 생성을 한다. 이미 존재한다면, 덮어쓰지 않는다.
     *
     * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
     *
     * @param int $idx
     * @param string $code
     * @param mixed $data
     * @return mixed
     * - 추가되었으면 추가된 meta.idx
     */
    public function setMetaIfNotExists(int $idx, string $code, mixed $data): mixed {
        $re = entity($this->taxonomy, $idx)->getMeta($code);
        if ( !$re ) {
            return $this->setMeta($idx, $code, $data);
        }
        return false;
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
        $table = entity(METAS)->getTable();
        return db()->update(
            $table,
            [DATA => serialize($data), UPDATED_AT => time()],
            db()->where(
                eq(TAXONOMY, $this->taxonomy),
                eq(ENTITY, $idx),
                eq(CODE, $code)
            )
        );
    }


    /**
     *
     * 현재 테이블(taxonomy)의 현재 entity 에 연결된 meta 값 전체를 배열로 리턴한다.
     *
     * 함수는 Taxonomy 와 entity.idx 를 받지 않는다. 따라서 꼭 필요한 경우, 아래의 예제와 같이 Entity 객체를 한번 더 생성해야 한다.
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
            $rets[$row['code']] = unserialize($row['data']);
        }
        return $rets;
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
