<?php


/**
 * If $default_value is empty, then $code will be returned when the text of $code is empty.
 * @param array|string $code
 * @param mixed $default_value
 * @param bool $translate - if it is set to false, it does not display translation popup.
 *  For text that are used in FORM should not be used since it nests another form.
 *
 * @return string
 *
 * @example
 *  d(ln('code')); // will return the text of the code. if code not exist, then the `code` itself will be returned.
 *  d(ln('code', 'default value')); // if text of the code not exists, `default value` will be returned.
 *  ln(['en' => 'English', 'ko' => 'Korean', 'ch' => '...', ... ]); // If the input is array, then the value of the array for that language will be returned.
 *  ln('users', ln(['en' => 'Users', 'ko' => '사용자'])) // 이 처럼 기본 자체를 언어화 할 수 있다.
 */
function ln(array|string $code, mixed $default_value='', bool $translate=true): string
{
    if ( FIX_LANGUAGE ) $language = FIX_LANGUAGE;
    else $language = get_user_language();

    if ( is_string($code) ) {
        $re = translation()->text($language, $code);
    } else {
        // If $code is array.
        if ( isset($code[ $language ]) ) $re = $code[ $language ]; // User language is set?
        else if ( isset($code[ 'en' ]) ) $re = $code[ 'en' ]; // English is set?
        else $re = serialize($code); // or return string of the code.
    }
    if ( $re ) {
        $ret = $re;
    }
    else if ( $default_value ) {
        $ret = $default_value;
    }
    else {
        $ret = $code;
    }

    if ( is_string($code) && admin() && isTranslationMode() && $translate ) {
        list ($id, $class) = safeCssSelector($code);
        $inputs = '';
        foreach(SUPPORTED_LANGUAGES as $ln) {
            $t = translation()->text($ln, $code);
            $inputs .= "<div>$ln: <input name='$ln' value=\"$t\" autocomplete='off'></div>";
        }
        return <<<EOH
<span id='$id' class="$class" style='background-color: #f6efca; cursor: pointer;'>$ret</span>
<b-popover target="$id" triggers="hover">
    <b>$code</b>
    <form class="form-$class" @submit.prevent="onSubmitTranslate(\$event, '$language', '$code', '$class')" autocomplete="off">
    $inputs
    <button type="submit">Save</button>
</form>
</b-popover>
EOH;
    } else {
        return $ret;
    }
}

/**
 *
 */
$__safeCssSelectorCounter = 0;
function safeCssSelector($code) {
    global $__safeCssSelectorCounter;
    $__safeCssSelectorCounter ++;
    $code = seoFriendlyString($code);
    $code = str_replace(' ', '-', $code);
    return ['tr-' . $code . $__safeCssSelectorCounter, 'tr-' . $code];
}
function isTranslationMode(): bool {
    return isset($_COOKIE['adminTranslate']) && $_COOKIE['adminTranslate'] == 'Y';
}

/**
 * English or Korean
 * @param $en
 * @param $ko
 * @return string
 */
function ek($en, $ko) {
    if ( empty($en) ) return 'English is not set';
    if ( empty($ko) ) return 'Korean is not set';
    return ln(['en' => $en, 'ko' => $ko]);
}

function get_user_language() {
    $language = getAppCookie('language');
    if ( $language ) return $language;
    return browser_language();
}
function browser_language()
{
    if ( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
    else {
        return 'en';
    }
}

