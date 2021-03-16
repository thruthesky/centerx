<?php


class PostRoute {

    public function create($in) {
        return post()->create($in)->response();
    }
    public function update($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        $post = post($in[IDX]);
        if ( $post->isMine() == false ) return  e()->not_your_post;
        return $post->update($in)->response();
    }
    public function delete($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->markDelete()->response();
    }
    public function get($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->response();
    }

    public function gets($in) {
        if ( ! isset($in['idxes']) ) return e()->idx_is_empty;
        $idxes = explode(',', $in['idxes']);

        $rets = [];
        foreach( $idxes as $idx ) {
		if ( post($idx)->hasError ) continue;
            $rets[] = post($idx)->response();
        }
        return $rets;
    }

    public function search($in) {
        $posts = post()->search(
            select: $in['select'] ?? 'idx',
            where: $in['where'] ?? '1',
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );
        $res = [];
        foreach($posts as $post) {
            $res[] = $post->response();
        }
        return $res;
    }




    public function vote($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->vote($in[CHOICE])->response();
    }

}
