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


}
