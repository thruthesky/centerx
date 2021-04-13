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
class Friend extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(FRIENDS, $idx);
    }

    /**
     * 누군가 나를 친구 추가하면, 하나의 레코드만 생성된다.
     * 그리고 내가 친구 추가를 하지 않았으면, 상대방이 나를 친추해도, 내 목록에는 나타나지 않는다.
     * 예) A 가 B 를 친추 했다면, A 친구 목록에는 B 가 나오지만, B 친구 목록에는 A 가 나오지 않는다.
     *      B 도 A 를 친추해야지만, B 친구 목록에 나온다.
     *
     * @param $in
     * @return $this|Entity|Friend
     */
    public function add($in) {
        if ( $in['otherIdx'] == login()->idx ) return $this->error(e()->cannot_add_oneself_as_friend);
        if ( user()->exists(['idx' => $in['otherIdx']]) == false ) return $this->error(e()->user_not_found_by_that_idx);
        if ( friend()->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists ) return $this->error(e()->already_added_as_friend);

        parent::create(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);


        return $this;
    }

    /**
     *
     * @param array $in
     * @return Entity
     */
    public function delete($in=[]): Entity
    {
        if ( $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists == false ) return $this->error(e()->not_added_as_friend);
        return parent::delete();
    }

    /**
     * 블럭을 한다.
     * @param array $in
     * @return Entity|Friend
     */
    public function block(array $in) {
        // 레코드를 찾는다. 내가 해당 친구($in['otherIdx'])를 추가한 레코드
        $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);

        // 레코드가 존재하는가?
        if ( $this->exists ) {
            if ( $this->block ) return $this->error(e()->already_blocked); // 이미 블럭되어 있으면 에러.
        } else {
            // 내가, 친구 초대를 안 했다. (상대방은 나를 친구 초대 했을 수 있음)
            // 그냥 통과.
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
     * 내가 친추를 했거나, 내가 친추가 되었으면, 그 레코드를 리턴한다.
     * @param array $in
     * @return Entity|Friend
     */
    public function relationship(array $in) {
        $ab = friend()->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']]);
        if ( $ab->exists ) return $ab;
        $ba = friend()->findOne(['myIdx' => $in['otherIdx'], 'otherIdx' => login()->idx]);
        if ( $ba->exists ) return $ba;
        return $this->error(e()->no_relationship);
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
        $rows = db()->get_results("SELECT * FROM " . $this->getTable() . " WHERE reason <> ''", ARRAY_A);
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
 * @return Friend
 */
function friend(int $idx=0): Friend {
    return new Friend($idx);
}
