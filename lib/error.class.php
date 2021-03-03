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
    public string $delete_failed = 'error_delete_failed';
    public string $email_exists = 'error_email_exists';
    public string $email_is_empty = 'error_email_is_empty';
    public string $password_is_empty = 'error_password_is_empty';
    public string $malformed_email = 'error_malformed_email';
    public string $wrong_session_id = 'error_wrong_session_id';
    public string $user_not_found_by_that_session_id = 'error_user_not_found_by_that_session_id';


    public string $malformed_route = 'error_malformed_route';
    public string $route_file_not_found = 'error_route_file_not_found';
    public string $route_function_not_found = 'error_route_function_not_found';
    public string $not_logged_in = 'error_not_logged_in';

    public string $id_is_empty = 'error_id_is_empty';
    public string $idx_is_empty = 'error_idx_is_empty';

    public string $post_not_exists = 'error_post_not_exists';
    public string $comment_not_exists = 'error_comment_not_exists';
    public string $file_not_exists = 'error_file_not_exists';
    public string $not_your_post = 'error_not_your_post';

    public string $not_your_comment = 'error_not_your_comment';

    public string $category_exists = 'error_category_exists';
    public string $category_not_exists = 'error_category_not_exists';


    public string $response_is_empty = 'error_response_is_empty';
    public string $entity_not_exists = 'error_entity_not_exists';

    public string $category_id_is_empty = 'error_category_id_is_empty';
    public string $root_idx_is_empty = 'error_root_idx_is_empty';

    public string $entity_deleted_already = 'error_entity_deleted_already';


    public string $move_uploaded_file_failed = 'error_move_uploaded_file_failed';

    public string $not_your_file = 'error_not_your_file';
    public string $file_delete_failed = 'error_file_delete_failed';


    public string $token_is_empty = 'error_token_is_empty';
    public string $topic_is_empty = 'error_topic_is_empty';
    public string $topic_subscription = 'error_topic_subscription';
    public string $users_is_empty = 'error_users_is_empty';
    public string $title_is_not_exist = 'error_title_is_not_exist';
    public string $body_is_not_exist = 'error_body_is_not_exist';



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
function isSucess($obj) {
    return isError($obj) === false;
}