<?php
/**
 * @file friend.class.php
 */
/**
 * Class Friend
 *
 * @property-read int myIdx
 * @property-read int otherIdx
 * @property-read string block
 */
class FriendTaxonomy extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(FRIENDS, $idx);
    }

    /**
     * 친구 추가
     *
     * 누군가 나를 친구 추가하면, 하나의 레코드만 생성된다.
     * 그리고 내가 친구 추가를 하지 않았으면, 상대방이 나를 친추해도, 내 목록에는 나타나지 않는다.
     * 예) A 가 B 를 친추 했다면, A 친구 목록에는 B 가 나오지만, B 친구 목록에는 A 가 나오지 않는다.
     *      B 도 A 를 친추해야지만, B 친구 목록에 나온다.
     *
     * @param $in
     * @return self
     */
    public function add($in) : self {
        if ( $in['otherIdx'] == login()->idx ) return $this->error(e()->cannot_add_oneself_as_friend);
        if ( user()->exists(['idx' => $in['otherIdx']]) == false ) return $this->error(e()->user_not_found_by_that_idx);
        if ( friend()->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists ) return $this->error(e()->already_added_as_friend);

        parent::create(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);


        return $this;
    }

    /**
     *
     * @param array $in
     * @return self
     */
    public function delete($in=[]): self
    {
        if ( $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists == false ) return $this->error(e()->not_added_as_friend);
        return parent::delete();
    }

    /**
     * 사용자 블럭을 한다.
     * @param array $in
     * @return self
     */
    public function block(array $in) {
        $otherUser = user($in['otherIdx']);
        if ( $otherUser->hasError ) return $this->error( $otherUser->getError() );

        // 레코드를 찾는다. 내가 해당 친구($in['otherIdx'])를 추가한 레코드
        $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);

        // 레코드가 존재하는가?
        if ( $this->exists ) {
            // 이미 블럭되어 있으면 에러.
            if ( $this->block ) {
                return $this->error(e()->already_blocked);
            }
        } else {
            $this->resetError();
            // 내가, 친구 초대를 안 했다. (상대방은 나를 친구 초대 했을 수 있음)
            // 그렇다면, 친구 추가를 하고, 블럭을 한다. 이론적으로, 친구 추가된 레코드에 block=Y 를 해야하므로, 친구 추가는 필수이다.
            $this->add(['otherIdx' => $in['otherIdx']]);
        }



        // 블럭을 한다. 내가 친구 추가를 안 했어도, 블럭을 할 수 있다. 즉, 친구 추가하지 않고, 미리 블럭을 하는 것이다.
        return parent::update(['block' => 'Y', 'reason' => $in['reason'] ?? '']);

    }


    public function unblock(array $in) {
        if ( $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists == false ) return $this->error(e()->not_added_as_friend);
        if ( !$this->block ) return $this->error(e()->not_blocked);
        return parent::update(['block' => '']);
    }

    /**
     * 친구 관계
     *
     * 일방 친구와 쌍방 친구가 있을 수 있으며,
     * 일방 친구 차단과 쌍방 친구 차단이 있을 수 있다.
     *
     * 내가 친추를 했거나, 내가 친추가 되었으면, 그 레코드를 리턴한다. 즉, 일방 친구 상태이면, 일반 친구 상태를 쌍방 모두에게 알림.
     * 예) A 가 B 를 친구 추가한 경우, B 에게 그 사실을 알림.
     * 예) A 와 B 쌍방 친구인 경우, 각자의 레코드를 리턴.
     *
     * 차단의 경우, 일방 차단이라고 해도, 쌍방 모두 대화를 할 수 없도록 한다.
     *
     * @param array $in
     * @return self
     */
    public function relationship(array $in): FriendTaxonomy
    {


        // 내가 친추를 했다면, 그 레코드 리턴.
        $aB = friend()->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);
//        if ( $aB->exists ) return $aB;

        // 상대방이 나를 친추 했다면, 그 레코드를 리턴.
        $bA = friend()->findOne(['myIdx' => $in['otherIdx'], 'otherIdx' => login()->idx]);
//        if ( $bA->exists ) return $bA;

        // 쌍방 친구인 경우,
        if ( $aB->exists && $bA->exists ) {
            // 둘 중 하나가 블럭인가?
            if ( $aB->block == 'Y' || $bA->block == 'Y' ) {
                // 그렇다면, 나의 레코드에 block 상태를 표시해서 리턴.
                $aB->updateData('block', 'Y');
                return $aB;
            } else {
                // 둘 다 블럭이 아니면, 나의 레코드를 리턴.
                return $aB;
            }
        } else if ( $aB->exists ) {
            // 내가 친추한 경우,
            return $aB;
        } else if ( $bA->exists ) {
            // (나는 친추를 안했는데,) 상대방이 나를 친추한 경우,
            return $bA;
        } else {
            // 친추 상태가 아닌 경우,
            return $this->error(e()->no_relationship);
        }
    }

    /**
     * 내가 친구 추가한 목록
     * @return array
     */
    public function list() {
        $friends = $this->search(select: 'otherIdx', limit: 5000, conds: ['myIdx' => login()->idx, 'block' => '']);
        $rets = [];
        foreach($friends as $f) {
            $rets[] = user($f['otherIdx'])->shortProfile(firebaseUid: true);
        }
        return $rets;
    }


    public function blockList() {
        $friends = $this->search(select: 'otherIdx', limit: 5000, conds: ['myIdx' => login()->idx, 'block' => 'Y']);
        $rets = [];
        foreach($friends as $f) {
            $rets[] = user($f['otherIdx'])->shortProfile(firebaseUid: true);
        }
        return $rets;
    }

    /**
     * 관리자만 필요한 기능으로 관리자만 볼 수 있도록 하는 기능이 필요하다. 그리고 1천개만 목록하는데, 페이지네이션을 할 필요가 있다.
     * @return array
     */
    public function reportList() {
//        $friends = $this->search(select: '*', limit: 1000, conds: ['reason' => '']);
//        $rows = db()->get_results("SELECT * FROM " . $this->getTable() . " WHERE reason <> ''", ARRAY_A);

        $rows = db()->rows("SELECT * FROM " . $this->getTable() . " WHERE reason <> ? ", '');
        $rets = [];
        foreach($rows as $row) {
            $rets[] = [
                'user' => user($row['myIdx'])->shortProfile(), // 블럭한 사용자
                'blockedUser' => user($row['otherIdx'])->shortProfile(firebaseUid: true), // 블럭 당한 사용자
            ];
        }
        return $rets;
    }
}



/**
 * @param int $idx
 * @return FriendTaxonomy
 */
function friend(int $idx=0): FriendTaxonomy {
    return new FriendTaxonomy($idx);
}
