<?php

class TranslationRoute {
    public function list() {
        return translation()->loadByLanguageCode();
    }

    public function update() {
        return translation()->updateCode(in());
    }
}
