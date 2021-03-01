<?php

class CategoryRoute {
    public function create($in) {
        return category()->create($in);
    }
    public function get($in) {
        return category($in[IDX] ?? $in[ID])->get();
    }
    public function update($in) {
        return category($in[IDX] ?? $in[ID])->update($in);
    }
    public function delete($in) {
        return category($in[IDX])->delete();
    }
}
