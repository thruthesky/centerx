<?php

class E {
    public string $apikey_is_empty = 'error_apikey_is_empty';
    public string $apikey_is_wrong = 'error_apikey_is_wrong';
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
    /**
     * @deprecated
     * @var string
     */
    public string $route_file_not_found = 'error_route_file_not_found';
    public string $route_function_not_found = 'error_route_function_not_found';
    public string $not_logged_in = 'error_not_logged_in';


    public string $controller_file_not_found = 'error_controller_file_not_found';
    public string $controller_method_not_found = 'error_controller_method_not_found';

    public string $blocked = 'error_blocked';


    public string $id_is_empty = 'error_id_is_empty';
    public string $idx_is_empty = 'error_idx_is_empty';
    public string $code_is_empty = 'error_code_is_empty';



    public string $post_not_exists = 'error_post_not_exists';

    // If otherUserIdx is set, the post cannot be edited.
    public string $cannot_be_updated_due_to_other_user_idx = 'error_cannot_be_updated_due_to_other_user_idx';
    // If otherUserIdx is set, only the other user can delete.
    public string $cannot_be_deleted_due_to_wrong_other_user_idx = 'error_cannot_be_deleted_due_to_wrong_other_user_idx';
    public string $comment_not_exists = 'error_comment_not_exists';
    public string $file_not_exists_in_db = 'error_file_not_exists_in_db';
    public string $file_not_exists_in_disk = 'error_file_not_exists_in_disk';
    public string $not_your_post = 'error_not_your_post';

    public string $not_your_comment = 'error_not_your_comment';

    public string $post_delete_not_supported = 'error_post_delete_not_supported';
    public string $comment_delete_not_supported = 'error_comment_delete_not_supported';


    public string $category_exists = 'error_category_exists';
    public string $category_not_exists = 'error_category_not_exists';


    public string $response_is_empty = 'error_response_is_empty';
    public string $malformed_response = 'error_malformed_response';
    public string $entity_not_exists = 'error_entity_not_exists';
    public string $entity_not_found = 'error_entity_not_found';

    public string $category_id_is_empty = 'error_category_id_is_empty';
    public string $empty_category_idx = 'error_empty_category_idx';
    public string $root_idx_is_empty = 'error_root_idx_is_empty';

    public string $entity_deleted_already = 'error_entity_deleted_already';


    public string $file_is_empty = 'error_file_is_empty';
    public string $file_name_is_empty = 'error_file_name_is_empty';
    public string $file_size_is_empty = 'error_file_size_is_empty';
    public string $file_type_is_empty = 'error_file_type_is_empty';
    public string $file_tmp_name_is_empty = 'error_file_tmp_name_is_empty';
    public string $move_uploaded_file_failed = 'error_move_uploaded_file_failed';
    public string $copy_file_failed = 'error_copy_file_failed';

    public string $not_your_file = 'error_not_your_file';
    public string $file_delete_failed = 'error_file_delete_failed';

    public string $not_your_entity = 'error_not_your_entity';

    public string $option_is_empty = 'error_option_is_empty';
    public string $token_is_empty = 'error_token_is_empty';
    public string $tokens_is_empty = 'error_tokens_is_empty';
    public string $topic_is_empty = 'error_topic_is_empty';
    public string $topic_subscription = 'error_topic_subscription';
    public string $users_is_empty = 'error_users_is_empty';
    public string $users_and_emails_is_empty = 'error_users_and_emails_is_empty';
    public string $title_is_not_exist = 'error_title_is_not_exist';
    public string $body_is_not_exist = 'error_body_is_not_exist';
    public string $failed_send_message_to_tokens = 'error_failed_send_message_to_tokens';

    public string $empty_vote_choice = 'error_empty_vote_choice';
    public string $empty_wrong_choice = 'error_empty_wrong_choice';

    public string $hourly_limit = 'error_hourly_limit';
    public string $daily_limit = 'error_daily_limit';

    public string $lack_of_point = 'error_lack_of_point';
    public string $lack_of_point_possession_limit = 'error_lack_of_point_possession_limit';


    public string $point_must_be_0_or_lower_than_0 = 'error_point_must_be_0_or_lower_than_0';
    public string $point_must_be_0_or_bigger_than_0 = 'error_point_must_be_0_or_bigger_than_0';
    public string $point_must_be_bigger_than_0 = 'error_point_must_be_bigger_than_0';
    public string $point_move_for_same_user = 'error_point_move_for_same_user';



    public string $empty_post_idx = 'error_empty_post_idx';
    public string $empty_point = 'error_empty_point';




    public string $order_not_exists = 'error_order_not_exists';
    public string $not_your_order = 'error_not_your_order';
    public string $order_confirmed = 'error_order_confirmed';
    public string $order_not_confirmed = 'error_order_not_confirmed';
    public string $already_reviewed = 'error_already_reviewed';

    public string $code_exists = 'error_code_exists';

