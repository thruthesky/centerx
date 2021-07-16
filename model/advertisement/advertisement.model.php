<?php

/**
 * @file advertisement.model.php
 */
const ADVERTISEMENT_POINT = 'advertisementPoint';
const POINT_PER_DAY = 'pointPerDay';
/**
 * Class AdvertisementModel
 * @property-read string $clickUrl
 * @property-read string $pointPerDay
 * @property-read string $advertisementPoint
 */
class AdvertisementModel extends PostModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
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
        return isPast($this->endAt) && isToday($this->endAt);
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
            $in[CATEGORY_ID] = ADVERTISEMENT_CATEGORY;
            $in[ADVERTISEMENT_POINT] = '0';
            $in[POINT_PER_DAY] = '0';
            $in['status'] = '';
            return advertisement()->create($in);
        } else {
            $post = advertisement($in[IDX]);
            if ($post->isMine() == false) return $this->error(e()->not_your_post);
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
        if ($banner->isMine() == false) return $this->error(e()->not_your_post);

        // check code input
        if (!isset($in[CODE]) || empty($in[CODE])) return $this->error(e()->code_is_empty);

        // check dates input
        if (!isset($in['beginDate']) || empty($in['beginDate'])) return $this->error(e()->begin_date_empty);
        if (!isset($in['endDate']) || empty($in['endDate'])) return $this->error(e()->end_date_empty);


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

        $settings = $this->getAdvertisementPointSetting($in);

        if (isset($settings[$in[CODE]])) {
            $in[POINT_PER_DAY] = $settings[$in[CODE]];
        }

        // Apply global multiplier if advertisement is for global.
        $globalMultiplier = $this->globalBannerMultiplying();
        if ((!isset($in[SUB_CATEGORY]) || empty($in[SUB_CATEGORY])) && $globalMultiplier) {
            $in[POINT_PER_DAY] = $in[POINT_PER_DAY] * $globalMultiplier;
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

        $advertisement = advertisement($in[IDX]);
        if ($advertisement->isMine() == false) return $this->error(e()->not_your_post);

        // 중단된 광고, 취소된 광고, 끝난 광고는 중단하지 못한다. readme.md 참고
        if ($this->stopped($this)) return $this->error(e()->banner_stopped);
        if ($this->cancelled($this)) return $this->error(e()->banner_cancelled);
        if ($this->expired()) return $this->error(e()->banner_expired);

        /// If advertisement started (including today), then, it needs +1 day.
        /// For instance, advertisement starts today and ends tomorrow. The left days must be 1.
        /// past days including today will be deducted.
        if ($advertisement->started()) {
            $action = 'advertisement.stop';
            //
            $in['status'] = 'stop';
            // if advertisement is expired or the last day is today, then no refund.
            if ($advertisement->expired() || $advertisement->lastDay()) $days = 0;
            else $days = daysBetween(time(), $advertisement->endAt);
        }
        /// else, advertisement is not yet started. ( full refund )
        else {
            $action = 'advertisement.cancel';
            //
            $in['status'] = 'cancel';
            $days = daysBetween($advertisement->beginAt, $advertisement->endAt) + 1;
        }
        // 국가 코드
        $in[COUNTRY_CODE] = $advertisement->countryCode;


        // 남은 일 수 별로 환불 될 포인트 금액 계산.
        $pointToRefund = $advertisement->pointPerDay * $days;

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
            entity: $advertisement->idx,
            categoryIdx: $advertisement->categoryIdx,
        );

        debug_log("refund apply point; {$activity->toUserPointApply} != {$pointToRefund}");
        if ($activity->toUserPointApply != $pointToRefund) {
            return $this->error(e()->advertisement_point_refund_failed);
        }

        return $advertisement->update($in);
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

function banner(int $idx = 0): AdvertisementModel
{
    return advertisement($idx);
}
