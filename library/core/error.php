<?php

class E {
    public string $register_failed = 'error_register_failed';
    public string $idx_not_set = 'error_idx_not_set';
    public string $user_not_found_by_that_idx = 'error_user_not_found_by_that_idx';
    public string $user_not_found = 'error_user_not_found';
    public string $user_not_found_by_that_email = 'error_user_not_found_by_that_email';
    public string $wrong_password = 'error_wrong_password';
    public string $empty_password = 'error_empty_password';
    public string $empty_param = 'error_empty_param';
    public string $wrong_params = 'error_wrong_params';
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

    public string $blocked = 'error_blocked';


    public string $id_is_empty = 'error_id_is_empty';
    public string $idx_is_empty = 'error_idx_is_empty';

    public string $post_not_exists = 'error_post_not_exists';
    public string $comment_not_exists = 'error_comment_not_exists';
    public string $file_not_exists = 'error_file_not_exists';
    public string $not_your_post = 'error_not_your_post';

    public string $not_your_comment = 'error_not_your_comment';

    public string $post_delete_not_supported = 'error_post_delete_not_supported';
    public string $comment_delete_not_supported = 'error_comment_delete_not_supported';


    public string $category_exists = 'error_category_exists';
    public string $category_not_exists = 'error_category_not_exists';


    public string $response_is_empty = 'error_response_is_empty';
    public string $entity_not_exists = 'error_entity_not_exists';
    public string $entity_not_found = 'error_entity_not_found';

    public string $category_id_is_empty = 'error_category_id_is_empty';
    public string $empty_category_idx = 'error_empty_category_idx';
    public string $root_idx_is_empty = 'error_root_idx_is_empty';

    public string $entity_deleted_already = 'error_entity_deleted_already';


    public string $move_uploaded_file_failed = 'error_move_uploaded_file_failed';

    public string $not_your_file = 'error_not_your_file';
    public string $file_delete_failed = 'error_file_delete_failed';

    public string $not_your_entity = 'error_not_your_entity';

    public string $option_is_empty = 'error_option_is_empty';
    public string $token_is_empty = 'error_token_is_empty';
    public string $tokens_is_empty = 'error_tokens_is_empty';
    public string $topic_is_empty = 'error_topic_is_empty';
    public string $topic_subscription = 'error_topic_subscription';
    public string $users_is_empty = 'error_users_is_empty';
    public string $title_is_not_exist = 'error_title_is_not_exist';
    public string $body_is_not_exist = 'error_body_is_not_exist';

    public string $empty_vote_choice = 'error_empty_vote_choice';
    public string $empty_wrong_choice = 'error_empty_wrong_choice';

    public string $hourly_limit = 'error_hourly_limit';
    public string $daily_limit = 'error_daily_limit';

    public string $lack_of_point = 'error_lack_of_point';


    public string $point_must_be_0_or_lower_than_0 = 'error_point_must_be_0_or_lower_than_0';
    public string $point_must_be_bigger_than_0 = 'error_point_must_be_bigger_than_0';
    public string $point_move_for_same_user = 'error_point_move_for_same_user';



    public string $empty_post_idx = 'error_empty_post_idx';
    public string $empty_point = 'error_empty_point';




    public string $order_not_exists = 'error_order_not_exists';
    public string $not_your_order = 'error_not_your_order';
    public string $order_confirmed = 'error_order_confirmed';
    public string $order_not_confirmed = 'error_order_not_confirmed';
    public string $already_reviewed = 'error_already_reviewed';

    public string $empty_code = 'error_empty_code';
    public string $code_exists = 'error_code_exists';

    public string $empty_name = 'error_empty_name';

    public string $passlogin_faield = 'error_passlogin_faield';

    public string $meta_update_failed = 'error_meta_update_failed';
    public string $meta_insert_failed = 'error_meta_insert_failed';

    public string $post_path_is_empty = 'error_post_path_is_empty';

    public string $failed_to_add_register_point  ='error_failed_to_add_register_point';

    public string $ids_is_empty = 'error_ids_is_empty';
    public string $you_are_not_admin = 'error_you_are_not_admin';


    public string $entity_or_code_not_set = 'error_entity_or_code_not_set';


    public string $empty_platform = 'error_empty_platform';
    public string $empty_product_id = 'error_empty_product_id';
    public string $empty_purchase_id = 'error_empty_purchase_id';
    public string $empty_product_price = 'error_empty_product_price';
    public string $empty_product_title = 'error_empty_product_title';
    public string $empty_product_description = 'error_empty_product_description';
    public string $empty_transaction_date = 'error_empty_transaction_date';
    public string $empty_product_identifier = 'error_empty_product_identifier';
    public string $empty_quantity = 'error_empty_quantity';
    public string $empty_transaction_identifier = 'error_empty_transaction_identifier';
    public string $empty_transaction_timestamp = 'error_empty_transaction_timestamp';
    public string $empty_local_verification_data = 'error_empty_local_verification_data';
    public string $empty_server_verification_data = 'error_empty_server_verification_data';
    public string $empty_package_name = 'error_empty_package_name';
    public string $wrong_platform = 'error_wrong_platform';
    public string $verification_failed = 'error_verification_failed';

    public string $receipt_invalid = 'error_receipt_invalid';


    public string $user_cannot_update_point = 'error_user_cannot_update_point';


    /// Geo IP
    public string $geoip_address_not_found = 'error_geoip_address_not_found';
    public string $geoip_invalid_database = 'error_geoip_invalid_database';
    public string $geoip_unknown = 'error_geoip_unknown';

    /// Friend
    public string $cannot_add_oneself_as_friend = 'error_cannot_add_oneself_as_friend';
    public string $already_added_as_friend = 'error_already_added_as_friend';
    public string $not_added_as_friend = 'error_not_added_as_friend';
    public string $already_blocked = 'error_already_blocked';
    public string $not_blocked = 'error_not_blocked';
    public string $no_relationship = 'error_no_relationship';



    public string $wrong_activity = 'error_wrong_activity';
    public string $user_activity_record_action_to_user_idx_is_empty = 'error_user_activity_record_action_to_user_idx_is_empty';







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

/**
 * @deprecated
 * @param $obj
 * @return bool
 */
//function isSucess($obj) {
//    return isError($obj) === false;
//}