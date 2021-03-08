<?php

class Hook {
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
     * 훅을 실행한다.
     *
     * 하나의 훅 이름에 여러개의 훅 함수가 실행될 수 있다.
     * 주의할 점은, 리턴되는 값은 문자열로, 항상 에러 문자만 리턴된다. 에러가 없으면 공백 문자열이 리턴된다.
     * 만약, 하나의 훅 이름에 여러개의 훅 함수가 실행될 때, 문자열이 리턴되는 것이 있으면 나머지 훅 실행을 멈추고, 에러 문자열을 바로 리턴한다.
     * 따라서, 훅을 사용하는 곳에서는 리턴 되는 값이 에러 문자열인지 항상 확인을 해야 한다.
     *
     * @param string $name - 훅 이름
     * @param mixed ...$vars
     * @return string
     */
    public function run(string $name, mixed &...$vars): string
    {
        if ( isset($this->hooks[$name]) ) {
            foreach( $this->hooks[$name] as $func ) {
                $re = $func(...$vars);
                if ( isError($re) ) return $re;
            }
        }
        return '';
    }

}


/**
 * @return Hook
 */
$__hook = null;
function hook() {
    global $__hook;
    if ( $__hook == null ) $__hook = new Hook();
    return $__hook;
}
