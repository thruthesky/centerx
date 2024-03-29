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
     *  - other basic settings for app.
     *
     * All the app should get this settings on boot.
     *
     * @return mixed
     */
    public function settings()
    {
        $settings = adminSettings()->get();
        $settings['SUPPORTED_LANGUAGES'] = SUPPORTED_LANGUAGES;
        return $settings;
    }

    /**
     * 관리자 설정에 code/data 를 추가한다.
     *
     * 참고, 관리자만 이 라우트를 호출 할 수 있다.
     *
     * 참고로, 관리자 설정은 앱 시작시에 자동으로 앱이 로드한다(또는 해야 한다). 즉, 관리자 설정에 저장하면, 앱에서 자동적으로 사용이 가능하다.
     *
     * 주의, 이 라우트는 코드가 존재하면 덮어 써 버린다. 따라서, 이 라우트를 호출하여 키/값을 저장하기 전에 해당 키가 존재하는지 미리 확인을 해야 한다.
     *
     * @param $in
     * @return array|string
     *  - string if there is any error.
     *  - [ idx => ?, code => ? ] will be returned on success.
     */
    public function setConfig($in) : array|string
    {
        if ( admin() == false ) return e()->you_are_not_admin;

        if ( $in[CODE] == 'like' ) {
            if ( $in['data'] < 0 ) {
                return e()->point_must_be_0_or_bigger_than_0;
            }
        }
        if ( $in[CODE] == 'dislike' ) {
            if ( $in['data'] > 0 ) {
                return e()->point_must_be_0_or_lower_than_0;
            }
        }

        $settings = adminSettings();
        $settings->set([ $in[CODE] => $in['data']]);

        /// Get the idx of meta.
        $idx = meta()->getIdxFromDB([TAXONOMY => $settings->taxonomy,
            ENTITY => $settings->entity,
            CODE => $in[CODE]]);
        return [ IDX => $idx, CODE => $in[CODE] ];
    }

    /**
     * User can call this route. Meaning, they can read admin settings. But they cannot save.
     * @param $in
     * @return array|string
     * - empty string if the code not exists.
     * - value if the code exists.
     * - error_string on error.
     */
    public function getConfig($in): array|string {
        return ['data' => adminSettings()->get($in[CODE]) ?? ''];
    }

    /**
     * Delete one of admin settings.
     *
     * Only admin can delete the setting.
     *
     * @param $in
     * @return array|string
     * - error_string on error.
     * - ['code' => ...] on success.
     */
    public function deleteConfig($in): array|string {
        if ( admin() == false ) return e()->you_are_not_admin;
        $re = adminSettings()->delete($in[CODE]);
        if ( $re ) return $re;
        else return ['code' => $in[CODE]];
    }



//    public function advertisementSettings($in): array {
//        return ADVERTISEMENT_SETTINGS;
//    }

    public function time($in): array {
        return ['time' => date('r')];
    }

}
