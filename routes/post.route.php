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
        $post = post($in[IDX]);
        if ( $post->isMine() == false ) return  e()->not_your_post;
        return post($in[IDX])->markDelete()->response();
    }

    /**
     * @param $in
     * @return array|string
     */
    public function get($in) {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        return post($in[IDX])->response();
    }

    /**
     * 오늘 쓰여진 글을 찾아 리턴한다.
     *
     * $in['categoryId'] 와 $in['userIdx'] 값을 바탕으로 글 추출하여 배열로 리턴한다.
     * 만약, $in['limit'] 에 값이 들어가면 오늘의 글 중, 그 만큼을 찾아 배열로 리턴한다.
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

        $posts = post()->find($conds, limit: $in['limit']);
        $rets = [];
        foreach($posts as $post) {
            $rets[] = $post->response();
        }
        return $rets;

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


    /**
     * @param $in
     * @return array|string
     * @todo 코드를 복잡하게 하지 않는다. onTop 이나 기타 기능을 제공하지 않는다.
     */
    public function search($in): array|string
    {

        list ($where, $params ) = parsePostListHttpParams($in);


//        $onTop = null;
//
//        if ( isset($in['postOnTop']) && $in['postOnTop'] ) {
//            $onTop = post($in['postOnTop']);
//            if ($onTop->hasError) return $onTop->getError();
//            $categoryId = $onTop->categoryId();
//            $in['where'] = "categoryId=<$categoryId>";
//        }

        $posts = post()->search(
            select: $in['select'] ?? 'idx',
            where: $where,
            params: $params,
            order: $in['order'] ?? IDX,
            by: $in['by'] ?? 'DESC',
            page: $in['page'] ?? 1,
            limit: $in['limit'] ?? 10,
        );

        if (isset($in['searchKey'])) {
            db()->insert(DB_PREFIX . 'search_keys', ['searchKey' => $in['searchKey'], 'createdAt' => time()]);
        }

        $res = [];
//        if ( $onTop ) $res[] = $onTop->response();
        foreach($posts as $post) {
//            if ( $onTop?->idx == $post->idx ) continue;
            $res[] = $post->response();
        }
        return $res;
    }




    public function vote($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        if ( ! isset($in[CHOICE]) ) return e()->empty_vote_choice;
        return post($in[IDX])->vote($in[CHOICE])->response();
    }


    public function report($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        $post = post($in[IDX]);
        return $post->update(['report' => $post->report + 1])->response();
    }


    /**
     * 조건에 맞는 글 수를 리턴한다. 코멘트는 제외.
     * @param $in
     * @return string
     */
    public function count($in): string {
        //
        return post()->count(where: $in['where']);
    }
}
