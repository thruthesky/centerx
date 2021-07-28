<?php

$at = new AdvertisementNonExistingCafeTest();
$at->run();



// category only.
// first, create the 4 type of banners of a category of all country. and test so, there must be at least 8 tests.
// -> without category, with category.
// --> test for categories, Not for globals.
//

// global only.

// then, create the 4 types of banners of global category ...
// -> test to get 1 top banner of all country. and two 2 hard coded banner. => the result must be 3 banners.
// -> test to get 2 top banner of all country. => the result must be 2 banners.
// -> square banner, test to get
//      -> 0 banner.
//      -> 1 banner only.
//      -> 2 banner only.
//      -> 3 banner only.
//      -> 4 banner only.
//      -> 5 banner only.


/// category & global.
/// -> if there no banner on category, get global.
/// get 1 category, 5 global.
/// get 4 cateegry, 0 global.

// sidebar banner, test to get, 0 banner, 1 banner, 2 banner, of category or global.






class AdvertisementNonExistingCafeTest {

    public function run() {
        $this->topBannerLoadWithNonExistingCafe();
    }

    function __construct()
    {

        // Create 'advertisement' category if it does not exists.
        if (!category()->exists([ID => ADVERTISEMENT_CATEGORY])) {
            $admin = setLoginAsAdmin();
            category()->create([ID => ADVERTISEMENT_CATEGORY]);
        }

        // 회원 가입 포인트를 0 으로 설정.
        userActivity()->setRegisterPoint(0);
        setLogout();
        enableTesting();

        $this->resetGlobalMulplying();
        $this->resetBannerLimit(TOP_BANNER);
        $this->resetBannerLimit(SIDEBAR_BANNER);
        $this->resetBannerLimit(SQUARE_BANNER);
        $this->resetBannerLimit(LINE_BANNER);
        $this->resetBannerLimit(TOP_BANNER, category: false);
        $this->resetBannerLimit(SIDEBAR_BANNER, category: false);
        $this->resetBannerLimit(SQUARE_BANNER, category: false);
        $this->resetBannerLimit(LINE_BANNER, category: false);
    }


    private function resetGlobalMulplying($globalMultiplying = 0)
    {
        adminSettings()->set(ADVERTISEMENT_GLOBAL_BANNER_MULTIPLYING, $globalMultiplying);
    }


    private function resetBannerLimit(string $banner_type, $value = 10, $category = true)
    {
        banner()->setMaxNoOn($banner_type, $category, $value);
    }


    private function clearAdvertisementData()
    {
        $cat = category(ADVERTISEMENT_CATEGORY);
        db()->delete(post()->getTable(), [CATEGORY_IDX => $cat->idx]);
    }


    function topBannerLoadWithNonExistingCafe()
    {
        // clear. no banner.
        $this->clearAdvertisementData();
        // get 2 hard coded banner.
        $banners = banner()->loadBanners([CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => TOP_BANNER]);
        isTrue(count($banners) >= 2, "Two top banners for non-existing domains.");

    }



    function nonExistingCafeBannerLoadTest($banner_type)
    {
        $this->clearAdvertisementData();

        $banners = request("advertisement.loadBanners", [CAFE_DOMAIN => 'a-non-existing.domain.com', BANNER_TYPE => $banner_type]);
        if ($banner_type == TOP_BANNER) {
            isTrue(count($banners) == 2, "Two top banners for non-existing domains.");
        }

        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 0, "0 $banner_type banners for non-existing domains.");
        }

    }
}