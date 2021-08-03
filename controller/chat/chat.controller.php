<?php

class ChatController {
    public function sendMessage($in) {

        if ( !isset($in[OTHER_USER_IDX]) ) e()->empty_other_user_idx;

        return chatMessage()->sendMessage($in)->response();
    }
}

