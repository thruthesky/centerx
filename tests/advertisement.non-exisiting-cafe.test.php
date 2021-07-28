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

class AdvertisementNonExistingCafeTest
{

    public function run()
    {
        $this->noActiveBannerLoadTest(TOP_BANNER, 'qna');
        $this->noActiveBannerLoadTest(SQUARE_BANNER, 'qna');
        $this->noActiveBannerLoadTest(SIDEBAR_BANNER, 'qna');
        $this->noActiveBannerLoadTest(LINE_BANNER, 'qna');

        $this->incrementingActiveBannerLoadTest(TOP_BANNER, 'qna');
        $this->incrementingActiveBannerLoadTest(SQUARE_BANNER, 'qna');
        $this->incrementingActiveBannerLoadTest(SIDEBAR_BANNER, 'qna');
        $this->incrementingActiveBannerLoadTest(LINE_BANNER, 'qna');

        $this->noActiveBannerLoadTest(TOP_BANNER);
        $this->noActiveBannerLoadTest(SQUARE_BANNER);
        $this->noActiveBannerLoadTest(SIDEBAR_BANNER);
        $this->noActiveBannerLoadTest(LINE_BANNER);

        $this->incrementingActiveBannerLoadTest(TOP_BANNER);
        $this->incrementingActiveBannerLoadTest(SQUARE_BANNER);
        $this->incrementingActiveBannerLoadTest(SIDEBAR_BANNER);
        $this->incrementingActiveBannerLoadTest(LINE_BANNER);

        $this->activeCategoryLoadGlobalBannerTest(TOP_BANNER);
        $this->activeCategoryLoadGlobalBannerTest(SQUARE_BANNER);
        $this->activeCategoryLoadGlobalBannerTest(SIDEBAR_BANNER);
        $this->activeCategoryLoadGlobalBannerTest(LINE_BANNER);

        $this->activeGlobalLoadCategoryTopBannerTest();
        $this->activeGlobalLoadCategoryLineBannerTest();
        $this->activeGlobalLoadCategorySidebarBannerTest();
        $this->activeGlobalLoadCategorySquareBannerTest();

        $this->activeGlobalAndCategoryTopBannerTest();
        $this->activeGlobalAndCategoryLineBannerTest();
        $this->activeGlobalAndCategorySidebarBannerTest();
        $this->activeGlobalAndCategorySquareBannerTest();
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

    /**
     * 배너를 하나 생성하고, 입력된 옵션에 따라 배너를 시작한다. 즉, 광고 기간을 설정하고 실제 광고를 시작하는 것이다.
     *
     * @param $options
     * @return mixed|null
     */
    private function createAndStartAdvertisement($options)
    {

        $post = request("advertisement.edit", [
            SESSION_ID => login()->sessionId,
            COUNTRY_CODE => $options[COUNTRY_CODE]
        ]);
        unset($options[COUNTRY_CODE]);

        $options[SESSION_ID] = login()->sessionId;
        $options[IDX] = $post[IDX];
        return request("advertisement.start", $options);
    }

    private function bannerIsPresent(mixed $banner, mixed $banners): bool
    {
        if (!$banner || !$banners || empty($banners)) return false;

        $ret = 0;
        foreach ($banners as $_b) {
            if ($_b->idx == $banner[IDX]) $ret++;
        }
        return $ret != 0;
    }

    // ============== TESTS ============== //

    /**
     * This will test if there is no active banner for $banner_type.
     * 
     * if $category is not empty, it will load test banners for that category, with the given $banner_type.
     */
    function noActiveBannerLoadTest($banner_type, $category = '')
    {
        // no active banners.
        $this->clearAdvertisementData();
        $loadOptions = [CAFE_DOMAIN => 'a-non-existing.domain.com', BANNER_TYPE => $banner_type];
        if ($category) $loadOptions[BANNER_CATEGORY] = $category;
        $banners = banner()->loadBanners($loadOptions);

        // top should return 2 hard coded banners.
        if ($banner_type == TOP_BANNER) {
            isTrue(count($banners) == 2, "Two top banners for non-existing domains.");
            isTrue($banners[0]->idx == 0, "Expect: hard coded banner is included.");
            isTrue($banners[1]->idx == 0, "Expect: hard coded banner is included.");
        }

        // the 3 other banner types (Line, Square, Side-bar) should return 0 banners.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 0, "0 $banner_type banners for non-existing domains.");
        }
    }

