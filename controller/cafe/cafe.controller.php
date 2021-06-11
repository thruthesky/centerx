<?php
/**
 * @file cafe.controller.php
 */

/**
 * Class CafeController
 */

class CafeController {

    public function settings($in): array {
        $cafe = cafe();
        return [
            'mainDomains' => $cafe->mainDomains,
            'countryDomains' => $cafe->countryDomains,
            'rootDomainSettings' => $cafe->rootDomainSettings,
            'mainMenus' => $cafe->mainMenus,
            'sitemap' => $cafe->sitemap,
        ];
    }

    public function create($in): array|string {
        return cafe()->create($in)->response();
    }

    public function get($in): array|string {
        if ( cafe()->isMainCafe($in[DOMAIN]) ) {
            return e()->main_cafe_has_no_cafe_category_record;
        }
        $res = cafe(domain: $in[DOMAIN])->response();
        if ( $res == e()->entity_not_found ) return e()->cafe_not_exists;
        return $res;
    }

    public function mine($in): array|string {
        return cafe()->mine()->response('idx, id, domain');
    }
}