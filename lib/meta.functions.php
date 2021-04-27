<?php
/**
 * @file meta.functions.php
 *
 * entity class 형태가 아닌, 함수로만 작성을 했다.
 *
 * @todo entity class 형태로 작성하는 것을 고려한다.
 */

//use function ezsql\functions\{
//    eq,
//};


/**
 * @deprecated
 * 현재 taxonomy 에서 meta 값을 리턴한다.
 * Returns a meta value of the taxonomy and entity.
 *
 *
 * Note that, it works without the real taxonomy table. That means, you can use this method even if the taxonomy table does not exist.
 * Read the readme for details.
 *
 * @param string $taxonomy
 * @param int $entity
 * @param string|null $code - $code 값이 있으면 1개의 값만 리턴한다. 만약, $code 에 값이 주어지지 않으면, 현재 $taxonomy 와 $entity 의 모든 값을 연관 배열로 리턴한다.
 * @return mixed
 * - 값 1개를 리턴 할 때, 값이 없으면 null 을 리턴한다.
 * - 값 1개를 리턴 할 때, 값이 있으면, 값 1개를 리턴한다.
 * - 값을 여러개 리턴 할 때, 값이 없으면 빈 배열 [] 을 리턴한다.
 *
 * @todo move it to meta()->get()
 */
function getMeta(string $taxonomy, int $entity, string $code = null): mixed {
    return meta()->get($taxonomy, $entity, $code);
//
//    if ( $code ) {
//        $q = "SELECT data FROM " . META_TABLE . " WHERE taxonomy=? AND entity=? AND code=?";
//        $data = db()->column($q, [$taxonomy, $entity, $code]);
//        if ( ! $data ) return null;
//        $un = _unserialize($data);
//        return $un;
//    } else {
//        $q = "SELECT code, data FROM " . entity(METAS)->getTable() . " WHERE taxonomy=? AND entity=?";
//        $rows = db()->rows($q, [$taxonomy, $entity]);
//        $rets = [];
//        foreach($rows as $row) {
//            $rets[$row['code']] = _unserialize($row['data']);
//        }
//        return $rets;
//    }
}




/**
 * meta 가 존재하면 true 아니면, false 를 리턴한다.
 *
 * @deprecated Use meta()->exists()
 *
 * @param string $taxonomy
 * @param int $entity
 * @param string $code
 * @return bool
 */
function metaExists(string $taxonomy, int $entity, string $code) {
    $q = "SELECT * FROM " . META_TABLE . " WHERE taxonomy='$taxonomy' AND entity=$entity AND code='$code' LIMIT 1";
    $idx = db()->get_var($q);
    return $idx > 0;
}




/**
 * @deprecated use meta()->entity()
 * taxonomy, code, 그리고 값을 비교해서, entity(taxonomy record idx) 1개를 얻는다.
 *
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
function getMetaEntity(string $taxonomy, string $code, mixed $data ): int {
    $q = "SELECT entity FROM " . entity(METAS)->getTable() . " WHERE taxonomy='$taxonomy' AND code='$code' AND data='$data' LIMIT 1";
//          echo("Q: $q\n");
    return db()->get_var($q) ?? 0;
}

/**
 * @deprecated
 * 검색 조건을 입력 받아, 일치하는 레코드에서 entity (레코드 번호) 값을 리턴한다.
 *
 * @return array
 */
function getMetaEntities(array $conds, string $conj='AND', int $limit=1000 ): array {
    $where = sqlCondition($conds, $conj);
    $q = "SELECT entity FROM " . entity(METAS)->getTable() . " WHERE $where LIMIT $limit";
    $arr = db()->get_results($q, ARRAY_A);
    if ( ! $arr ) return [];
    else return ids($arr, 'entity');
}






/**
 * @deprecated
 * taxonomy 의 $entity 에 연결되는 meta code/data 를 추가 또는 업데이트한다.
 *
 *
 * 참고, taxonomy 는 존재하지 않는 어떤 값이라도 상관 없다.
 * 참고, 1개의 값을 추가/업데이트 할 수 있고, 배열로 여러개의 값을 추가/업데이트 할 수 있다.
 *
 * - 주의: 기존 레코드가 존재하지 않으면 추가를 한다.
 *
 * @param string $taxonomy
 * @param int $entity
 * @param array|string $code - 문자열이면 1개의 값, 배열이면 여러개의 값을 저장한다.
 * @param mixed $data
 * @return string
 *  - 에러가 있으면 에러 문자열
 *  - 에러가 없으면 빈 문자열이 리턴된다.
 */
