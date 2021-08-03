<?php
/**
 * @file chat-room.model.php
 */
/**
 *
 * Class ChatMessageModel
 *
 */
class ChatRoomModel extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(CHAT_ROOM, $idx);
    }


}

function chatRoom(int $idx = 0): ChatRoomModel {
    return new ChatRoomModel($idx);
}

