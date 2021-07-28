<?php

/**
 * @file advertisement.model.php
 */
const ADVERTISEMENT_POINT = 'advertisementPoint';
const POINT_PER_DAY = 'pointPerDay';
const BANNER_TYPE = CODE;
const BANNER_CATEGORY = SUB_CATEGORY;
const ALL_COUNTRY_CODE = 'AC';
const GLOBAL_BANNER_CATEGORY = '';





/**
 * Class AdvertisementModel
 * @property-read string $clickUrl
 * @property-read string $bannerUrl
 * @property-read string $pointPerDay
 * @property-read string $advertisementPoint
 * @property-read string $type 배너 타입. 배너 타입은 code 에 저장되는데, 이름을 알기 쉽게하기 위해서, 재 지정. 실제로는 code 값을 리턴.
 */
class AdvertisementModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }


    /**
     * getter
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed
    {
        if ($name == 'type') return $this->code;
        return parent::__get($name);
    }


    public function getAdvertisementPointSetting($in): array
    {
        $pointSetting = $this->advertisementPoints();
        if (empty($pointSetting)) return $pointSetting;

        if (isset($in[COUNTRY_CODE]) && isset($pointSetting[$in[COUNTRY_CODE]])) {
            $setting = $pointSetting[$in[COUNTRY_CODE]];
        } else {
            $setting = $pointSetting['default'];
        }
        return $setting;
    }


    private function bannerPoint($bannerType, string $countryCode = ''): int
    {
        if (!$bannerType) return 0;

        $pointSetting = $this->advertisementPoints();
        if (empty($pointSetting)) return 0;

        if ($countryCode && isset($pointSetting[$countryCode])) {
            return $pointSetting[$countryCode][$bannerType];
        } else {
            return $pointSetting['default'][$bannerType];
        }
    }

    public function topBannerPoint(string $countryCode = ''): int
    {
        return $this->bannerPoint(TOP_BANNER, $countryCode);
    }

    public function LineBannerPoint(string $countryCode = ''): int
    {
        return $this->bannerPoint(LINE_BANNER, $countryCode);
    }

    public function SquareBannerPoint(string $countryCode = ''): int
    {
        return $this->bannerPoint(SQUARE_BANNER, $countryCode);
    }

    /**
     * 글 상태. README.md 참고
     *
     * If input $banner is null, then use current banner object.
     *
     * @param AdvertisementModel|null $banner
     * @return string
     */
    public function getStatus(AdvertisementModel $banner = null): string
    {
        if ($banner == null) $banner = $this;

        if ($this->stopped($banner) || $this->cancelled($banner)) return 'inactive';
        if ($banner->advertisementPoint == '0') return 'inactive';


        $now = time();
        if (daysBetween($now, $banner->beginAt) > 0) return 'waiting';
        else if (isBetweenDay($now, $banner->beginAt, $banner->endAt)) return 'active';
        else return 'inactive';
    }

    // 광고가 중단 되었는가?
    public function stopped(AdvertisementModel $banner)
    {
        return isset($banner->status) && $banner->status == 'stop';
    }
    // 광고가 취소되었는가?
    public function cancelled(AdvertisementModel $banner)
    {
        return $banner->status && $banner->status == 'cancel';
    }


    /**
     * Returns true if the advertisement has started.
     * Checks 'beginAt' if is equivalent to today or past days.
     * @return bool
     */
    public function started(): bool
    {
        return isTodayOrPast($this->beginAt);
    }

    /**
     * 광고가 이미 끝났으면, 참을 리턴한다.
     *
     * @note, stamp 로 저장되면, 오늘이지만, stamp 가 과거일 수 있다. 그래서 과거중에서 오늘은 뺀다.
     *
     * Returns true if the advertisement is expired, meaning the end date is either past or today.
     * Checks 'endAt' if is equivalent to today or past days.
     * @return bool
     */
    public function expired(): bool
    {
        return isPast($this->endAt) && isToday($this->endAt) == false;
        //        return isTodayOrPast($this->endAt);
    }

    /**
     * 오늘이 광고 마지막 날이면 참을 리턴한다.
     * @return bool
     */
    public function lastDay(): bool
    {
        return isToday($this->endAt);
    }


    public function maximumAdvertisementDays(): int
    {
        return intVal(adminSettings()->get('maximumAdvertisementDays') ?? 0);
    }


    /**
     * Returns the key for saving the number of maximum banners into meta table.
     *
     * @param $banner_type
     * @param $category
     * @return string
     */
    public function maxNoKey($banner_type, $category): string
    {
        if ($category) $cat = "Category";
        else $cat = "Global";
        $banner_type = ucfirst($banner_type);
        return "maxNoOn{$cat}{$banner_type}Banner";
    }

    /**
     * Returns the maximum number of banner for that banner type and category.
     * @param $banner_type
     * @param $category
     * @return int|mixed
     */
    public function maxNoOn($banner_type, $category)
    {
        return adminSettings()->get($this->maxNoKey($banner_type, $category)) ?? 0;
    }

    /**
     * Set maximum number of banners of the banner type and category.
     *
     * @param string $banner_type
     * @param bool $category
     * @param int $value
     */
    public function setMaxNoOn(string $banner_type, bool $category = true, int $value = 10): void
    {
        $k = banner()->maxNoKey($banner_type, $category);
        adminSettings()->set($k, $value);
    }




    public function globalBannerMultiplying(): int
    {
        return intVal(adminSettings()->get('globalBannerMultiplying') ?? 0);
    }


    public function advertisementCategoryArray(): array
    {
        $arr = explode(',', adminSettings()->get('advertisementCategories') ?? '');
        $rets = [];
        foreach ($arr as $c) {
            $c = trim($c);
            if (empty($c)) continue;
            $rets[] = $c;
        }
        return $rets;
    }

    public function advertisementPoints(): array
    {
        $rows = (new AdvertisementPointSettingsModel())->search(order: COUNTRY_CODE, by: 'ASC', object: true);
        $rets = [];
        foreach ($rows as $entity) {
            $cc = empty($entity->countryCode) ? 'default' : $entity->countryCode;
            $rets[$cc] = [
                TOP_BANNER => $entity->top,
                SIDEBAR_BANNER => $entity->sidebar,
                SQUARE_BANNER => $entity->square,
                LINE_BANNER => $entity->line,
            ];
        }
        return $rets;
    }


    /**
     * 배너 글을 생성 또는 수정한다.
     *
     * 이 때, 카테고리는 고정되어져 있다.
     *
     * @param $in
     * @return self
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     */
    public function edit($in): self
    {
        if (notLoggedIn()) return $this->error(e()->not_logged_in);

        if (!isset($in[IDX]) || empty($in[IDX])) {
            // create the banner

            if (!isset($in[COUNTRY_CODE]) || empty($in[COUNTRY_CODE])) return $this->error(e()->empty_country_code);
            $in[CATEGORY_ID] = ADVERTISEMENT_CATEGORY;
            $in[ADVERTISEMENT_POINT] = '0';
            $in[POINT_PER_DAY] = '0';
            $in['status'] = '';
            return advertisement()->create($in);
        } else {
            $post = advertisement($in[IDX]);
            if ($post->isMine() == false) return $this->error(e()->not_your_advertisement);
            return $post->update($in);
        }
    }

    /**
     * 배너를 리턴 할 때, 추가적으로
     * @param string|null $fields
     * @param int $comments
     * @return array|string
     */
    public function response(string $fields = null, int $comments = 0): array|string
    {
        if ($this->hasError) return $this->getError(true);
        $banner = parent::response($fields, $comments);
        $banner['status'] = advertisement()->getStatus($this);
        return $banner;
    }


    /**
     * @param $in
     * @return $this
     */
    public function start($in): self
    {
        if (notLoggedIn()) return $this->error(e()->not_logged_in);

        // check if post idx is present.
        if (!isset($in[IDX]) && empty($in[IDX])) return $this->error(e()->idx_is_empty);

        // check if banner is mine
        $banner = banner($in[IDX]);
        if ($banner->isMine() == false) return $this->error(e()->not_your_advertisement);

        // check code input
        // if (!isset($in[CODE]) || empty($in[CODE])) return $this->error(e()->code_is_empty);

        // check dates input
        if (!isset($in[BEGIN_DATE]) || empty($in[BEGIN_DATE])) return $this->error(e()->begin_date_empty);
        if (!isset($in[END_DATE]) || empty($in[END_DATE])) return $this->error(e()->end_date_empty);


        $in = $banner->updateBeginEndDate($in);

        // add 1 to include beginning date.
        $days = daysBetween($in[BEGIN_AT], $in[END_AT]) + 1;

        // 최대 기간이 정해져 있으면, 그 기간 이내에로 광고 기간을 설정.
        $maximumAdvertisementDays = $this->maximumAdvertisementDays();
        if ($maximumAdvertisementDays) {
            if ($days > $maximumAdvertisementDays) return $this->error(e()->maximum_advertising_days);
        }

        // Save point per day. This will be saved in meta.
        $in[POINT_PER_DAY] = 0;

        $settings = $this->getAdvertisementPointSetting([COUNTRY_CODE => $banner->countryCode]);

        // $banner->code may not be set when editting advertisement.
        // it can also be set when starting the advertisement.
        // if user decided to set `code` when starting, it checks also for $in[CODE]
        $code = $banner->code;
        if (!$code && isset($in[CODE]) && !empty($in[CODE])) $code = $in[CODE];
        if (isset($settings[$code])) {
            $in[POINT_PER_DAY] = $settings[$code];
        } else {
            // If $settings[$banner->code] resolves to undefined,
            // it is either the code is actually wrong or there is no point setting set.
            return $this->error(e()->wrong_banner_code_or_no_point_setting);
        }

        $category = '';
        if (isset($in[SUB_CATEGORY]) && !empty($in[SUB_CATEGORY])) $category = $in[SUB_CATEGORY];

        // BANNER LIMIT
        // If max number of banner limit is bigger than 0 and banner count is bigger than or equal max banner limit.
        // All country is also following this rule.
        // d("maxNoOn => $maxNo : $code");
        $maxNo = $this->maxNoOn($code, $category);
        $bannerCount = $this->countOf($code, $category, $banner->countryCode);
        if ($maxNo <= $bannerCount) return $this->error(e()->max_no_banner_limit_exeeded);

        // GLOBAL MULTIPLYING
        // Apply global multiplier if advertisement is for global.
        // only execute if $globalMultiplier is greater than 1.
        // Since multiplying by 1 will return the same value.
        $globalMultiplier = $this->globalBannerMultiplying();
        if ($globalMultiplier > 1) {
            // If SUB_CATEOGRY is not provided or countryCode is "AC" (All Country)
            if (!$category || $banner->countryCode == "AC") {
                $in[POINT_PER_DAY] = $in[POINT_PER_DAY] * $globalMultiplier;
            }
        }

        // Save total point for the advertisement periods.
        $in[ADVERTISEMENT_POINT] = $in[POINT_PER_DAY] * $days;

        // check if the user has enough point
        if (login()->getPoint() < $in[ADVERTISEMENT_POINT]) {
            return $this->error(e()->lack_of_point);
        }

        // Record for post creation and change point.
        $activity = userActivity()->changePoint(
            action: 'advertisement.start',
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: -$in[ADVERTISEMENT_POINT],
            taxonomy: POSTS,
            entity: $banner->idx,
            categoryIdx: $banner->categoryIdx,
        );

        debug_log("apply point; {$activity->toUserPointApply} != {$in[ADVERTISEMENT_POINT]}");
        if ($activity->toUserPointApply != -$in[ADVERTISEMENT_POINT]) {
            // @attention !! If this error happens, it is a critical problem.
            // The admin must investigate the database and restore user's point.
            // Then, it needs to rollback the SQL query and needs to have race condition test to prevent the same incident.
            return $this->error(e()->advertisement_point_deduction_failed);
        }

        // Save total deducted point from user which the total point for the advertisement.

        // When the advertisement starts( or restarts after stop or cancel ), set the status to empty('') string.
        $in['status'] = '';

        return $banner->update($in);
    }

    /**
     * @param $in
     * @return $this
     */
    public function stop($in): self
    {

        if (notLoggedIn()) return $this->error(e()->not_logged_in);
        if (!isset($in[IDX]) || empty($in[IDX])) return $this->error(e()->idx_is_empty);

        $banner = banner($in[IDX]);

        if ($banner->isMine() == false) return $banner->error(e()->not_your_post);

        // 중단된 광고, 취소된 광고, 끝난 광고는 중단하지 못한다. readme.md 참고
        if ($banner->stopped($banner)) return $banner->error(e()->banner_stopped);
        if ($banner->cancelled($banner)) return $banner->error(e()->banner_cancelled);
        if ($banner->expired()) return $banner->error(e()->banner_expired);

        /// If advertisement started (including today), then, it needs +1 day.
        /// For instance, advertisement starts today and ends tomorrow. The left days must be 1.
        /// past days including today will be deducted.
        if ($banner->started()) {
            $action = 'advertisement.stop';
            //
            $in['status'] = 'stop';
            // if advertisement is expired or the last day is today, then no refund.
            if ($banner->expired() || $banner->lastDay()) $days = 0;
            else $days = daysBetween(time(), $banner->endAt);
        }
        /// else, advertisement is not yet started. ( full refund )
        else {
            $action = 'advertisement.cancel';
            //
            $in['status'] = 'cancel';
            $days = daysBetween($banner->beginAt, $banner->endAt) + 1;
        }
        // 국가 코드
        $in[COUNTRY_CODE] = $banner->countryCode;


        // 남은 일 수 별로 환불 될 포인트 금액 계산.
        $pointToRefund = $banner->pointPerDay * $days;

        $in[BEGIN_AT] = 0;
        $in[END_AT] = 0;
        $in[ADVERTISEMENT_POINT] = '0';
        $in[POINT_PER_DAY] = '0';

        // Record for change point.
        $activity = userActivity()->changePoint(
            action: $action,
            fromUserIdx: 0,
            fromUserPoint: 0,
            toUserIdx: login()->idx,
            toUserPoint: $pointToRefund,
            taxonomy: POSTS,
            entity: $banner->idx,
            categoryIdx: $banner->categoryIdx,
        );

        debug_log("refund apply point; {$activity->toUserPointApply} != {$pointToRefund}");
        if ($activity->toUserPointApply != $pointToRefund) {
            return $banner->error(e()->advertisement_point_refund_failed);
        }

        return $banner->update($in);
    }

    /**
     * Returns active banners of the country of the cafe.
     *
     * @note, when client-end looks for banners for a cafe, the system should return the banners of root cafe's country banners.
     *  But right now, it returns the banners of the cafe country. Not the root cafe's country.
     *
     * @param array $in - See `parsePostSearchHttpParams()` for detail input.
     *
     * @return self[]|string
     * - idx
     * - url
     * - clickUrl
     * - bannerUrl
     * - subcategory
     * - code
     * - countryCode
     *  - title : if code is 'line', it will be included .
     *
     * @attention if subcaetgory is empty, it is set to 'global'.
     * It only returns banners that are active.
     * - with countryCode
     * - files
     * - and time now is either equivalent or between begin and end Date.
     *
     * @todo test this method.
     */
    public function loadBanners(array $in): array|string
    {
        // error check.
        if (!isset($in[CAFE_DOMAIN]) || empty($in[CAFE_DOMAIN])) return e()->empty_domain;

        // If the given cafe(or its domain) cafe does not exists, then return all country banner.
        // @see README.md for details.
        $cafe = cafe(domain: $in[CAFE_DOMAIN]);

        if (!isset($in[BANNER_TYPE]) || empty($in[BANNER_TYPE])) return e()->empty_banner_type;

        if ( $cafe->exists ) {
            $countryCode = $cafe->countryCode;
        } else {

            $rootDomain = get_root_domain($in[CAFE_DOMAIN]);
            if ( isset(cafe()->mainCafeSettings[$rootDomain]) ) {
                $countryCode = cafe()->mainCafeSettings[$rootDomain][COUNTRY_CODE];
            } else {
                $countryCode = ALL_COUNTRY_CODE;
            }
        }

        return $this->loadBannersOf($in[BANNER_TYPE], $in[BANNER_CATEGORY] ?? GLOBAL_BANNER_CATEGORY, $countryCode);
    }

    /**
     * Search for active banners following the `default banner rules` in Readme.
     *
     *
     * @logic
     * Get banner of same type of same category of same country. If non exists, follow default banner rules.
     * Get global banner of same type of same country. If non exists, then,
     * Get banner of same type of same category of all country. If non exists, then,
     * Get global banner of same type of all country. If non exists, then,
     * Get hard coded banner on the source code(or admin settings).
     *
     * Top banner must return at least 2 banners. which means, if there is no banner at all, hard coded banner will be returned.
     * Square banner is trying to return minimum of 4 banners.
     *  - It will collect minimum of 4 banners following the default banner rule.
     *  - But there is no hard coded banner for square banner.
     * Sidebar and Line banner may return 0 banner.
     *  - If there is no available default banner, it return 0 banner.
     *  - It does not collect minimum number of banners. If there is a banner following the default banner rule, it returns.
     *  - There is no hard coded banner for this banner type.
     *
     * @param string $banner_type
     */
    private function loadBannersOf(string $banner_type, string $banner_category, string $countryCode)
    {
        // d(" $banner_type, $banner_category, $countryCode ");

        if ($banner_type == SIDEBAR_BANNER || $banner_type == LINE_BANNER) {
            $posts = $this->categoryBannersOfSameCountry($banner_type, $banner_category, $countryCode);
            if (count($posts)) return $posts;
            $posts = $this->globalBannersOfSameCountry($banner_type, $countryCode);
            if (count($posts)) return $posts;
            $posts = $this->categoryBannersOfAllCountry($banner_type, $banner_category);
            if (count($posts)) return $posts;
            $posts = $this->globalBannersOfAllCountry($banner_type);
            return $posts;
        } else if ($banner_type == TOP_BANNER) {
            $posts = $this->categoryBannersOfSameCountry($banner_type, $banner_category, $countryCode);
            if (count($posts) >= 2) return $posts;
            $posts = array_merge($posts, $this->globalBannersOfSameCountry($banner_type, $countryCode));
            if (count($posts) >= 2) return $posts;
            $posts = array_merge($posts, $this->categoryBannersOfAllCountry($banner_type, $banner_category));
            if (count($posts) >= 2) return $posts;
            $posts = array_merge($posts, $this->globalBannersOfAllCountry($banner_type));
            if (count($posts) >= 2) return $posts;
            $posts = array_merge($posts, $this->hardCodedTopBanners(count($posts)));
            return $posts;
        } else if ($banner_type == SQUARE_BANNER) {
            $posts = $this->categoryBannersOfSameCountry($banner_type, $banner_category, $countryCode);
            if (count($posts) >= 4) return $posts;
            $posts = array_merge($posts, $this->globalBannersOfSameCountry($banner_type, $countryCode));
            if (count($posts) >= 4) return $posts;
            $posts = array_merge($posts, $this->categoryBannersOfAllCountry($banner_type, $banner_category));
            if (count($posts) >= 4) return $posts;
            $posts = array_merge($posts, $this->globalBannersOfAllCountry($banner_type));
            return $posts;
        }
        return e()->wrong_banner_type;
    }

    /**
     * Returns condition for querying active banners.
     * @return string
     */
    private function activeBannerCondition()
    {
        $now = time();
        $today = today(); // 0 second of today.
        return "beginAt <= $now AND endAt >= $today AND fileIdxes != ''";
    }

    /**
     * returns count of active banners according to type, category and countryCode.
     */
    private function countOf(string $banner_type, string $banner_category = '', string $countryCode = ALL_COUNTRY_CODE): int
    {
        $where = "code = ? AND countryCode='$countryCode' AND " . $this->activeBannerCondition();
        $params = [$banner_type];

        if ($banner_category) {
            $where = $where . " AND subcategory=?";
            $params[] = $banner_category;
        }

        return advertisement()->count(where: $where, params: $params);
    }

    private function categoryBannersOfSameCountry($banner_type, $banner_category, $countryCode)
    {
        if (!$banner_category) return [];
        if ($countryCode == ALL_COUNTRY_CODE) return [];

        // endAt is the 0 second of last day.
        $where = "code = ? AND subcategory=? AND countryCode='$countryCode' AND " . $this->activeBannerCondition();
        $params = [$banner_type, $banner_category];
        $posts = advertisement()->search(where: $where, params: $params, order: 'endAt', object: true, limit: 500);
        return $posts;
    }

    /**
     * @param $banner_type
     * @param $countryCode
     * @return array
     */
    private function globalBannersOfSameCountry($banner_type, $countryCode): array
    {
        if ($countryCode == ALL_COUNTRY_CODE) return [];

        // Get global banner of same type of same country.
        $where = "code = ? AND subcategory='' AND countryCode='$countryCode' AND " . $this->activeBannerCondition();
        $params = [$banner_type];

        $posts = advertisement()->search(where: $where, params: $params, order: 'endAt', object: true, limit: 500);
        return $posts;
    }

    private function categoryBannersOfAllCountry($banner_type, $banner_category)
    {
        if (!$banner_category) return [];
        $ac = ALL_COUNTRY_CODE;

        // Get banner of same type of same category of all country.
        $where = "code = ? AND subcategory=? AND countryCode='$ac' AND " . $this->activeBannerCondition();
        $params = [$banner_type, $banner_category];
        $posts = advertisement()->search(where: $where, params: $params, order: 'endAt', object: true, limit: 500);
        return $posts;
    }

    private function globalBannersOfAllCountry($banner_type)
    {

        $ac = ALL_COUNTRY_CODE;

        // Get global banner of same type of all country.
        $where = "code = ? AND subcategory='' AND countryCode='$ac' AND " . $this->activeBannerCondition();
        $params = [$banner_type];
        $posts = advertisement()->search(where: $where, params: $params, order: 'endAt', object: true, limit: 500);
        return $posts;
    }

    /**
     * @param int $count
     * @return self[]
     * @todo put hardcoded banners.
     */
    public function hardCodedTopBanners(int $count): array
    {

        $p = post();
        $p->updateMemoryData(CLICK_URL, 'https://katalkenglish.com');
        $p->updateMemoryData(BANNER_URL, 'https://sonub.com/img/banner/katalkenglish.com.jpg');
        $p->updateMemoryData(CODE, TOP_BANNER);

        $banners = [$p];
        if ($count == 1) {
            return $banners;
        }
        $p = post();
        $p->updateMemoryData(CLICK_URL, 'https://withcenter.com');
        $p->updateMemoryData(BANNER_URL, 'https://sonub.com/img/banner/withcenter.com.jpg');
        $p->updateMemoryData(CODE, TOP_BANNER);

        $banners[] = $p;
        return $banners;
    }

    /**
     * @param AdvertisementModel[] $posts
     * @return array
     */
    public function responses(array $posts): array
    {
        $res = [];
        foreach ($posts as $post) {

            $data = [
                'idx' => $post->idx,
                'url' => $post->relativeUrl,
                'clickUrl' => $post->clickUrl,
                // default top banner 의 경우, bannerUrl 이 넘어온다.
                'bannerUrl' => $post->bannerUrl ??  $post->fileByCode('banner')->url,
                'subcategory' => $post->subcategory, // if it's empty, it's global.
                'code' => $post->code,
                'countryCode' => $post->countryCode, // it may be all country.
            ];

            if ($post->code == LINE_BANNER) $data['title'] = $post->title;

            $res[] = $data;
        }
        return $res;
    }
}


/**
 *
 *
 * @param int $idx
 * @return AdvertisementModel
 */
function advertisement(int $idx = 0): AdvertisementModel
{
    return new AdvertisementModel($idx);
}

/**
 * Alias of advertisement()
 *
 * @param int $idx
 * @return AdvertisementModel
 */
function banner(int $idx = 0): AdvertisementModel
{
    return advertisement($idx);
}
