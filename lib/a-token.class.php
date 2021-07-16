<?php

/**
 * Class AToken
 *
 */
class AToken
{


    public function register(User $user)
    {
        $user->update(['atoken' => config()->get(TOKEN_REGISTER)]);
        $this->log(
            userIdx : $user-> profile()[IDX],
            reason: 'tokenRegister',
            pointAfterApply:  $user -> profile()[POINT],
            tokenApply: config()->get(TOKEN_REGISTER),
            tokenAfterApply : config()->get(TOKEN_REGISTER),
        );

    }

    public function accountDelete():array{
        login()->update(['atoken' => 0]);
        $this->log(
            userIdx : login() -> idx,
            reason: 'accountDelete',
        );
        return ['accountDelete;'=> login() -> profile()];
    }



    public function inAppPurchase($point = 0)
    {
        $saving = $point * ( config()->get(TOKEN_REGISTER) / 100 ) * 0.01;
        $atoken = login()->atoken;
        login()->update(['atoken' => $atoken + $saving]);
        $this->log(
            userIdx: login() -> idx,
            reason: 'pointInAppPurchase',
            tokenApply: $saving,
            tokenAfterApply : login()->atoken,
        );
    }

    public function exchangeToken($in): array {
        $point = $in['pointToExchange'];
        $exchangedToken = sprintf('%d', $point / 100);
        debug_log('point: ' . $point);
        debug_log('exchangedToken: ' . $exchangedToken);
        debug_log("user point: ",  login()->getPoint());

        $changedPoint = point()->addUserPoint(login()->idx, -$point);
        $atoken = login()->atoken;

        debug_log('changedPoint;', $changedPoint);
        debug_log("atoken: ",  $atoken);

        login()->update(['atoken' => $atoken + $exchangedToken]);

        debug_log('changedToken;', login() -> atoken);

//        tokenHistory()->create([
//            USER_IDX => login()->idx,
//            'pointApply' => $point,
//            'pointAfterApply' => login()->getPoint(),
//            'tokenApply' => $exchangedToken,
//            'tokenAfterApply' => login()->atoken,
//            'reason' => 'pointExchange'
//        ]);

        $idx = $this->log(
            userIdx : login() -> idx,
            reason : 'pointExchange',
            pointApply: $point,
            pointAfterApply : login()->getPoint(),
            tokenApply : $exchangedToken,
            tokenAfterApply : login()->atoken,
        );

        return ['changedPoint;'=> $changedPoint, 'changedToken;'=> login() -> atoken, 'history' => $idx];
    }

    /**
     * @param User $user 추천 받는 사용자.
     */
    public function recommend($in) {
        user($in['otherIdx'])->update(['atoken' => user($in['otherIdx'])->atoken + config()->get(TOKEN_RECOMMENDATION)]);

       $this->log(
           userIdx : $in['otherIdx'],
           reason: 'userRecommend',
           tokenApply: config()->get(TOKEN_RECOMMENDATION),
           tokenAfterApply: user($in['otherIdx'])->atoken,
       );
    }

    public function admin($in)
    {

       $re = user($in['otherIdx'])->update(['atoken' => user($in['otherIdx'])->atoken + $in['value']]);

       debug_log('re', $re);

        $this->log(
            userIdx : $in['otherIdx'],
            reason: $in['reason'],
            tokenApply: $in['value'],
            tokenAfterApply: user($in['otherIdx'])->atoken,
        );
    }



    /**
     * 토큰 기록
     *
     * 시스템이 토큰을 주거나(글/코멘트 쓰기/삭제), 또는 관리자가 토큰을 충전하거나 등에서는 fromUserIdx 값이 없고, toUserIdx 값만 있다.
     * 그래서, toUserIdx 와 toUserPointApply 의 값은 거의 항상 들어와야 한다.
     * 하지만, 사용자끼리 토큰을 주고 받는 경우(증감하는 경우)에는 fromUserIdx 와 toUserIdx 값이 있다.
     *
     * @param
     * @param
     * @param
     * @param
     * @return int - 기록 레코드 번호
     */

    public function log(
        int $userIdx,
        string $reason,
        int $pointApply = 0,
        int $pointAfterApply = 0,
        int $tokenApply = 0,
        int $tokenAfterApply = 0,

    ): int {
        $history = [
            'userIdx' => $userIdx,
            REASON => $reason,
            'pointApply' => $pointApply,
            'pointAfterApply' => $pointAfterApply,
            'tokenApply' => $tokenApply,
            'tokenAfterApply' => $tokenAfterApply,
        ];
        $record = aTokenHistory()->create($history);
        return $record->idx;
    }




}

function aToken() {
    return new AToken();
}