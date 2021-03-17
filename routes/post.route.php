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

    /**
     * 오늘 쓰여진 글을 찾아 리턴한다.
     *
     * $in['categoryId'] 와 $in['userIdx'] 값을 바탕으로 글 1개를 추출하는데,
     * 만약, 동일한 조건(categoryId 와 userIdx) 에 여러개의 글이 있으면 최근글 1개를 리턴한다.
     *
     * @param $in
     * @return array|string
     * - 만약, 오늘 글을 찾지 못하면, error_entity_not_found 에러가 리턴된다.
     */
    public function today($in): array | string {
        $today = date("Ymd");
        $categoryIdx = category($in[CATEGORY_ID])->idx;
        $conds = [
            CATEGORY_IDX => $categoryIdx,
            'Ymd' => $today
        ];
        if ( isset($in[USER_IDX]) && $in[USER_IDX] ) {
            $conds[USER_IDX] = $in[USER_IDX];
        }
        return post()->findOne($conds)->response();
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

    // public function gets($in) {
    //     if ( ! isset($in['idxes']) ) return e()->idx_is_empty;
    //     $idxes = explode(',', $in['idxes']);

    //     $rets = [];
    //     foreach( $idxes as $idx ) {
    //         /// 데이터가 존재하지 않으면, 리턴되지 않는다.
    //         if ( post($idx)->exists() == false ) continue;
    //         $post = post($idx)->get();
    //         $rets[] = $post;
    //     }
    //     return $rets;
    // }

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
