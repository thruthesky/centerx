<?php
/**
 * @file in-app-purchase.class.php
 */
/**
 * Class InAppPurchase
 *
 *
 */
class InAppPurchase extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(IN_APP_PURCHASE, $idx);
    }

    /**
     * @param int $idx
     * @return InAppPurchase
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        return $this;
    }


    /**
     * @param array $in
     * @return InAppPurchase
     */
    public function create( array $in ): self {

        $in[USER_IDX] = login()->idx;

        return parent::create($in);
    }




    /**
     * @attention To update, entity.idx must be set properly.
     *
     * @param array $in
     * @return InAppPurchase
     */
    public function update(array $in): self {
        return parent::update($in);
    }

    /**
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        else return $this->getData();
    }

}


/**
 * @param int $idx
 * @return InAppPurchase
 *
 *
 */
function inAppPurchase(int $idx = 0): InAppPurchase
{
    return new inAppPurchase($idx);
}
