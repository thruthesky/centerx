<?php




addRoute('health.point', function($in) {
    $beginStamp = mktime(0, 0, 0, $in['month'], 1, $in['year']);
    $endStamp = mktime(0, 0, 0, $in['month']+1, 1, $in['year']) - 1;

    $rets = [];
    $userIdx = login()->idx;
    foreach( HEALTH_CATEGORIES as $categoryId ) {
        $categoryIdx = category($categoryId)->idx;

        /// 각 운동 카테고리 별, 월별 총 획득한 포인트.
        $table = pointHistory()->getTable();
        $q = "SELECT SUM(toUserPointApply) FROM $table WHERE toUserIdx=$userIdx AND categoryIdx=$categoryIdx AND createdAt >= $beginStamp AND createdAt <= $endStamp";
        $re = db()->get_var($q);
        if ( $re ) $point = intval($re);
        else $point = 0;
        /// 각 운동 카테고리 별, 기록한 일 수
        $table = post()->getTable();
        $q = "SELECT COUNT(userIdx) FROM $table WHERE userIdx=$userIdx AND categoryIdx=$categoryIdx AND createdAt >= $beginStamp AND createdAt <= $endStamp";
        $re = db()->get_var($q);
        if ( $re ) $days = intval($re);
        else $days = 0;
        $rets[ $categoryId ] = [ 'point' => $point, 'days' => $days ];
    }
    return $rets;
});

/**
 * 년/월을 입력 받아서, 그 년/월의 모든 건강 기록을 리턴한다.
 */
addRoute('health.month', function($in) {
    $beginStamp = mktime(0, 0, 0, $in['month'], 1, $in['year']);
    $endStamp = mktime(0, 0, 0, $in['month']+1, 1, $in['year']) - 1;
    $beginYmd = date('Ymd', $beginStamp);
    $endYmd = date('Ymd', $endStamp);

    $rets = [];
    $userIdx = login()->idx;
    foreach( HEALTH_CATEGORIES as $categoryId ) {
        $categoryIdx = category($categoryId)->idx;
        $where = "userIdx=$userIdx AND categoryIdx=$categoryIdx AND Ymd>=$beginYmd AND Ymd<=$endYmd";
        $posts = post()->search(where: $where);
        foreach( $posts as $post ) {
            $r = $post->response();
            $data = [ CATEGORY_ID => $categoryId, 'point' => $r['appliedPoint'] ];
            if ( $r['title'] ) $data['title'] = $r['title'];
            if ( $r['content'] ) $data['content'] = $r['content'];
            if ( isset($r['files']) && count($r['files']) ) {
                $data['photoUrl'] = thumbnailUrl($r['files'][0]['idx']);
            }
            $rets[$post->Ymd][$categoryId] = $data;
        }
    }
    return $rets;
});


addRoute('health.pointRank', function($in) {
    $entity = entity('itsuda');
    $rows = $entity->search(select: 'userIdx, healthPoint', order: 'healthPoint', page: $in['page'] ?? 1, limit: $in['limit']);
    $rets = [];
    foreach( $rows as $row ) {

        $ret = user($row['userIdx'])->shortProfile();
        $ret['point'] = $row['healthPoint'];

        $rets[] = $ret;
    }
    return $rets;
});


addRoute('health.myRank', function($in) {

    $my = entity('itsuda')->findOne([USER_IDX => login()->idx]);
    if ( $my->hasError ) $point = 0;
    else $point = $my->healthPoint;
    $q = "SELECT COUNT(*) FROM wc_itsuda WHERE healthPoint > $point";
    $rank = db()->get_var($q);
    return login()->updateData('rank', $rank + 1)->updateData('healthPoint', $point)->response();
});


addRoute('meta.login', function($in) {
	return entity('metas')->findOne(['code' => $in['code']])->response();
});





