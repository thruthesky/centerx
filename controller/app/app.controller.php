<?php
/**
 * @file app.controller.php
 */

/**
 * Class AppController
 *
 * This controller handles the request of backend and app settings, system information query, etc.
 * For instance, If the app needs to know some settings of the app, especially if the settings are in config files,
 * Then, this controller should deliver the information to client end.
 */
class AppController
{

    /**
     * Returns API version to client end.
     * @return array
     */
    public function version()
    {
        return ['version' => '2.0.0'];
    }


    /**
     * Returns app settings to client.
     *
     * The app settings contains
     *  - the settings that are set by admin in admin page.
     * All the app should get this settings on boot.
     *
     * @return mixed
     */
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
        adminSettings()->set([ $in[CODE] => $in['data']]);
        return [ $in[CODE] => adminSettings()->get($in[CODE]) ];
    }



    public function advertisementSettings($in): array {
        return ADVERTISEMENT_SETTINGS;
    }

}
