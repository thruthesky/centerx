<?php

/**
 * Class PointHistory
 *
 * @property-read int $fromUserIdx
 * @property-read int $toUserIdx
 * @property-read string $reason
 * @property-read string $taxonomy
 * @property-read int $entity
 * @property-read int categoryIdx
 * @property-read int fromUserPointApply
 * @property-read int fromUserPointAfter
 * @property-read int toUserPointApply
 * @property-read int toUserPointAfter
 * @property-read int createdAt
 * @property-read int updatedAt
 */
class PointHistory extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POINT_HISTORIES, $idx);
    }


    /**
     * point history 테이블에서 taxonomy, entity, reason 에 맞는 마지막 기록 1개를 리턴한다.
     *
     * - 예제) 마지막 기록을 가져와서, 포인트 기록이 된 시간을 24시간 이전으로 수정한다.
     * ```php
     * $ph = pointHistory()->last(POSTS, $post1->idx, POINT_POST_CREATE);
     * $ph->update([CREATED_AT => $ph->createdAt - (60 * 60 * 24)]);
     * ```
     *
     * @param $taxonomy
     * @param $entity
     * @param string $reason
     * @return PointHistory
     */
    public function last($taxonomy, $entity, $reason=''): PointHistory {
        $q = '';
        if ( $reason ) $q = "reason='$reason' AND ";
        $where = $q . TAXONOMY . "='$taxonomy' AND entity=$entity";
        $histories = $this->search(where: $where, limit: 1);
        if ( count($histories) ) return pointHistory($histories[0]->idx);
        return pointHistory();
    }


    /**
     * 검색 후, 결과를 객체로 리턴한다. (부모 결과는 기본적으로 배열로 리턴)
     *
     * @param string $select
     * @param string $where
     * @param string $order
     * @param string $by
     * @param int $page
     * @param int $limit
     * @param array $conds
     * @param string $conj
     * @return PointHistory[]
     */
    public function search(
        string $select='idx',
        string $where='1',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        array $conds=[],
        string $conj = 'AND',
        bool $object = true,
    ): array
    {
        return parent::search(
            select: $select,
            where: $where,
            order: $order,
            by: $by,
            page: $page,
            limit: $limit,
            conds: $conds,
            conj: $conj,
            object: $object,
        );
    }



}




/**
 * Returns PointHistory instance.
 *
 *
 * @param int $idx - The `point_histories.idx`.
 * @return PointHistory
 */
function pointHistory(int $idx=0): PointHistory
{
    return new PointHistory($idx);
}




