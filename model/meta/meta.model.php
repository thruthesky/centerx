<?php
/**
 * @file meta.model.php
 */
/**
 * Class MetaModel
 *
 * It automatically serialize and unserialize for non-scalar values. @see tests/basic.meta.test.php for sample code.
 *
 * @attention $this->taxonomy will be 'metas'. If you want to get taxonomy of the record, use $this->getData()
 *
 *
 * @property-read int $entity
 * @property-read string $code
 * @property-read string $data
 */
class MetaModel extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(METAS, $idx);
    }


    /**
     * Returns the value of the meta.
     * It only returns value without idx, code, etc.
     *
     * @param string $taxonomy
     * @param int $entity
     * @param string|null $code
     *  - $code 가 null 이면, 전체 taxonomy, entity 의 레코드들을 배열로 리턴.
     *      만약, 결과 레코드가 없으면 빈 배열 리턴.
     *  - $code 문장열이면, 값 1개를 리턴. 만약, 레코드가 없으면 null 리턴.
     *
     * @return mixed
     *  - null on string $code, if there is no record. it does not return error if the code not exists.
     *  - empty array if there is no record.  it does not return error if the code not exists.
     *  - single value of scala on string $code.
     *  - array of scalar or object on array $code.
     */
    function get(string $taxonomy, int $entity, string $code = null): mixed {
        if ( $code ) {
            $q = "SELECT data FROM " . $this->getTable() . " WHERE taxonomy=? AND entity=? AND code=?";
            $row = db()->row($q, $taxonomy, $entity, $code);
            if ( ! $row ) return null;
            $un = $this->unserializeData($row[DATA]);
            return $un;
        } else {
            $q = "SELECT code, data FROM " . $this->getTable() . " WHERE taxonomy=? AND entity=?";
            $rows = db()->rows($q, $taxonomy, $entity);
            $rets = [];
            foreach($rows as $row) {
                $rets[$row['code']] = $this->unserializeData($row['data']);
            }
            return $rets;
        }
    }


    /**
     * Returns the entity of the record based on the params.
     *
     * @param string $taxonomy
     * @param string $code
     * @param mixed $data
     * @return int
     *
     * @example
     *  $userIdx = meta()->entity(USERS, 'plid',$user['plid']);
     *
     */
    function entity(string $taxonomy, string $code, mixed $data ): int {
        $rows = $this->search(select: 'entity', conds: [TAXONOMY => $taxonomy, CODE => $code, DATA => $data]);
        return $rows[0][ENTITY];
    }

    /**
     * Returns an array of entities based on the input.
     * @param array $conds
     * @param string $conj
     * @param int $limit
     * @return array
     */
    function entities(array $conds, string $conj='AND', int $limit=1000) {
        $rows = $this->search(select: ENTITY, conds: $conds, conj: $conj, limit: $limit);
        return ids($rows, ENTITY);
    }

    /**
     *
     * Note, It serialize the data before update.
     * @param array $in
     * @return $this
     * @todo check input. for meta create, only taxonomy, entity, code, data are allowed as input.
     */
    public function create(array $in): self {
        if ( in_array($in[CODE], META_CODE_EXCEPTIONS) ) return $this;

        $in[DATA] = $this->serializeData($in[DATA]);
        return parent::create($in);
    }

    /**
     * Creates multiple metas.
     *
     * Note, it does not update. If there is existing meta keys, it may produce an error.
     *
     * @param string $taxonomy
     * @param int $idx
     * @param array $kvs
     *
     */
    public function creates(string $taxonomy, int $idx, array $kvs): void
    {
        foreach( $kvs as $k => $v ) {
            $re = meta()->create([TAXONOMY => $taxonomy, ENTITY => $idx, CODE => $k, DATA => $v ]);
            if ( isError($re) ) {
                // there is an error. continue though,
                continue;
            }
        }
    }




    /**
     * Updates a meta
     *
     * Note, It serialize the data before update.
     * Note, that Entity::update() only updates when idx is set.
     *      This method allows to update without setting idx. But taxonomy, entity and code are required.
     *      In this case, you cannot change none of taxonomy, entity, code.
     *      If you want to change any of taxonomy, entity, or code, you can do so by providing idx.
     * ```
     *
     * ```
     *
     * Note, that if the code is one of META_CODE_EXCEPTIONS, it silently ignore the update.
     *
     * @param array $in
     * @return $this
     *
     * @todo check input. for meta update, only taxonomy, entity, code, data are allowed as input.
     */
    function update(array $in): self {
        if ( in_array($in[CODE], META_CODE_EXCEPTIONS) ) return $this;
        if ( ! $this->idx ) { // if $this->idx is not set? then fine one.
            $idx = parent::getIdxFromDB([TAXONOMY => $in[TAXONOMY], ENTITY => $in[ENTITY], CODE => $in[CODE]]);
            if ( $idx == 0 ) { // if no entity found, then, create one
                return $this->create($in);
            }
            // entity found, set it as current.
            $this->idx = $idx;
        }
        $in[DATA] = $this->serializeData($in[DATA]);
        return parent::update($in);
    }



    /**
     * Updates multiple metas.
     * @param string $taxonomy
     * @param int $entity
     * @param array $codeDataArray
     */
    public function updates(string $taxonomy, int $entity, array $codeDataArray)
    {
        foreach( $codeDataArray as $k => $v ) {
            $re = meta()->update([TAXONOMY => $taxonomy, ENTITY => $entity, CODE => $k, DATA => $v ]);
            if ( isError($re) ) {
                // there is an error. continue though,
                continue;
            }
        }
    }


    /**
     * Deletes a meta.
     *
     * - If no parameter is set, then it delete the current record.
     * - If $taxonomy is optional. But when taxonomy is set, one of entity or code must be set.
     * - If $entity is given without Taxonomy and code, all the meta of the entity will be deleted.
     * - If $code is set without taxonomy and entity, then all the code will be deleted.
     *
     *
     * @param string $taxonomy
     * @param int $entity
     * @param string $code
     *
     * @return $this
     *
     * @example tests/basic.meta.test.php
     */
    public function delete( string $taxonomy = '', int $entity = 0, string $code = '' ): self {
        if ( $this->hasError ) return $this;

        $data = [];
        if ( empty($taxonomy) && empty($entity) && empty($code)) {
            if ( ! $this->idx ) return $this->error(e()->idx_not_set);
            $data[IDX] = $this->idx;
        } else {
            if ( !empty($taxonomy) && ( empty($entity) && empty($code) ) ) return $this->error(e()->entity_or_code_not_set);
            if ( !empty($taxonomy) )  $data[TAXONOMY] = $taxonomy;
            if ( !empty($entity) ) $data[ENTITY] = $entity;
            if ( !empty($code) ) $data[CODE] = $code;
        }
        $re = db()->delete($this->getTable(), $data);
        if ( $re === false ) return $this->error(e()->delete_failed);
        return $this;
    }


    /**
     * Find one record and unserialize its data.
     * @param array $conds
     * @param string $conj
     * @return $this
     */
    public function findOne(array $conds, string $conj = 'AND'): self {
        $arr = self::search(conds: $conds, conj: $conj, limit: 1);
        if ( ! $arr ) return $this->error(e()->entity_not_found);
        $idx = $arr[0][IDX];
        $this->read($idx);
        $this->setMemoryData([DATA => $this->unserializeData($this->data)]);
        return $this;
    }




    /**
     * Serializing and Un-serializing an array of object to save into data field.
     *
     * Return serialized string if the input $v is not an int, string, or double, or any falsy value.
     * @attention if the input $v is null, then, empty string will be returned to prevent null error on inserting into database record field.
     * @param $v
     * @return mixed
     */
    public function serializeData(mixed $v): mixed {
        if ( is_int($v) || is_numeric($v) || is_float($v) || is_string($v) ) return $v;
        else return serialize($v);
    }

    /**
     * @param mixed $v
     * @return mixed
     */
    public function unserializeData(mixed $v): mixed {
        if ( is_serialized($v) ) return unserialize($v);
        else return $v;
    }





}

/**
 * @param int $idx
 * @return MetaModel
 */
function meta(int $idx=0): MetaModel
{
    return new MetaModel($idx);
}

