<?php
/**
 * @file post-taxonomy.class.php
 */

/**
 * Class Forum
 *
 * This is a special class and is the parent class of post taxonomy, comment taxonomy, and all taxonomies that uses `posts` table.

 * 글과 관련된 작업을 하는 class.
 * 글이라면 단순히 게시글 뿐만아니라, 코멘트, 블로그 글, 쇼핑몰 상품 글 등 posts 테이블에 저장되는 모든 것을 말한다.
 * 각 글 타입마다 클래스가 따로 있을 수 있는데(예: Post, Comment), 그런 경우 이 클래스를 상속해야 한다. 이 클래스에는 추천과 같은 범용적인 코드를 가지고
 * 있다.
 *
 *
 * @property-read int categoryIdx
 * @property-read int parentIdx
 * @property-read string files
 */
class Forum extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POSTS, $idx);
    }

    /**
     *
     * When creating the current article (or comment), the points earned by the author are updated in $this->data.
     *
     * Acquired points are recorded only in point_histories, and the value is read and applied to the current $this->data memory variable.
     * This function can be used with the post/comment read() function and immediately after the point update in the post/comment.
     *
     * For reference, use similar code in PointRoute::postCreate().
     *
     * @todo When writing a post/comment, consider putting the acquired points directly into the posts.pointApplied field.
     */
    public function patchPoint() {
        if ( $this->parentIdx ) $action =  Actions::$createCommentPoint;
        else $action = Actions::$createPostPoint;
        $point = act()->last(POSTS, $this->idx, $action)?->toUserPointApply ?? 0;
        $this->updateMemory('appliedPoint', $point);
    }
    /**
     *
     * 동일한 투표를 두 번하면, 취소가 된다. 찬성 투표를 했다가 찬성을 하면 취소.
     * 찬성을 했다가 반대를 하면, 반대 투표로 변경된다.
     *
     * 'choice' 필드가 Y 이면 찬성/좋아요, N 이면 반대/싫어요, 빈 문자열('')이면 취소이다.
     *
     * @param string $Yn - Y 또는 N 값으로 입력된다.
     *
     * @return $this
     * - 성공이면, 현재 객체
     * - 실패이면 에러를 담은 현재 객체
     *
     * @example
     *  $re = api_vote(['post_ID' => 1, 'choice' => 'Y']);
     */
    public function vote(string $Yn): self {
        if ( $this->exists() == false ) return $this->error(e()->post_not_exists);
        if ( !$Yn ) return $this->error(e()->empty_vote_choice);// ERROR_EMPTY_CHOICE;
        if ( $Yn != 'Y'  && $Yn != 'N' ) return $this->error(e()->empty_wrong_choice);// ERROR_WRONG_INPUT;

        $vote = voteHistory()->by(login()->idx, POSTS, $this->idx);
        // Already voted? 추천을 이미 했는가?
        if ( $vote->exists() ) {
            if ( $vote->choice == $Yn ) {
                // 동일한 추천을 이미 했음. 포인트 변화 없이, 추천을 없애준다.
                $vote->update([CHOICE => '']);
            }
            else {
                // 이전에 한 추천과 다른 추천을 했음. 포인트 변화 없이, 추천만 반대로 바꾼다.
                $vote->update([CHOICE => $Yn]);
            }
        } else {
//            act()->can(Activity::$vote, postIdx: $this->idx);
            // Do actions for first vote. 처음 추천
            // Change point for first vote only. 처음 추천하는 경우에만 포인트 지정.
            // Leave vote history. 추천 기록 남김. 포인트 증/감 유무와 상관 없음.
            voteHistory()->create([
                USER_IDX => login()->idx,
                TAXONOMY => POSTS,
                ENTITY => $this->idx,
                CHOICE => $Yn
            ]);
//            d("$Yn");
//            point()->vote($this, $Yn);

//            d($this);
            act()->vote($this, $Yn);
        }

        // 해당 글 또는 코멘트의 총 vote 수를 업데이트 한다.
        $Y = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'Y']);
        $N = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'N']);

        return $this->update(['Y' => $Y, 'N' => $N]);

//        $record = entity(POSTS, $this->idx)->update($data);
//        return $record;
    }

    public function like(): self {
        return $this->vote('Y');
    }
    public function dislike(): self {
        return $this->vote('N');
    }




    /**
     * 카테고리 아이디를 리턴한다.
     *
     * $this->category()->id 를 하면, 카테고리 전체 레코드를 다 읽지만, postCategoryId() 는 categoryId 필드 하나만 읽는다.
     *
     * @return string
     */
    public function categoryId(): string {
        return postCategoryId($this->categoryIdx);
    }


    /**
     * 현재 글/코멘트에 연결된 첨부 파일들을 레코드 배열 또는 객체를 배열로 리턴한다.
     *
     * ```
     * foreach( $post->files() as $file ) { ... }
     * ```
     *
     *
     * @param bool $response
     *  이 값이 참이면 file 레코드를 배열로 리턴한다.
     * @return FileTaxonomy[]
     */
    public function files(bool $response = false): array {
	if ( $this->idx == 0 ) return [];
        /**
         *
         * taxonomy 와 entity 를 기반으로 첨부 파일을 가져오는데, 사진을 업로드한 순서대로 가져온다.
         */
        $files = files()->find([TAXONOMY => POSTS, ENTITY => $this->idx], by: 'ASC');
        if ( $response ) {
            $rets = [];
            foreach( $files as $file ) {
                $rets[] = $file->response();
            }
            return $rets;
        } else {
            return $files;
        }

    }


    /**
     * 글/코멘트를 쓴 사용자 객체를 리턴한다.
     *
     * 참고로 현재 글/코멘트 객체가 올바른지는 이 함수 호출 전에 검사를 해야 한다.
     *
     * @return UserTaxonomy
     */
    public function user(): UserTaxonomy {
        return user($this->userIdx);
    }

    /**
     * 현재 글/코멘트의 카테고리를 객체로 리턴한다.
     *
     * @return CategoryTaxonomy
     */
    public function category(): CategoryTaxonomy {
        return category($this->categoryIdx);
    }


    /**
     * 글/코멘트 쓰기/수정 등에서 첨부 파일이 업로드된 경우, 그 첨부 파일의 taxonomy 와 entity 를 현재 글/코멘트의 것으로 수정한다.
     *
     * @param $in
     */
    public function fixUploadedFiles($in) {

        /// 업로드된 첨부 파일의 taxonomy 와 entity 를 지정한다.
        if ( isset($in[FILES]) && $in[FILES] ) {
            $files = separateByComma($in[FILES]);
            foreach( $files as $file ) {
                files($file)->update([TAXONOMY => POSTS, ENTITY => $this->idx]);
            }
        }

    }

}


/**
 *
 * @param int $idx
 * @return Forum
 */
function Forum(int $idx=0): Forum
{
    return new Forum($idx);
}



