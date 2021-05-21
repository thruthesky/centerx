<?php


class MessageTaxonomy extends PostTaxonomy
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }

    public function countInbox() {

        $conds = [
            CATEGORY_IDX => category(MESSAGE_CATEGORY)->idx,
            OTHER_USER_IDX => login()->idx,
            DELETED_AT => 0,
        ];

        return $this->count(conds: $conds);
    }
    public function countNewMessage() {

        $conds = [
            CATEGORY_IDX => category(MESSAGE_CATEGORY)->idx,
            OTHER_USER_IDX => login()->idx,
            READ_AT => 0,
            DELETED_AT => 0,
        ];

        return $this->count(conds: $conds);
    }
}



/**
 * @param int $idx - 카테고리 번호 또는 문자열.
 * @return MessageTaxonomy
 *
 */
function message(int $idx = 0): MessageTaxonomy
{
    return new MessageTaxonomy($idx);
}
