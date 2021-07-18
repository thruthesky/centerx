<?php
/**
 * @file category.controller.php
 */

/**
 * Class CategoryController
 */
class CategoryController {
    /**
     * 카페 생성
     *
     * 최소 입력 값은, id 이면 된다.
     *
     * @param $in
     * @return array|string
     */
    public function create($in): array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;
        return category()->create($in)->response();
    }
    public function update($in): array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;
        return category($in[IDX] ?? $in[ID])->update($in)->response();
    }

    /**
     * 하나의 카테고리 정보를 리턴한다.
     * @note 입력 값은 idx, id, categoryId 중 하나가 들어오면 된다.
     * @param $in
     * @return array|string
     */
    public function get($in): array|string
    {
        return category($in[IDX] ?? $in[ID] ?? $in[CATEGORY_ID])->response();
    }

    /**
     * 여러 Category id 들을 입력 받아서, 각 카테고리 정보를 연관 배열로 리턴한다.
     *
     * 이 때, 키는 카테고리 아이디, 값은 카테고리 레코드이다.
     * 만약, 카테고리 레코드를 찾지 못하면, 해당 카테고리 아이디의 값에 에러 문자열이 저장된다.
     *
     * @note 카테고리 idx 또는 카테고리 id 문자열을 콤마로 분리해서 입력하면 된다.
     *  예) "apple, 2, cherry"
     *
     *
     * @param $in
     * @return array|string
     */
    public function gets($in): array|string
    {
        if ( empty($in[IDS]) ) return e()->ids_is_empty;

        if (is_string($in[IDS])) {
            $ids = explode(',', $in[IDS]);
        } else {
            $ids = $in[IDS];
        }

        $rets = [];
        foreach( $ids as $id ) {
            $id = trim($id);
            $cat = category($id);
            if ( $cat->hasError ) {
                $rets[$id] = $cat->getError();
            } else {
                $rets[$id] = $cat->response();
            }
        }
        return $rets;
    }

    public function delete($in): array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;
        return category($in[IDX])->delete()->response();
    }
    public function search($in): array
    {
        $cats = category()->search(
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );

        $rets = [];
        foreach(ids($cats) as $idx) {
            $cat = category($idx);
            $rets[] = $cat->response();
        }
        return $rets;
    }

    public  function count($in) : array | string {
        $count = category()->count();
        return [ 'count' => $count];
    }



}
