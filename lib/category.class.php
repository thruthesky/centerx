<?php


/**
 * Class Category
 *
 *
 * @property-read string $id - id
 * @property-read string $title - category title
 */
class Category extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(CATEGORIES, $idx);
    }

    /**
     * 카테고리 전처리
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        $this->updateData('subcategories', separateByComma($this->subcategories));
        return $this;
    }


    /**
     * @param array $in
     * @return $this
     */
    public function create( array $in ): self {
        if ( isset($in[ID]) == false ) return $this->error(e()->id_is_empty);
        if ( category()->exists([ ID=>$in[ID] ]) ) return $this->error(e()->category_exists);
        return parent::create($in);
    }



    /**
     * @deprecated
     * @param string|null $field
     * @param mixed|null $value
     * @param string $select
     * @param bool $cache
     * @return mixed
     */
    public function get(string $field = null, mixed $value = null, string $select = '*', bool $cache = true): mixed
    {
        $cate = parent::get(select: '*', cache: false);
        if ( ! $cate ) return $cate;

        $subs = $cate['subcategories'] ?? '';
        $cate['subcategories'] = [];
        if ( $subs ) {
            $subs = explode(",", $subs);
            $cate['subcategories'] = [];
            foreach( $subs as $sub ) {
                $cate['subcategories'][] = trim($sub);
            }
        }
        return $cate;
    }

    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return Category
     */
    public function update(array $in): self {
        return parent::update($in);
    }

    /**
     * @attention To delete, entity.idx must be set properly.
     *
     * @return Category
     */
    public function delete(): self {
        return parent::delete();
    }

}


/**
 * @param int|string $idx
 * @return Category
 *
 * @attention admin permission check must be done before calling this method.
 */
function category(int|string $idx = 0): Category
{
    if ( $idx && !is_numeric($idx) ) {
        // If the input is string, then it is considered as category id. And returns Category instance with its idx.
        return category()->findOne([ID => $idx]);
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
 * @deprecated
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