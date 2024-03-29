<?php
/**
 * @file hook.php
 */

/**
 *
 */
const HOOK_POST_EDIT_FORM_ATTR = 'post-edit-form-attr';
const HOOK_POST_EDIT_RETURN_URL = 'post-edit-form-return-url';
const HOOK_POST_LIST_COUNTRY_CODE = 'post_list_country_code';
const HOOK_POST_LIST_TOP = 'post-list-top';
const HOOK_POST_LIST_ROW = 'post-list-row';
const HOOK_POST_CREATE_BUTTON_ATTR = 'HOOK_POST_CREATE_BUTTON_ATTR';
const HOOK_POST_EDIT_CANCEL_BUTTON_ATTR = 'HOOK_POST_EDIT_CANCEL_BUTTON_ATTR';
// print attr only
const HOOK_POST_LIST_TITLE_ATTR = 'HOOK_POST_LIST_TITLE_ATTR';

const HOOK_SUCCESS = 'HOOK_SUCCESS';
const HOOK_USER_READ = 'HOOK_USER_READ';

class Hook {

    public $names;
    /**
     * @var array
     */
    public $hooks = [];


    /**
     * 훅 함수를 추가한다.
     * @param string $name - 훅 이름
     * @param $func
     */
    public function add(string $name, $func) {
        if ( ! isset($this->hooks[$name]) ) $this->hooks[$name] = [];
        $this->hooks[$name][] = $func;
    }

    /**
     * 해당 훅 이름에 연결된 모든 훅들을 제거한다.
     * 테스트용으로 사용한다.
     * @param string $name
     */
    public function delete(string $name) {
        unset($this->hooks[$name]);
    }

    /**
     * 훅을 실행한다.
     *
     * 하나의 훅 이름에 여러개의 훅 함수가 실행될 수 있다.
     *
     * 주의, 2021-04-13. 훅 함수가 여러개가 있을 수 있는데, 그 중 하나가 에러를 리턴하면, 즉시 에러 문자열을 리턴한다.
     *      만약, 에러가 없으면, 그 결과를 문자열로 모아서 리턴하고, 리턴 값이 없으면 null 을 리턴한다.
     *
     * 따라서, 훅을 사용하는 곳에서 필요한 경우, 에러를 리턴하는 지 확인을 해야 한다.
     *
     * @param string $name - 훅 이름
     * @param mixed ...$vars
     * @return null|string
     */
    public function run(string $name, mixed &...$vars): null|string
    {
        $ret = null;
        if ( isset($this->hooks[$name]) ) {
            foreach( $this->hooks[$name] as $func ) {
                $re = $func(...$vars);
                if ( isError($re) ) return $re;
                $ret .= $re;
            }
        }
        return $ret;
    }

}



/**
 * It does memory cache.
 * @return Hook
 */
$__hook = null;
function hook() {
    global $__hook;
    if ( $__hook == null ) $__hook = new Hook();
    return $__hook;
}
