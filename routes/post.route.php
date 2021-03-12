<?php


class PostRoute {

    public function create($in) {
        return post()->create($in)->response();
    }
    public function update($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->update($in)->response();
    }
    public function delete($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->markDelete()->response();
    }
    public function get($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->response();
    }
    public function search($in) {
        return post()->search(
            select: $in['select'] ?? '*',
            where: $in['where'] ?? '1',
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );
    }




    public function vote($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->vote($in[CHOICE])->response();
    }

}
