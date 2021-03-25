<?php


/**
 * @file app.route.php
 */

/**
 * Class AppRoute
 */
class AppRoute
{

    /**
     * Returns API version to client end.
     * @return array
     */
    public function version()
    {
        return ['version' => '0.0.1'];
    }


    public function settings()
    {
        return adminSettings()->get();
    }

    /**
     * 관리자 설정에 code/data 를 추가한다.
     *
     * 참고로, 관리자 설정은 앱 시작시에 자동으로 앱이 로드한다(또는 해야 한다). 즉, 관리자 설정에 저장하면, 앱에서 자동적으로 사용이 가능하다.
     *
     * @param $in
     * @return array|string
     */
    public function setConfig($in) : array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;
        $re = adminSettings()->set([ $in[CODE] => $in['data']]);
        if ( $re == '') {
            /// success
            return ['code' => $in['code']];
        } else {
            /// error
            return $re;
        }
    }



}
