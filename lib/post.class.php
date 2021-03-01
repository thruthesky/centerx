<?php


class Post extends Entity {
    public function __construct(int $idx)
    {
        parent::__construct(POSTS, $idx);
    }

    /**
     * @param array $in
     * @return array|string
     */
    public function create( array $in ): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( !isset($in[CATEGORY]) ) return e()->category_is_empty;
        $category = category($in[CATEGORY]);
        if ( $category->exists() == false ) return e()->category_not_exists;
        unset($in[CATEGORY]);

        //
        $in[CATEGORY_IDX] = $category->idx;

        //
        $in[USER_IDX] = my(IDX);


        // @todo check if user has permission
        // @todo check if too many post creation.
        // @todo check if too many comment creation.

        return parent::create($in);

        // update `noOfPosts`
        // update `noOfComments`

        // @todo push notification

    }

    /**
     * @attention The entity.idx must be set. That means, it can only be called with `post(123)->update()`.
     *
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_post;


        //
        return parent::update($in);
    }

    public function markDelete(): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! $this->idx ) return e()->idx_is_empty;
        if ( $this->exists() == false ) return e()->post_not_exists;
        if ( $this->isMine() == false ) return e()->not_your_post;


        $record = parent::markDelete();
        if ( isError($record) ) return $record;
        $this->update([TITLE => '', CONTENT => '']);
        return $this->get();
    }

    /**
     * Returns posts after search and add meta datas.
     *
     * @attention Categories can be passed like  "categoryId=<apple> or categoryId='<banana>'" and it wil be converted
     * as "categoryIdx=1 or categoryIdx='2'"
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @return mixed
     * @throws Exception
     */
    public function search(string $where='1', int $page=1, int $limit=10, string $order='idx', string $by='DESC', $select='idx'): mixed {


        // Parse category
        $count = preg_match_all("/<([^>]+)>/", $where, $ms);
        if ( $count ) {
            for( $i = 0; $i < $count; $i ++ ) {
                $cat = $ms[1][$i];
                $idx = category($cat)->idx;
                $where = str_replace($ms[0][$i], $idx, $where);
            }
        }
        $where = str_replace('categoryId', CATEGORY_IDX, $where);

        $posts = parent::search(
            where: $where,
            page: $page,
            limit: $limit,
            order: $order,
            by: $by,
            select: '*',
        );

        // @todo add user(author) information
        // @todo add attached files if exists.

        return $posts;
    }
}





/**
 * User 는 uid 를 입력 받으므로 항상 새로 생성해서 리턴한다.
 *
 * $_COOKIE[SESSION_ID] 에 값이 있으면, 사용자가 로그인을 확인을 해서, 로그인이 맞으면 해당 사용자의 idx 를 기본 사용한다.
 * @param int $idx
 * @return Post
 */
function post(int $idx=0): Post
{
    return new Post($idx);
}



