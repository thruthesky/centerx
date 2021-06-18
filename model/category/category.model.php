<?php
/**
 * @file category.model.php
 */
/**
 * Class CategoryModel
 *
 *
 * @property-read string $id - id
 * @property-read string $title - category title
 * @property-read string $description
 * @property-read string $orgSubcategories - subcategories 를 배열로 하기 전의 원래 subcategories.
 * @property-read string[] $subcategories
 * @property-read string postEditWidget
 * @property-read string postEditWidgetOption
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
 *
 * @property-read string POINT_POST_CREATE
 * @property-read string POINT_POST_DELETE
 * @property-read string POINT_COMMENT_CREATE
 * @property-read string POINT_COMMENT_DELETE
 *
 *
 * @property-read string createPostPoint
 * @property-read string createCommentPoint
 * @property-read string deletePostPoint
 * @property-read string deleteCommentPoint
 *
 *
 */
class CategoryModel extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(CATEGORIES, $idx);
    }



    /**
     * 카테고리 전처리
     *
     * subcategoriesArray 에 콤마로 구분된 카테고리 배열이 저장되는데, 이를 배열로 리턴한다.
     *
     *
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
//        $this->updateMemoryData('orgSubcategories', $this->subcategories);
//        $this->updateMemoryData('subcategories', separateByComma($this->subcategories));
//
        $this->updateMemoryData('subcategoriesArray', separateByComma($this->subcategories));
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
     * @return CategoryModel
     */
    public function update(array $in): self {
        // debug_log('category.class.php::update()', $in);
        if ( isset( $in[Actions::$deletePost]) && $in[Actions::$deletePost] > 0 ) {
            return $this->error(e()->point_must_be_0_or_lower_than_0);
        }
        if ( isset( $in[Actions::$deleteComment]) && $in[Actions::$deleteComment] > 0 ) {
            return $this->error(e()->point_must_be_0_or_lower_than_0);
        }
        return parent::update($in);
    }


    /**
     * @return PostModel[]
     */
    public function reminders(array $in = []): array {
        $where = "categoryIdx={$this->idx} AND reminder='Y' AND parentIdx=0 AND deletedAt=0";
        $params = [];

        // 국가 코드 훅. @see README `HOOK_POST_LIST_COUNTRY_CODE` 참고
        if ( $countryCode = hook()->run(HOOK_POST_LIST_COUNTRY_CODE, $in['countryCode']) ) {
            $where .= " AND countryCode=?";
            $params[] = $countryCode;
        }

        return post()->search(where: $where, params: $params, order: 'listOrder', page: in('page', 1), limit: in('limit', 10), object: true);
    }
}



/**
 * @param int|string $idx - 카테고리 번호 또는 문자열.
 * @return CategoryModel
 *
 * @attention admin permission check must be done before calling this method.
 */
function category(int|string $idx = 0): CategoryModel
{
    // 문자열로 입력되었으면, 카테고리 ID 로 찾아 리턴한다.
    if ( $idx && !is_numeric($idx) ) {
        // If the input is string, then it is considered as category id. And returns Category instance with its idx.
        return category()->findOne([ID => $idx]);
    }
    return new CategoryModel($idx);
}
