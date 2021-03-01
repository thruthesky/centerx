<?php


class Category extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(CATEGORIES, $idx);
    }

    public function create( array $in ): array|string {
        if ( isset($in[ID]) == false ) return e()->id_is_empty;
        $cat = category($in[ID]);
        if ( $cat->exists() ) return e()->category_exists;
        return parent::create($in);
    }

    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string {
        return parent::update($in);
    }
    /**
     * @attention To delete, entity.idx must be set properly.
     *
     * @return array|string
     */
    public function delete(): array|string {
        return parent::delete();
    }

}


/**
 * @param int|string $idx
 * @return Category
 */
function category(int|string $idx = 0) {
    if ( $idx && !is_numeric($idx) ) {
        // If the input is string, then it is considered as category id. And returns Category instance with its idx.
        $record = entity(CATEGORIES)->get(ID, $idx);
        if ($record) return category($record[IDX]);
        return category();
    }

    return new Category($idx);
}