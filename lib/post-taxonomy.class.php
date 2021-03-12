<?php
/**
 * @file post-taxonomy.class.php
 */

/**
 * Class PostTaxonomy
 *
 * 글과 관련된 작업을 하는 Taxonomy.
 * 글이라면 단순히 게시글 뿐만아니라, 코멘트, 블로그 글, 쇼핑몰 상품 글 등 posts 테이블에 저장되는 모든 것을 말한다.
 * 각 글 타입마다 클래스가 따로 있을 수 있는데(예: Post, Comment), 그런 경우 이 클래스를 상속해야 한다. 이 클래스에는 추천과 같은 범용적인 코드를 가지고
 * 있다.
 *
 *
 */
class PostTaxonomy extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POSTS, $idx);
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
    function vote($Yn): self {
        if ( $this->exists() == false ) return $this->error(e()->post_not_exists);
        if ( !$Yn ) return $this->error(e()->empty_vote_choice);// ERROR_EMPTY_CHOICE;
        if ( $Yn != 'Y'  && $Yn != 'N' ) return $this->error(e()->empty_wrong_choice);// ERROR_WRONG_INPUT;

        $vote = voteHistory()->by(login()->idx, POSTS, $this->idx);

        // 추천을 이미 했는가?
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
            // 처음 추천
            // 처음 추천하는 경우에만 포인트 지정.
            // 추천 기록 남김. 포인트 증/감 유무와 상관 없음.
            voteHistory()->create([
                USER_IDX => login()->idx,
                TAXONOMY => POSTS,
                ENTITY => $this->idx,
                CHOICE => $Yn
            ]);
//            d("$Yn");

            point()->vote($this, $Yn);
        }


        // 해당 글 또는 코멘트의 총 vote 수를 업데이트 한다.
        $Y = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'Y']);
        $N = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'N']);

        return $this->update(['Y' => $Y, 'N' => $N]);

//        $record = entity(POSTS, $this->idx)->update($data);
//        return $record;
    }


}


/**
 *
 * @param int $idx
 * @return PostTaxonomy
 */
function postTaxonomy(int $idx=0): PostTaxonomy
{
    return new PostTaxonomy($idx);
}



