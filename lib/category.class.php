<?php

use function JmesPath\search;

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
 *
 * @attention admin permission check must be done before calling this method.
 */
function category(int|string $idx = 0) {
    if ( $idx && !is_numeric($idx) ) {
        // If the input is string, then it is considered as category id. And returns Category instance with its idx.
        $record = entity(CATEGORIES)->get(ID, $idx);
        if ( isError($record) ) return category();
        if ($record) return category($record[IDX]);
        return category();
    }

    return new Category($idx);
}

/**
 * Returns all the categories including their records and metas.
 */
function categories() {
    return category()->search(select: '*');
}

/**
 * Returns all the existing category ids.
 */
function search_categories() {
    $categories = category()->search(select: 'id');

    $cats = '';
    if ( ! empty($categories) ) {
        foreach ($categories as $category) {
            if ( $cats != '' ) $cats = $cats . ',';
            $cats = $cats . $category[ID];
        }
    }
    return $cats;
}