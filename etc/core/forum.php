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
 * @property-read int otherUserIdx
 * @property-read int appliedPoint;
 * @property-read string files
 * @property-read string fileIdxes
 * @property-read int report;
 * @property-read string code;
 */
class Forum extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(POSTS, $idx);
    }


    /**
     * The points earned by creating post/comment will be patched as 'appliedPoint'.
     *
     * Acquired points are recorded only in point_histories, and the value is read and applied to the current $this->data memory variable.
     * This function can be used with the post/comment read() function and immediately after the point update in the post/comment.
     *
     * For reference, use similar code in PointRoute::postCreate().
     *
     * @todo When writing a post/comment, consider putting the user_activity.idx into the posts record for performance.
     *
     * @note It only patch the point for creation. Not for delete.
     */
    public function patchPoint() {
        if ( $this->parentIdx ) $action =  Actions::$createComment;
        else $action = Actions::$createPost;

        $point = userActivity()->last(POSTS, $this->idx, $action)?->toUserPointApply ?? 0;
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

        // Get vote history to check if the user did the vote for the post/comment.
        $vote = voteHistory()->by(login()->idx, POSTS, $this->idx);
        // Already voted? 추천을 이미 했는가?
        if ( $vote->exists() ) {
            // Yes, vote was made before.
            if ( $vote->choice == $Yn ) {
                // 동일한 추천을 이미 했음. 포인트 변화 없이, 추천을 없애준다.
                $vote->update([CHOICE => '']);
            }
            else {
                // 이전에 한 추천과 다른 추천을 했음. 포인트 변화 없이, 추천만 반대로 바꾼다.
                $vote->update([CHOICE => $Yn]);
            }
        } else {
//            userActivity()->can(Activity::$vote, postIdx: $this->idx);
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
            userActivity()->vote($this, $Yn);
        }

        // Update number of votes for the post/comment.
        // 해당 글 또는 코멘트의 총 vote 수를 업데이트 한다.
        $Y = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'Y']);
        $N = voteHistory()->count(conds: [TAXONOMY => POSTS, ENTITY => $this->idx, CHOICE => 'N']);

        /**
         * 권한 문제
         *
         * $this->update() 에서는 자기 글 만 수정 가능.
         * 그래서 부모의 entity() 객체를 통해서 (post/comment model update 를 통하지 않고) 업데이트한다.
         */
        return parent::update(['Y' => $Y, 'N' => $N]);

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
     * 주의, 문서화:
     *  wc_posts.files 에는 파일 번호가 콤마로 분리되어 저장되는데, 여기서 리턴하는 값은 wc_posts.files 와 상관없이,
     *  taxonomy = 'posts', entity = post.idx 조건이 맞으면, 해당 파일을 리턴한다. 그리고 화면에 표시 할 때, 실제 파일이 없는데, DB 레코드만
     *  존재하는 경우, 이미지가 표시되지 않는 에러가 발생할 수 있다.
     *  에러 재 생성: 글에 사진을 업로드하고, HDD 에서 사진을 삭제하면, 위와 같은 현상이 나타날 수 있는다.
     *  이 같은 경우, post-edit-form-file.js 에서 처리를 한다.
     *
     * ```
     * foreach( $post->files() as $file ) { ... }
     * ```
     *
     *
     * @param bool $response
     *  이 값이 참이면 file 레코드를 배열로 리턴한다.
     * @return FileModel[]
     */
    public function files(bool $response = false): array {
        if ( $this->idx == 0 ) return [];
        // taxonomy 와 entity 를 기반으로 첨부 파일을 가져오는데, 사진을 업로드한 순서대로 가져온다.
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
     * 현재 파일에 첨부된 파일 중 $code 와 일치하는 것을 리턴한다.
     *
     * @param string $code
     * @return FileModel
     */
    public function fileByCode(string $code): FileModel {
        return files()->getBy($this->taxonomy, $this->idx, $code);
    }



    /**
     * 글/코멘트를 쓴 사용자 객체를 리턴한다.
     *
     * 참고로 현재 글/코멘트 객체가 올바른지는 이 함수 호출 전에 검사를 해야 한다.
     *
     * @return UserModel
     */
    public function user(): UserModel {
        return user($this->userIdx);
    }

    /**
     * 현재 글/코멘트의 카테고리를 객체로 리턴한다.
     *
     * @return CategoryModel
     */
    public function category(): CategoryModel {
        return category($this->categoryIdx);
    }


    /**
     * 글/코멘트 쓰기/수정 등에서 첨부 파일이 업로드된 경우, 그 첨부 파일의 taxonomy 와 entity 를 현재 글/코멘트의 것으로 수정한다.
     *
     * @param $in
     */
    public function fixUploadedFiles($in) {

        /// 업로드된 첨부 파일의 taxonomy 와 entity 를 지정한다.
        if ( isset($in[FILE_IDXES]) && $in[FILE_IDXES] ) {
            $files = separateByComma($in[FILE_IDXES]);
            foreach( $files as $file ) {
                files($file)->update([TAXONOMY => POSTS, ENTITY => $this->idx]);
            }
        }

    }


    /**
     * Return true if `otherUserIdx` is set to the login user.
     *
     * @note this is used only for posts taxonomy.
     * @return bool
     */
    public function sentToMe(): bool {
        if ( notLoggedIn() ) return false;
        if ( ! $this->idx ) return false;
        if ( ! $this->otherUserIdx ) return false;
        return $this->otherUserIdx == login()->idx;
    }


    /**
     * 입력된 시작날짜와 끝날짜를 timestamp 로 변환해서 리턴한다.
     * If `beginAt` and `endAt` are string, then Convert it into timestamp.
     * If `beginAt` and `endAt` are empty and `beginDate` and `endDate` are not,
     *  then convert `beginDate` and `endDate` into timestamp and save it in `beginAt`, `endAt`.
     *  then, unset `beginDate` and `endDate`.
     *
     *
     * @param $in
     *
     * @example
     * ```
     * $in = post()->updateBeginEndDate($in);
     * ```
     *
     * @todo do test on it
     */
    public function updateBeginEndDate($in): array {

        if ( isset($in[BEGIN_AT]) && $in[BEGIN_AT] ) {
            $in[BEGIN_AT] = dateToTime($in[BEGIN_AT] ?? '');
        } else if ( isset($in['beginDate']) && $in['beginDate'] ) {
            $in[BEGIN_AT] = dateToTime($in['beginDate']);
            unset($in['beginDate']);
        } else {
            $in[BEGIN_AT] = 0;
        }

        if ( isset($in[END_AT]) && $in[END_AT] ) {
            $in[END_AT] = dateToTime($in[END_AT] ?? '');
        } else if ( isset($in['endDate']) && $in['endDate'] ) {
            $in[END_AT] = dateToTime($in['endDate']);
            unset($in['endDate']);
        } else {
            $in[END_AT] = 0;
        }


        return $in;

    }


    /**
     * 글/코멘트 또는 어떤 형식의 posts entity 이든 신고를 한다.
     *
     * post()->update() 를 통해서 하면, 사용자 인증에 걸리므로, 별도의 함수를 만들었다.
     * @return $this
     */
    public function report(): self {
        userActivity()->report($this);
        return parent::update(['report' => $this->report + 1]);
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



