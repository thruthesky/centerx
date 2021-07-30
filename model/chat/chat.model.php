<?php
/**
 * @file file.model.php
 */
/**
 *
 * Class FileModel
 *
 * @property-read string path - file path
 * @property-read string url
 * @property-read string thumbnailUrl
 */
class ChatModel extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(CHAT, $idx);
    }

    public function sendMessage(array $in) {
        $in[USER_IDX] = login()->idx;
        $message = $this->create($in);
        $path = "/chat/{$in[OTHER_USER_IDX]}";

        $db = getRealtimeDatabase();
        $reference = $db->getReference($path);
        $stamp = time();
        $reference->set( $message->response());


    }
}

function chat(int $idx = 0) {
    return new ChatModel($idx);
}

