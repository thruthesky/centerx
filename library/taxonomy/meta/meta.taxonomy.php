<?php
/**
 * @file meta.taxonomy.php
 */
/**
 * Class MetaTaxonomy
 *
 * @attention $this->taxonomy will be 'metas'. If you want to get taxonomy of the record, use $this->getData()
 *
 * @property-read int $entity
 * @property-read string $code
 * @property-read string $data
 */
class MetaTaxonomy extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(METAS, $idx);
    }


    /**
     * Returns the value of the meta.
     *
     * @param string $taxonomy
     * @param int $entity
     * @param string|null $code
     * @return mixed
     *  - null on string $code, if there is no record.
     *  - empty array on array $code, if there is no record.
     *  - single value of scalar of object on string $code.
     *  - array of scalar or object on array $code.
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

    /**
     * @param array $in
     * @return $this
     */
    public function create(array $in): self {
        if ( in_array($in[CODE], META_CODE_EXCEPTIONS) ) return $this;

        return parent::create($in);
    }

    /**
     * Creates multiple metas.
     *
     * @param string $taxonomy
     * @param int $idx
     * @param array $kvs
     */
    public function creates(string $taxonomy, int $idx, array $kvs): void
    {
        foreach( $kvs as $k => $v ) {
            $re = meta()->create([TAXONOMY => $this->taxonomy, ENTITY => $idx, CODE => $k, DATA => $v ]);
            if ( isError($re) ) {
                // there is an error. continue though,
                continue;
            }
        }
    }

    /**
     * Updates a meta
     *
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
     */
    function update(array $in): self {
        if ( in_array($in[CODE], META_CODE_EXCEPTIONS) ) return $this;
        if ( ! $this->idx ) {
            $idx = parent::getIdx([TAXONOMY => $in[TAXONOMY], ENTITY => $in[ENTITY], CODE => $in[CODE]]);
            if ( $idx == 0 ) return $this->error( e()->entity_not_found );
            $this->idx = $idx;
        }
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
            $re = meta()->update([TAXONOMY => $this->taxonomy, ENTITY => $entity, CODE => $k, DATA => $v ]);
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
     */
    public function delete( string $taxonomy = '', int $entity = 0, string $code = '' ): self {

        return $this;
    }
}


function meta() {
    return new MetaTaxonomy(0);
}
