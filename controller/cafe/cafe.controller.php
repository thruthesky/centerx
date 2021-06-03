<?php
/**
 * @file cafe.controller.php
 */

/**
 * Class CafeController
 */

class CafeController {

    public function create($in): array|string {
        return cafe()->create($in)->response();
    }
}