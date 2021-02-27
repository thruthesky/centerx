<?php

class E {
    public string $register_failed = 'error_register_failed';
    public string $idx_not_set = 'error_idx_not_set';
    public string $user_not_found_by_that_idx = 'error_user_not_found_by_that_idx';
    public string $user_not_found_by_that_email = 'error_user_not_found_by_that_email';
    public string $wrong_password = 'error_wrong_password';

    public bool $isError = false;
    public function __construct(public mixed $errcode=null)
    {
        $this->isError = $this->errcode && is_string($this->errcode) && str_contains($this->errcode, 'error_');
    }
}



/**
 * @return E
 */
function error(mixed $errcode=null): E {
    return new E($errcode);
}