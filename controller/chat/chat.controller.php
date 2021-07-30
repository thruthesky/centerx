<?php

class ChatController {
    public function sendMessage($in) {
        chat()->sendMessage($in);
    }
}

