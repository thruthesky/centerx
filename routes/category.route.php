<?php

class CategoryRoute {
    /**
     * @param $in
     * @return array|string
     */
    public function create($in): array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;
        return category()->create($in)->response();
    }
    public function get($in) {
        return category($in[IDX] ?? $in[ID])->response();
    }
    public function update($in) {
        return category($in[IDX] ?? $in[ID])->update($in)->response();
    }
    public function delete($in) {
        return category($in[IDX])->delete()->response();
    }
    public function search($in) {
        $cats = category()->search(limit: $in['limit']);
        $rets = [];
        foreach(ids($cats) as $idx) {
            $cat = category($idx);
            $rets[] = $cat->response();
        }
        return $rets;
    }

    /**
     * Category id 들을 입력 받아서, 배열로 리턴한다.
     *
     * @param $in
     * @return array|string
     */
    public function gets($in) {
        if ( empty($in['ids']) ) return e()->ids_is_empty;
        $rets = [];
        foreach( $in['ids'] as $id ) {
            if ( category($id)->hasError ) continue;
            $rets[] = category($id)->response();
        }
        return $rets;
    }


}
