<?php
/**
 * @file translation.controller.php
 */

/**
 * Class TranslationController
 */
class TranslationController {

    public function load() {
        return translation()->load();
    }

    public function list() {
        return translation()->loadByLanguageCode();
    }

    public function update($in) {
        $re = translation()->updateCode($in);
        if ( isError($re) ) return $re;
        else {
            rdbSet('/notifications/translations', ['time' => time()]);
            return $re;
        }
    }

    public function delete($in) {
        rdbSet('/notifications/translations', ['time' => time()]);
        return translation()->deleteCode($in);
    }

    /**
     * @see readme
     * @param $in
     * @return array
     */
    public function get($in) {
        $text = translation()->text(get_user_language(), $in['code']);
        return ['ln' => get_user_language(), 'code' => $in['code'], 'text' => $text];
    }
}