    public string $empty_name = 'error_empty_name';

    public string $passlogin_faield = 'error_passlogin_faield';

    public string $meta_update_failed = 'error_meta_update_failed';
    public string $meta_insert_failed = 'error_meta_insert_failed';

    public string $post_path_is_empty = 'error_post_path_is_empty';

    public string $failed_to_add_register_point  ='error_failed_to_add_register_point';

    public string $ids_is_empty = 'error_ids_is_empty';
    public string $you_are_not_admin = 'error_you_are_not_admin';
    public string $this_is_not_your_cafe = 'error_this_is_not_your_cafe';


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



    public string $empty_root_domain = 'error_empty_root_domain';
    public string $empty_country_code = 'error_empty_country_code';
    public string $malformed_country_code = 'error_malformed_country_code';
    public string $empty_domain = 'error_empty_domain';
    public string $domain_too_long = 'error_domain_too_long';
    public string $domain_should_be_alphanumeric_and_start_with_letter = 'error_domain_should_be_alphanumeric_and_start_with_letter';

    // cafe
    public string $cafe_exists = 'error_cafe_exists'; // already created
    public string $cafe_not_exists = 'error_cafe_not_exists'; // not created.
    public string $main_cafe_has_no_cafe_category_record = 'error_main_cafe_has_no_cafe_category_record';


    public string $cafe_main_domain = 'error_cafe_main_domain';


    // advertisement
    public string $advertisement_is_active = 'error_advertisement_is_active';
    public string $advertisement_point_deduction_failed = 'error_advertisement_point_deduction_failed';
    public string $advertisement_point_refund_failed = 'error_advertisement_point_refund_failed';
    public string $begin_date_empty = 'error_begin_date_empty';
    public string $end_date_empty = 'error_end_date_empty';
    public string $maximum_advertising_days = 'error_max_advertising_days';

    public string $wrong_banner_code_or_no_point_setting = 'error_wrong_banner_code_or_no_point_setting';

    public string $empty_top_banner_point = 'error_empty_top_banner_point';
    public string $empty_sidebar_banner_point = 'error_empty_sidebar_banner_point';
    public string $empty_square_banner_point = 'error_empty_square_banner_point';
    public string $empty_line_banner_point = 'error_empty_line_banner_point';
    public string $invalid_value = 'error_invalid_value';

    public string $more_than_90days_date_difference = 'error_more_than_90days_date_difference';

    public string $banner_cancelled = 'error_banner_cancelled';
    public string $banner_expired = 'error_banner_expired';
    public string $banner_stopped = 'error_banner_stopped';


    public string $not_verified = 'error_not_verified';

    public string $block_user_field = "error_block_user_field";

    public string $nickname_is_not_changeable = 'error_nickname_is_not_changeable';

    public string $nickname_exists = 'error_nickname_exists';

    public string $not_localhost = 'error_not_localhost';

    public string $empty_banner_type = 'error_empty_banner_type';


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

/**
 * @param string $err_code
 * @param string $err_message
 * @return string
 */
function err(string $err_code, string $err_message): string {
    return add_error_string($err_code, $err_message);
}
function add_error_string(string $err_code, string $err_message): string {
    return $err_code . '::' . $err_message;
}

/**
 * Return true if
 *  1. the input $obj is an error code and $error_code is empty.
 *  2. the input $obj is an error code and it has same type of error code of the input $error_code.
 *      - for instance, an error code may have an extra information like `error_category_not_exists---xyzBanana`.
 *      - When the object is given with `error_category_not_exists---xyzBanana`, and the $error_code is `error_category_not_exists`.
 *      - Then they are same type of error. it returns true.
 *
 * @param $obj
 * @param $code
 * @return bool
 *
 * @example return true if the input is an error string.
 * ```
 * if ( isError($obj) ) { ... error ... }
 * ```
 * @example return true if the input object is an error and is the same type of $error_code.
 *  - The code below shows how to check error code. both of them has different error code, so it returns false.
 * ```
 * if ( isError('error_user_not_found', 'error_idx_is_empty') ) { }
 * else { ... }
 * ```
 *
 * @example return true if the input $obj and $error_code has same type.
 * ```
 * isTrue(isError('error_category_not_exists---xyzBanana', e()->category_not_exists), "Expected::e()->category_not_exists:: " . e()->category_not_exists);
 * ```
 */
function isError(mixed $obj, string $error_code = ''): bool {


    $_isError = e($obj)->isError;
    if ( $_isError ) {
        if ( $error_code == '' ) return $_isError;
        $arr = explode( ERROR_SEPARATOR, $obj );
        return $arr[0] == $error_code;
    } else {
        return false;
    }


}

function isSuccess($obj) {
    return isError($obj) === false;
}
function isOk($obj) {
    return isSuccess($obj);
}
/**
 * @deprecated
 * @param $obj
 * @return bool
 */
//function isSucess($obj) {
//    return isError($obj) === false;
//}