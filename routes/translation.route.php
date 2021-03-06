<?php

class TranslationRoute {
    public function list() {
        return translation()->loadByLanguageCode();
    }
}
