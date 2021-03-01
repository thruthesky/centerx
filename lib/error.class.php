<?php

class E {
    public string $register_failed = 'error_register_failed';
    public string $idx_not_set = 'error_idx_not_set';
    public string $user_not_found_by_that_idx = 'error_user_not_found_by_that_idx';
    public string $user_not_found_by_that_email = 'error_user_not_found_by_that_email';
    public string $wrong_password = 'error_wrong_password';
    public string $empty_password = 'error_empty_password';
    public string $empty_param = 'error_empty_param';
    public string $idx_must_not_set = 'error_idx_must_not_set';
    public string $insert_failed = 'error_insert_failed';
    public string $update_failed = 'error_update_failed';
    public string $email_exists = 'error_email_exists';

    public string $malformed_route = 'error_malformed_route';
    public string $route_file_not_found = 'error_route_file_not_found';
    public string $route_function_not_found = 'error_route_function_not_found';
    public string $not_logged_in = 'error_not_logged_in';


    public bool $isError = false;
    public function __construct(public mixed $errcode=null)
    {
        $this->isError = $this->errcode && is_string($this->errcode) && str_contains($this->errcode, 'error_');
    }
}



/**
 * @return E
 */
function e(mixed $errcode=null): E {
    return new E($errcode);
}

function isError($obj) {
    return e($obj)->isError;
}