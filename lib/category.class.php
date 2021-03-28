<?php


/**
 * Class Category
 *
 *
 * @property-read string $id - id
 * @property-read string $title - category title
 * @property-read string $description
 * @property-read string[] $subcategories
 * @property-read string POINT_POST_CREATE
 * @property-read string POINT_POST_DELETE
 * @property-read string POINT_COMMENT_CREATE
 * @property-read string POINT_COMMENT_DELETE
 * @property-read string POINT_HOUR_LIMIT
 * @property-read string POINT_HOUR_LIMIT_COUNT
 * @property-read string POINT_DAILY_LIMIT_COUNT
 * @property-read string BAN_ON_LIMIT
 * @property-read string postEditWidget
 * @property-read string postViewWidget
 * @property-read string postListHeaderWidget
 * @property-read string postListWidget
 * @property-read string paginationWidget
 * @property-read string listOnView
 * @property-read string noOfPostsPerPage
 * @property-read string noOfPagesOnNav
 * @property-read string returnToAfterPostEdit
 * @property-read string mobilePostListWidget
 * @property-read string mobilePostViewWidget
 *
 */
class Category extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(CATEGORIES, $idx);
    }

    /**
     * 카테고리 전처리
     *
     * subcategories 에 콤마로 구분된 카테고리 배열이 저장되는데, 이를 배열로 리턴한다.
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
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return Category
     */
    public function update(array $in): self {
        debug_log('category.class.php::update()', $in);
        if ( isset( $in[POINT_POST_DELETE]) && $in[POINT_POST_DELETE] > 0 ) {
            return $this->error(e()->point_must_be_0_or_lower_than_0);
        }
        if ( isset( $in[POINT_COMMENT_DELETE]) && $in[POINT_COMMENT_DELETE] > 0 ) {
            return $this->error(e()->point_must_be_0_or_lower_than_0);
        }
        return parent::update($in);
    }

    /**
     * @attention To delete, entity.idx must be set properly.
     *
     * @return Category
     */
//    public function delete(): self {
//        return parent::delete();
//    }


    /**
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        else return $this->getData();
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
