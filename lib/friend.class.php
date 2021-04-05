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

    public function block(array $in) {
        if ( $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists == false ) return $this->error(e()->not_added_as_friend);
        if ( $this->block ) return $this->error(e()->already_blocked);
        return parent::update(['block' => 'Y', 'reason' => $in['reason'] ?? '']);
    }


    public function unblock(array $in) {
        if ( $this->findOne(['myIdx' => login()->idx, 'otherIdx' => $in['otherIdx']])->exists == false ) return $this->error(e()->not_added_as_friend);
        if ( !$this->block ) return $this->error(e()->not_blocked);
        return parent::update(['block' => '']);
    }

    public function list() {
        $friends = $this->search(select: 'otherIdx', limit: 5000, conds: ['myIdx' => login()->idx, 'block' => '']);
        $rets = [];
        foreach($friends as $f) {
            $rets[] = user($f['otherIdx'])->shortProfile();
        }
        return $rets;
    }

    public function blockList() {
        $friends = $this->search(select: 'otherIdx', limit: 5000, conds: ['myIdx' => login()->idx, 'block' => 'Y']);
        $rets = [];
        foreach($friends as $f) {
            $rets[] = user($f['otherIdx'])->shortProfile();
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
