<?php
/**
 * @file translation.controller.php
 */

/**
 * Class TranslationController
 */
class TranslationController {
    public function list() {
        return translation()->loadByLanguageCode();
    }

    public function update() {
        return translation()->updateCode(in());
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
