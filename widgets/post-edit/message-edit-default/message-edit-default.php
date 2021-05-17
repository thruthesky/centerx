<?php
/**
 * @name Message Edit - Default Widget
 */

translate('input_title', [
    'en' => 'Input message title.',
    'ko' => '쪽지 제목을 입력하세요.',

]);
translate('input_content', [
    'en' => 'Input message content.',
    'ko' => '쪽지 내용을 입력하세요.',
]);

hook()->add('post-edit-title', function() {
    return '쪽지 전송';
});
include widget('post-edit/post-edit-default');

