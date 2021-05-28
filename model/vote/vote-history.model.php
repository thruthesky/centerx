<?php
/**
 * @file vote-history.model.php
 */
/**
 * Class VoteHistoryModel
 *
 * 추천은 글, 코멘트, 쇼핑몰 상품 등 posts 테이블의 글 뿐만아니라, 사용자, 첨부 파일 등에도 할 수 있도록 taxonomy 가 존재한다.
 *
 *
 * @property-read string $choice
 */
class VoteHistoryModel extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(POST_VOTE_HISTORIES, $idx);
    }


    /**
     * 특정 레코드를 찾아, 현재 객체로 변경한다.
     *
     * @param $userIdx
     * @param $taxonomy
     * @param $entity
     * @return self
     */
    public function by($userIdx, $taxonomy, $entity): self {
        $idx = db()->column("SELECT idx FROM " . $this->getTable() . " WHERE userIdx=? AND taxonomy=? AND entity=?", $userIdx,$taxonomy,$entity);
        if ( $idx ) return voteHistory($idx);
        else return voteHistory(0);
    }

}


/**
 * Returns VoteHistory instance.
 *
 *
 * @param int $idx - The `point_histories.idx`.
 * @return VoteHistoryModel
 */
function voteHistory(int $idx=0): VoteHistoryModel
{
    return new VoteHistoryModel($idx);
}


