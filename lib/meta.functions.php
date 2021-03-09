<?php



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
function createMetas(int $idx, array $in): array
{
    return updateMetas($idx, $in);
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
function updateMetas(string $taxonomy, int $entity, array $in): array
{
    $table = entity(METAS)->getTable();
    $rets = [];
    foreach( $in as $k=>$v) {
        $result = db()->get_row("SELECT * FROM " . META_TABLE . " WHERE taxonomy='$taxonomy' AND entity=$entity AND code='$k'");
        if ( $result ) {
            $metaIdx = updateMeta($taxonomy, $entity, $k, $v);
        } else {
            $metaIdx = setMeta($taxonomy, $entity, $k, $v);
        }
        $rets[] = $metaIdx;
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
function getMeta(string $code, mixed $data = null): mixed {

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
function getMetaEntity(string $code, mixed $data ): int {
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

