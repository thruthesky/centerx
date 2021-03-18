<?php




routeAdd('health.point', function($in) {
    $beginStamp = mktime(0, 0, 0, $in['month'], 1, $in['year']);
    $endStamp = mktime(0, 0, 0, $in['month']+1, 1, $in['year']) - 1;

    $rets = [];
    $table = pointHistory()->getTable();
    $userIdx = login()->idx;
    foreach( HEALTH_CATEGORIES as $categoryId ) {
        $categoryIdx = category($categoryId)->idx;
        $q = "SELECT SUM(toUserPointApply) FROM $table WHERE toUserIdx=$userIdx AND categoryIdx=$categoryIdx AND createdAt >= $beginStamp AND createdAt <= $endStamp";
        $re = db()->get_var($q);
        if ( $re ) $point = intval($re);
        else $point = 0;
        $rets[ $categoryId ] = $point;
    }
    return $rets;
});


routeAdd('health.pointRank', function($in) {
    $entity = entity('itsuda');
    $rows = $entity->search(select: 'userIdx, healthPoint', order: 'healthPoint', limit: $in['limit']);
    $rets = [];
    foreach( $rows as $row ) {
        $ret = [ 'userIdx' => $row['userIdx'], 'point' => $row['healthPoint'] ];
        $user = user($row['userIdx']);
        $ret['photoUrl'] = thumbnailUrl($user->photoIdx ?? 0, 100, 100);
        $ret['name'] = empty($user->name) ? '이름없음' : $user->name;
        $ret['gender'] = $user->gender;
        $ret['birthdate'] = $user->birthdate;
        $rets[] = $ret;
    }
    return $rets;
});

