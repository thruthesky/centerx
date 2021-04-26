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
            $q = "SELECT data FROM " . META_TABLE . " WHERE taxonomy=? AND entity=? AND code=?";
            $data = db()->column($q, [$taxonomy, $entity, $code]);
            if ( ! $data ) return null;
            $un = _unserialize($data);
            return $un;
        } else {
            $q = "SELECT code, data FROM " . entity(METAS)->getTable() . " WHERE taxonomy=? AND entity=?";
            $rows = db()->rows($q, [$taxonomy, $entity]);
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

