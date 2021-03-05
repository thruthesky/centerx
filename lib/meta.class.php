<?php

class Meta extends Entity {

    /**
     * Meta constructor.
     */
    public function __construct()
    {
        parent::__construct(METAS, 0);
    }

    /**
     * You cannot create a meta record by calling `create()`. Use other method.
     * @deprecated Not supported
     * @param array $in
     * @return array|string
     */
    public function create(array $in): array|string
    {
        return [];
    }

    /**
     * You cannot create a meta record by calling `update()`. Use other method.
     * @deprecated Not supported
     * @param array $in
     * @return array|string
     */
    public function update(array $in): array|string
    {
        return [];
    }

    /**
     * You cannot create a meta record by calling `delete()`. Use other method.
     * @deprecated Not supported
     */
    public function delete()
    {
    }
}


/**
 * @return Meta
 */
function meta(): Meta {
    return new Meta();
}