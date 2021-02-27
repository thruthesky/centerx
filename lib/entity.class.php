<?php

class Entity {


    public function __construct(public string $taxonomy)
    {
    }

    public function   getTable(): string {
        return DB_PREFIX . $this->taxonomy;
    }

    /**
     *
     * @param array $record
     *
     *
     *
     * @return int|false - 성공이면, 마지막으로 입력된 idx 를 리턴한다.
     *      - 성공이면, 마지막으로 입력된 idx 를 리턴한다.
     *      - 실패하면 false 가 리턴된다.
     *
     * @note user is_success() to check if it was success()
     *
     * @see readme for detail.
     */
    public function create( array $record ): int|false {
        $record['createdAt'] = time();
        $record['updatedAt'] = time();
        return db()->insert( $this->getTable(), $record );
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    public function get(string $field, mixed $value): mixed {
        $q = "SELECT * FROM {$this->getTable()} WHERE `$field`='$value'";
//        d($q);
        return db()->get_row($q, ARRAY_A);
    }



}


/**
 * Entity 는 taxonomy 가 입력되므로, 항상 객체를 생성해서 리턴한다.
 * @param string $taxonomy
 * @return Entity
 */
function entity(string $taxonomy): Entity
{
    return new Entity($taxonomy);
}
