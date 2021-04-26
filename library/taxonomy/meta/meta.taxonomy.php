<?php
class MetaTaxonomy extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(METAS, $idx);
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

    function update(array $in): self {
        if ( in_array($in[CODE], META_CODE_EXCEPTIONS) ) return $this;
        return parent::update($in);
    }


    /**
     * Updates multiple metas.
     * @param string $taxonomy
     * @param int $idx
     * @param array $kvs
     */
    public function updates(string $taxonomy, int $idx, array $kvs)
    {
        foreach( $kvs as $k => $v ) {
            $re = meta()->update([TAXONOMY => $this->taxonomy, ENTITY => $idx, CODE => $k, DATA => $v ]);
            if ( isError($re) ) {
                // there is an error. continue though,
                continue;
            }
        }
    }




}


function meta() {
    return new MetaTaxonomy(0);
}

