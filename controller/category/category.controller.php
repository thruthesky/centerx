<?php
/**
 * @file category.controller.php
 */

/**
 * Class CategoryController
 */
class CategoryController {
    /**
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
    public function get($in): array|string
    {
        return category($in[IDX] ?? $in[ID])->response();
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

    /**
     * Category id 들을 입력 받아서, 배열로 리턴한다.
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
            if ( category($id)->hasError ) continue;
            $rets[] = category($id)->response();
        }
        return $rets;
    }


}