    /**
     * This test will check for active banner count.
     * if $category is not empty, it will create and load banners for that category.
     * 
     * one by one it will create and load banners to test accuracy of banner loading count.
     * it will start to 1 and will create and test up to 5 active banners.
     */
    function incrementingActiveBannerLoadTest($banner_type, $category = '')
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit($banner_type);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => $banner_type, BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => $banner_type];

        if ($category) {
            $bannerOpts[BANNER_CATEGORY] = $category;
            $loadOptions[BANNER_CATEGORY] = $category;
        }

        // First banner.
        $banner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);
        if ($banner_type == TOP_BANNER) { // top should return 2 banners, 1 active banner and 1 hard coded banner.
            isTrue(count($banners) == 2, "Two top banners for non-existing domains. 1 active and 1 hard coded.");
            isTrue($banners[0]->idx == $banner1[IDX], "Expect: banner with idx " . $banner1[IDX] . " is present.");
            isTrue($banners[1]->idx == 0, "Expect: 1 hard coded banner is included.");
        }
        // the 3 other banner types (Line, Square, Side-bar) should return 1 banner only, since there's only 1 active banner.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 1, "1 $banner_type banners on 'qna' category for non-existing domains.");
            isTrue($banners[0]->idx == $banner1[IDX], "Expect: banner with idx " . $banner1[IDX] . " is present.");
        }

        // Second banner.
        $banner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);
        if ($banner_type == TOP_BANNER) { // top should return 2 active banners.
            isTrue(count($banners) == 2, "Two active top banners for non-existing domains.");
            isTrue($banners[1]->idx == $banner2[IDX], "Expect: banner with idx " . $banner2[IDX] . " is present.");
        }
        // the 3 other banner types (Line, Square, Side-bar) should return 2 active banners.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 2, "2 $banner_type banners on 'qna' category for non-existing domains.");
            isTrue($banners[1]->idx == $banner2[IDX], "Expect: banner with idx " . $banner2[IDX] . " is present.");
        }

        // Third banner.
        $banner3 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);
        if ($banner_type == TOP_BANNER) { // top should return 3 active banners.
            isTrue(count($banners) == 3, "Three active top banners for non-existing domains.");
            isTrue($banners[2]->idx == $banner3[IDX], "Expect: banner with idx " . $banner3[IDX] . " is present.");
        }
        // the 3 other banner types (Line, Square, Side-bar) should return 3 active banners..
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 3, "3 $banner_type banners on 'qna' category for non-existing domains.");
            isTrue($banners[2]->idx == $banner3[IDX], "Expect: banner with idx " . $banner3[IDX] . " is present.");
        }

        // Fourth banner.
        $banner4 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);
        if ($banner_type == TOP_BANNER) { // top should return 4 active banners.
            isTrue(count($banners) == 4, "Four active top banners for non-existing domains.");
            isTrue($banners[3]->idx == $banner4[IDX], "Expect: banner with idx " . $banner4[IDX] . " is present.");
        }
        // the 3 other banner types (Line, Square, Side-bar) should return 4 active banners.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 4, "3 $banner_type banners on 'qna' category for non-existing domains.");
            isTrue($banners[3]->idx == $banner4[IDX], "Expect: banner with idx " . $banner4[IDX] . " is present.");
        }

        // Fifth banner.
        $banner5 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);
        if ($banner_type == TOP_BANNER) { // top should return 5 active banners.
            isTrue(count($banners) == 5, "Five active top banners for non-existing domains.");
            isTrue($banners[4]->idx == $banner5[IDX], "Expect: banner with idx " . $banner5[IDX] . " is present.");
        }
        // the 3 other banner types (Line, Square, Side-bar) should return 4 active banners.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 5, "5 $banner_type banners on 'qna' category for non-existing domains.");
            isTrue($banners[4]->idx == $banner5[IDX], "Expect: banner with idx " . $banner5[IDX] . " is present.");
        }
    }

    /**
     * This test will create 1 category banner and load global banners for $banner_type.
     */
    function activeCategoryLoadGlobalBannerTest($banner_type)
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit($banner_type);
        registerAndLogin(100000);

        $this->createAndStartAdvertisement([
            COUNTRY_CODE => "AC",
            BANNER_TYPE => $banner_type,
            BANNER_CATEGORY => 'qna',
            BEGIN_DATE => time(),
            END_DATE => time(),
            FILE_IDXES => '1'
        ]);

        $banners = banner()->loadBanners([CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => $banner_type, BANNER_CATEGORY => '']);

        // top should return 2 hard coded banners.
        if ($banner_type == TOP_BANNER) {
            isTrue(count($banners) == 2, "Two top banners for non-existing domains.");
            isTrue($banners[0]->idx == 0, "Expect: hard coded banner is included.");
            isTrue($banners[1]->idx == 0, "Expect: hard coded banner is included.");
        }

        // the 3 other banner types (Line, Square, Side-bar) should return  0 banner since it's loading for global.
        if ($banner_type == SQUARE_BANNER || $banner_type == LINE_BANNER || $banner_type == SIDEBAR_BANNER) {
            isTrue(count($banners) == 0, "0 $banner_type banners on global for non-existing domains.");
        }

        // creating more category banner will have the same result when loading with the same options ...
    }

    function activeGlobalLoadCategoryTopBannerTest() {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(TOP_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => TOP_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => TOP_BANNER, BANNER_CATEGORY => 'qna'];

        $banner1 = $this->createAndStartAdvertisement($bannerOpts); // Create Global All country banner.
        $banners = banner()->loadBanners($loadOptions); // Load active QNA All country banner.

        isTrue(count($banners) == 2, "Two top banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");
        isTrue($banners[1]->idx == 0, "Expect: hard coded banner is included.");

        $banner2 = $this->createAndStartAdvertisement($bannerOpts); // create another global top banner for all country.
        $banners = banner()->loadBanners($loadOptions); // load again.
        
        isTrue(count($banners) == 2, "Two active top banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");
        isTrue($this->bannerIsPresent($banner2, $banners), "Expect: banner banner2 is included.");
    }

    function activeGlobalLoadCategoryLineBannerTest() {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(LINE_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => LINE_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => LINE_BANNER, BANNER_CATEGORY => 'qna'];

        $banner1 = $this->createAndStartAdvertisement($bannerOpts); // Create Global All country banner.
        $banners = banner()->loadBanners($loadOptions); // Load active QNA All country banner.

        isTrue(count($banners) == 1, "One active Line banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");

        $banner2 = $this->createAndStartAdvertisement($bannerOpts); // create another global line banner for all country.
        $banners = banner()->loadBanners($loadOptions); // load again.
        
        isTrue(count($banners) == 2, "Two active Line banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");
        isTrue($this->bannerIsPresent($banner2, $banners), "Expect: banner banner2 is included.");
    }

    function activeGlobalLoadCategorySidebarBannerTest() {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(SIDEBAR_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => SIDEBAR_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => SIDEBAR_BANNER, BANNER_CATEGORY => 'qna'];

        $banner1 = $this->createAndStartAdvertisement($bannerOpts); // Create Global All country banner.
        $banners = banner()->loadBanners($loadOptions); // Load active QNA All country banner.

        isTrue(count($banners) == 1, "One active Side-bar banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");

        $banner2 = $this->createAndStartAdvertisement($bannerOpts); // create another global line banner for all country.
        $banners = banner()->loadBanners($loadOptions); // load again.
        
        isTrue(count($banners) == 2, "Two active Side-bar banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");
        isTrue($this->bannerIsPresent($banner2, $banners), "Expect: banner banner2 is included.");
    }

    function activeGlobalLoadCategorySquareBannerTest() {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(SQUARE_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => SQUARE_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => SQUARE_BANNER, BANNER_CATEGORY => 'qna'];

        $banner1 = $this->createAndStartAdvertisement($bannerOpts); // Create Global All country banner.
        $banners = banner()->loadBanners($loadOptions); // Load active QNA All country banner.

        isTrue(count($banners) == 1, "1 active Square banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner1, $banners), "Expect: banner banner1 is included.");

        $banner2 = $this->createAndStartAdvertisement($bannerOpts); // create another global square banner for all country.
        $banner3 = $this->createAndStartAdvertisement($bannerOpts); // 
        $banners = banner()->loadBanners($loadOptions); // load again.
        
        isTrue(count($banners) == 3, "3 active Square banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner2, $banners), "Expect: banner banner2 is included.");
        isTrue($this->bannerIsPresent($banner3, $banners), "Expect: banner banner3 is included.");

        $banner4 = $this->createAndStartAdvertisement($bannerOpts); // create another global square banner for all country.
        $banner5 = $this->createAndStartAdvertisement($bannerOpts); 
        $banner6 = $this->createAndStartAdvertisement($bannerOpts); 
        $banners = banner()->loadBanners($loadOptions); // load again.

        isTrue(count($banners) == 6, "3 active Square banners for non-existing domains.");
        isTrue($this->bannerIsPresent($banner4, $banners), "Expect: banner banner4 is included.");
        isTrue($this->bannerIsPresent($banner5, $banners), "Expect: banner banner5 is included.");
        isTrue($this->bannerIsPresent($banner6, $banners), "Expect: banner banner6 is included.");
    }

    // ===== Global With Category

    function activeGlobalAndCategoryTopBannerTest()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(TOP_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => TOP_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => TOP_BANNER, BANNER_CATEGORY => 'qna'];

        // Create Global
        $globalBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "1 global and 1 hard coded top banners for non-existing domains.");
        isTrue($banners[1]->idx == 0, "Expect: hard coded banner is included.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");

        // Create Another Global
        $globalBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "Two global top banners for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner2, $banners), "Expect: banner globalBanner2 is included.");

        // Create Category
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 3, "1 category and 2 global top banners for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner2, $banners), "Expect: banner globalBanner2 is included.");

        // Create Another Category
        $categoryBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "Two category top banners for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
    }

    function activeGlobalAndCategoryLineBannerTest()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(LINE_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => LINE_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => LINE_BANNER, BANNER_CATEGORY => 'qna'];

        // Create Global
        $globalBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 1, "1 global line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");

        // Create Another Global
        $globalBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "2 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner2, $banners), "Expect: banner globalBanner2 is included.");

        // Create Category
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 1, "1 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");

        // Create Another Category
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "2 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
    }

    function activeGlobalAndCategorySidebarBannerTest()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(SIDEBAR_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => SIDEBAR_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => SIDEBAR_BANNER, BANNER_CATEGORY => 'qna'];

        // Create Global
        $globalBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 1, "1 global line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");

        // Create Another Global
        $globalBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "2 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner2, $banners), "Expect: banner globalBanner2 is included.");

        // Create Category
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 1, "1 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");

        // Create Another Category
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 2, "2 category line banner for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
    }

    function activeGlobalAndCategorySquareBannerTest()
    {
        $this->clearAdvertisementData();
        $this->resetBannerLimit(SQUARE_BANNER);
        registerAndLogin(100000);

        $bannerOpts = [COUNTRY_CODE => "AC", BANNER_TYPE => SQUARE_BANNER, BANNER_CATEGORY => '', BEGIN_DATE => time(), END_DATE => time(), FILE_IDXES => '1'];
        $loadOptions = [CAFE_DOMAIN => 'non-existing.domain.com', BANNER_TYPE => SQUARE_BANNER, BANNER_CATEGORY => 'qna'];

        // Create 1 Global
        $globalBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 1, "1 category square banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");

        // Create 3 category banners
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner1 = $this->createAndStartAdvertisement($bannerOpts);
        $categoryBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $categoryBanner3 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 4, "1 global and 3 category square banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
        isTrue($this->bannerIsPresent($categoryBanner3, $banners), "Expect: banner categoryBanner3 is included.");

        // Create 2 more global banners
        $bannerOpts[BANNER_CATEGORY] = '';
        $globalBanner2 = $this->createAndStartAdvertisement($bannerOpts);
        $globalBanner3 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 6, "3 global and 3 category square banner for non-existing domains.");
        isTrue($this->bannerIsPresent($globalBanner1, $banners), "Expect: banner globalBanner1 is included.");
        isTrue($this->bannerIsPresent($globalBanner2, $banners), "Expect: banner globalBanner2 is included.");
        isTrue($this->bannerIsPresent($globalBanner3, $banners), "Expect: banner globalBanner3 is included.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
        isTrue($this->bannerIsPresent($categoryBanner3, $banners), "Expect: banner categoryBanner3 is included.");

        // Create 1 more category banners
        $bannerOpts[BANNER_CATEGORY] = 'qna';
        $categoryBanner4 = $this->createAndStartAdvertisement($bannerOpts);
        $banners = banner()->loadBanners($loadOptions);

        isTrue(count($banners) == 4, "4 category square banner for non-existing domains.");
        isTrue($this->bannerIsPresent($categoryBanner1, $banners), "Expect: banner categoryBanner1 is included.");
        isTrue($this->bannerIsPresent($categoryBanner2, $banners), "Expect: banner categoryBanner2 is included.");
        isTrue($this->bannerIsPresent($categoryBanner3, $banners), "Expect: banner categoryBanner3 is included.");
        isTrue($this->bannerIsPresent($categoryBanner4, $banners), "Expect: banner categoryBanner4 is included.");
    }
}