function updateMeta(string $taxonomy, int $entity, array|string $code, mixed $data=null): string {

    $table = META_TABLE;

    // Make it array if the input is not an array.
    if ( is_string($code) ) $in = [$code => $data];
    else $in = $code;

    // 배열에 값이 있는 경우만 업데이트. 특히 $code 가 배열로 들어오는 경우, 배열에 값이 없으면 저장하지 않는다.
    foreach( $in as $k=>$v) {
        if ( in_array($k, META_CODE_EXCEPTIONS) ) continue; // 저장하지 않을 meta 키는 통과.
        // 기존 meta 가 존재하면,
        $re = metaExists($taxonomy, $entity, $k);
        if ( $re ) { // 업데이트
            $re = db()->update( $table, [DATA => _serialize($v), UPDATED_AT => time()], db()->where( eq(TAXONOMY, $taxonomy), eq(ENTITY, $entity), eq(CODE, $k) ) );
            if ( $re === false ) return e()->meta_update_failed;
        } else { // 아니면, 생성
            $record = [
                TAXONOMY => $taxonomy,
                ENTITY => $entity,
                CODE => $k,
                DATA => _serialize($v),
                CREATED_AT => time(),
                UPDATED_AT => time(),
            ];
            debug_log("table: $table, record: ", $record);
            $idx = db()->insert($table, $record);
            if ( $idx === false ) return e()->meta_insert_failed;
        }
    }

    return '';

}


/**
 * @deprecated
 * 참고, updateMeta() 함수의 alias 이다.
 *
 * 기존에 존재하면 업데이트하고, 존재하지 않으면 추가한다.
 *
 * 현재 테이블(taxonomy)과 연결되는, 그리고 입력된 entity $idx 와 연결되는 meta 값 1개를 저장한다.
 *
 * - 주의: 존재해도 생성을 하려한다. 그래서 에러가 난다. 만약, 존재하면 업데이트를 하려면 updateMetas() 함수를 사용한다.
 *      이 부분에서 실수를 할 수 있으므로 각별히 주의한다.
 *
 * - entity(taxonomy)->updateMeta() 와 같이 taxonomy 에 아무 값이나 주고, 바로 호출 할 수 있다. 실제 taxonomy 테이블은 존재하지 않아도 된다.
 *
 * 참고, null 이나 false 의 값을 저장하면 _serialized() 함수에 의해서 seirlaized 되어 저장된다. 즉, 저장 할 수 있다.
 * 참고, META_CODE_EXCEPTIONS 에 기록된 이름은 meta 로 저장되지 않는다.
 *
 *
 * @param string $taxonomy
 * @param int $entity - taxonomy.idx 이다. 새로운 entity 가 생성될 때, 그 entity 로 연결하거나, 다른 entity 로 연결 할 수 있다.
 * @param string $code
 * @param mixed $data
 * @return string
 *  - 1개를 저장 할 때, 저장되지 않았으면 false 가 리턴된다.
 */
function addMeta(string $taxonomy, int $entity, mixed $code, mixed $data=null): string
{
    return updateMeta($taxonomy, $entity, $code, $data);
}

/**
 * @deprecated
 * 메타 레코드가 존재하지 않으면, 새로운 메타를 추가한다.
 * @param string $taxonomy
 * @param int $entity
 * @param mixed $code
 * @param mixed|null $data
 * @return string
 */
function addMetaIfNotExists(string $taxonomy, int $entity, mixed $code, mixed $data=null) {
    if ( metaExists($taxonomy, $entity, $code) ) return '';
    return updateMeta($taxonomy, $entity, $code, $data);
}

/**
 * @deprecated
 * Serializing and Un-serializing an array of object to save into data field.
 *
 * Return serialized string if the input $v is not an int, string, or double, or any falsy value.
 * @attention if the input $v is null, then, empty string will be returned to prevent null error on inserting into database record field.
 * @param $v
 * @return mixed
 */
function _serialize(mixed $v): mixed {
    if ( $v === null ) return '';
    if ( is_int($v) || is_numeric($v) || is_float($v) || is_string($v) || empty($v) ) return $v;
    else return serialize($v);
}

/**
 * @deprecated
 * @param mixed $v
 * @return mixed
 */
function _unserialize(mixed $v): mixed {
    if ( is_serialized($v) ) return unserialize($v);
    else return $v;
}




