<?php
/**
 * @file post.controller.php
 */

/**
 * Class PostController
 */
class PostController {

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

    /**
     *
     * @param array $in
     *  - $in['idx'] 값이 문자열이면, path 로 인식하고, 숫자이면, idx 로 인식한다.
     * @return array|string
     */
    public function get(array $in): array|string
    {

        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        else return post($in[IDX])->response();



//        if ( isset($in['path']) ) {
//            $arr = explode('/', $in['path']);
//            return post()->getFromPath($arr[3])->response();
//        }
//        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
//        return post($in[IDX])->response();
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
        if ( ! isset($in[CATEGORY_ID]) ) return e()->empty_category_idx;
        $today = date("Ymd");
        $categoryIdx = category($in[CATEGORY_ID])->idx;
        $conds = [
            CATEGORY_IDX => $categoryIdx,
            'Ymd' => $today
        ];
        if ( isset($in[USER_IDX]) && $in[USER_IDX] ) {
            $conds[USER_IDX] = $in[USER_IDX];
        }

        $posts = post()->find($conds, limit: $in['limit'] ?? 10);
        $rets = [];
        foreach($posts as $post) {
            $rets[] = $post->response();
        }
        return $rets;

    }



    public function gets($in) {
        if ( ! isset($in[IDXES]) ) return e()->idx_is_empty;
        $idxes = explode(',', $in[IDXES]);

        $rets = [];
        foreach( $idxes as $idx ) {
            if ( post($idx)->hasError ) continue;
            $rets[] = post($idx)->response();
        }
        return $rets;
    }


    /**
     * @param array $in - See `parsePostSearchHttpParams()` for detail input.
     * @return array|string
     * 
     * 
     * 
     */
    public function search($in): array|string
    {
        $posts = post()->search(object: true, in: $in);
        $res = [];
        foreach($posts as $post) {
            $res[] = $post->response(comments: $in['comments'] ?? -1);
        }
        return $res;
    }


    /**
     * 조건에 맞는 글 수를 리턴한다. 코멘트는 제외.
     * @param $in
     * @return array
     */
    public function count($in): array|string {

        $re = parsePostSearchHttpParams($in);
        if ( isError($re) ) return $re;
        list ($where, $params ) = $re;
        $count =  post()->count(
            where: $where,
            params: $params,
        );
        return [ 'count' => $count ];
    }




    public function vote($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        if ( ! isset($in[CHOICE]) ) return e()->empty_vote_choice;
        if ( notLoggedIn() ) return e()->not_logged_in;
        return post($in[IDX])->vote($in[CHOICE])->response();
    }


    public function report($in): array|string {
        if ( ! isset($in[IDX]) ) return e()->idx_is_empty;
        $post = post($in[IDX]);
        return $post->update(['report' => $post->report + 1])->response();
    }


}
