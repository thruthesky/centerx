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
}
