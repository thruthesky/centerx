<?php
class MetaTaxonomy extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(METAS, $idx);
    }

    /**
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
        return $this->updateMeta($taxonomy, $entity, $code, $data);
    }


    /**
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


        // Make it array if the input is not an array.
        if ( is_string($code) ) $in = [$code => $data];
        else $in = $code;

        // 배열에 값이 있는 경우만 업데이트. 특히 $code 가 배열로 들어오는 경우, 배열에 값이 없으면 저장하지 않는다.
        foreach( $in as $k=>$v) {
            if ( in_array($k, META_CODE_EXCEPTIONS) ) continue; // 저장하지 않을 meta 키는 통과.
            // 기존 meta 가 존재하면,
            $re = $this->metaExists($taxonomy, $entity, $k);

            if ( $re ) { // 업데이트
                $data = [DATA => _serialize($v), UPDATED_AT => time()];

//                $where = [ TAXONOMY => $taxonomy, ENTITY=>$entity, CODE=>$k ];

                $where = "taxonomy=? AND entity=? AND code=?";
                $re = db()->update( META_TABLE, $data, $where, [$taxonomy,$entity,$k]);
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
                debug_log("table: " . META_TABLE .", record: ", $record);
                $idx = db()->insert(META_TABLE, $record);
                if ( $idx === false ) return e()->meta_insert_failed;
            }
        }

        return '';

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
        $q = "SELECT * FROM " . META_TABLE . " WHERE taxonomy=? AND entity=? AND code=? LIMIT 1";
        $re = db()->row($q, $taxonomy,$entity,$code);
        return count($re) > 0;
    }




    /**
     * @param string $taxonomy
     * @param int $entity
     * @param string|null $code
     * @return mixed
     */
    function get(string $taxonomy, int $entity, string $code = null): mixed {
        if ( $code ) {
            $q = "SELECT data FROM " . $this->getTable() . " WHERE taxonomy=? AND entity=? AND code=?";
            $data = db()->row($q, $taxonomy, $entity, $code);
            if ( ! $data ) return null;
            $un = _unserialize($data);
            return $un;
        } else {
            $q = "SELECT code, data FROM " . $this->getTable() . " WHERE taxonomy=? AND entity=?";
            $rows = db()->rows($q, $taxonomy, $entity);
            $rets = [];
            foreach($rows as $row) {
                $rets[$row['code']] = _unserialize($row['data']);
            }
            return $rets;
        }
    }


    /**
     * Returns the value of the entity field based on the params.
     * @param string $taxonomy
     * @param string $code
     * @param mixed $data
     * @return int
     */
    function entity(string $taxonomy, string $code, mixed $data ): int {
        $row = $this->search(select: 'entity', conds: [TAXONOMY => $taxonomy, CODE => $code, DATA => $data]);
        return $row[ENTITY];
    }



}


function meta() {
    return new MetaTaxonomy(0);
}

