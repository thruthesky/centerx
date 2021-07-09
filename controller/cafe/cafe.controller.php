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
            'mainCafeDomains' => $cafe->mainCafeDomains,
            'countryDomains' => $cafe->countryDomains,
            'mainCafeSettings' => $cafe->mainCafeSettings,
            'mainMenus' => $cafe->mainMenus,
            'sitemap' => $cafe->sitemap,
        ];
    }

    public function create($in): array|string {
        return cafe()->create($in)->response();
    }

    public function update($in): array|string
    {
        if ( cafe()->mine() == false ) return e()->this_is_not_your_cafe;
        return category($in[IDX] ?? $in[ID])->update($in)->response();
    }

    public function get($in): array|string {
	    if ( ! isset( $in[ DOMAIN ] ) ) return e()->empty_domain;
        if ( cafe()->isMainCafe($in[DOMAIN]) ) {
            return e()->main_cafe_has_no_cafe_category_record;
        }
        $res = cafe(domain: $in[DOMAIN])->response();
        if ( $res == e()->entity_not_found ) return e()->cafe_not_exists;

        $res['tokenCount'] = cafe(domain: $in[DOMAIN])->count();
        $res['titleImageUrl'] = cafe(domain: $in[DOMAIN])->titleImage()->url;
        return $res;
    }

    public function mine($in): array|string {
        $arr = cafe()->mine();
        $rets = [];
        foreach( $arr as $c ) {
            $rets[] = $c->response('idx, id, title, domain');
        }
        return $rets;
    }

    /*
     * send push notification via topic using domain as topic
     */
    public function sendMessage($in): array|string {
        if ( !isset($in[DOMAIN]) || empty( $in[DOMAIN]) ) return e()->empty_domain;
        $cafe = cafe(domain: $in[DOMAIN]);
        if ( $cafe->hasError ) return $cafe->getError();
        if ( $cafe->mine() == false ) return e()->this_is_not_your_cafe;
        if ( $cafe->appIcon()->ok ) $in[IMAGE_URL] = $cafe->appIcon()->url;
        if ( isset($in[IDX]) && !empty($in[IDX])) {
            $post = post($in[IDX]);
            if($post->ok) {
                $in[CLICK_ACTION] = $post->relativeUrl;
            }
        }
        return sendMessageToTopic($cafe->domain, $in);
    }

    public function initDefaultCafeMenu() {
        if ( admin() == false ) return e()->you_are_not_admin;
        $rets = [];
        foreach( cafe()->mainMenus as $menu ) {
            if ( category($menu)->exists ) {
                $rets[$menu] = true;
                continue;
            }
            $rets[$menu] = category()->create([ID=>$menu])->ok;
        }
        return $rets;
    }

    public function check() {
        include ROOT_DIR . 'controller/cafe/check.php';
    }
}
