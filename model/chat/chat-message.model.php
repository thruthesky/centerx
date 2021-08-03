<?php
/**
 * @file chat-message.model.php
 */
/**
 *
 * Class ChatMessageModel
 *
 */
class ChatMessageModel extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(CHAT_MESSAGE, $idx);
    }

    public function sendMessage(array $in): self {
        $in[USER_IDX] = login()->idx;
        $message = $this->create($in);
        rdbSet( "/chat/{$in[OTHER_USER_IDX]}", $message->response() );
        return $this;
    }
}

function chatMessage(int $idx = 0): ChatMessageModel {
    return new ChatMessageModel($idx);
}

