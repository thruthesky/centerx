<?php

class UtilityController
{

    public function createSamplePosts() {
        if ( admin() == false ) return e()->you_are_not_admin;
        _post_create();
        return ['success' => true];
    }
}
