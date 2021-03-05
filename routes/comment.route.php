<?php

class CommentRoute {
    public function create($in) {
        return comment()->create($in);
    }
    public function update($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return comment($in[IDX])->update($in);
    }
    public function delete($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return comment($in[IDX])->markDelete($in);
    }
    public function get($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return comment($in[IDX])->get();
    }
    public function search($in) {
        return comment()->search(
            where: $in['where'] ?? '1',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            select: $in['select'] ?? '*',
        );
    }
}