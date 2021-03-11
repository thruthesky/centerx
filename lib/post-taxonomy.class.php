<?php

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
     * @param $in
     *
     * @return array|mixed|string
     *
     * - 성공이면, 글 또는 코멘트를 리턴한다.
     *
     * @example
     *  $re = api_vote(['post_ID' => 1, 'choice' => 'Y']);
     */
    function vote($Yn): array|string {
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( !$Yn ) return e()->empty_vote_choice;// ERROR_EMPTY_CHOICE;
        if ( $Yn != 'Y'  && $Yn != 'N' ) return e()->empty_wrong_choice;// ERROR_WRONG_INPUT;

        $vote = voteHistory()->by(my(IDX), POSTS, $this->idx);

        if ( $vote->exists() ) {
            // 이미 한번 추천 했음. 포인트 변화 없이, 추천만 바꾸어 준다.
            if ( $vote->value(CHOICE) == $Yn ) $vote->update([CHOICE=>'']);
            else $vote->update([CHOICE=>$Yn]);
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
        $Y = voteHistory()->count(TAXONOMY . "='" . POSTS. "' AND " . ENTITY . "=" . $this->idx . " AND " . CHOICE . "='Y'");
        $N = voteHistory()->count(TAXONOMY . "='" . POSTS. "' AND " . ENTITY . "=" . $this->idx . " AND " . CHOICE . "='N'");

        $data = ['Y' => $Y, 'N' => $N];
        $record = entity(POSTS, $this->idx)->update($data);

        /// Added by ace
        if ( isset($record[FILES]) ) {
            $record[FILES] = files()->get($record[FILES], select: 'idx,userIdx,path,name,size');
        }

        return $record;
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



