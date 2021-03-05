<?php


/**
 * @file app.route.php
 */

/**
 * Class AppRoute
 */
class AppRoute
{

    /**
     * Returns API version to client end.
     * @return array
     */
    public function version()
    {
        return ['version' => '0.0.1'];
    }


    public function settings()
    {
        return ['a' => 'apple'];
        // return ['search_categories' => search_categories()];
    }
}
