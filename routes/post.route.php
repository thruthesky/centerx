<?php


class PostRoute {
    public function create($in) {
        return post()->create($in);
    }
    public function update($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->update($in);
    }
    public function delete($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->markDelete($in);
    }
    public function get($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->get();
    }
    public function gets($in) {
    if ( ! isset($in['idxes']) ) return e()->idx_is_empty;
    $idxes = explode(',', $in['idxes']);

    $rets = [];
    foreach( $idxes as $idx ) {
	if ( post($idx)->exists == false ) continue;
        $post = post($idx)->get();
	$rets[] = $post;
    }
    return $rets;
}
    public function search($in) {
        return post()->search(
            where: $in['where'] ?? '1',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            select: $in['select'] ?? '*',
        );
    }



    public function vote($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return postTaxonomy($in[IDX])->vote($in[CHOICE]);
    }

}
