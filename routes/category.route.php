<?php

class CategoryRoute {
    public function create($in) {
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
}
