<?php
include theme()->file('cafe.admin.menu');

d(cafe()->domain);

$postIdx = !empty(in('postIdx')) ? in('postIdx') : 0;
$post = post($postIdx);

$title = in('title', '');
$body = in('body', '');

if($post->exists()) {
    $title = $post->title;
    $body = $post->content;
}



if(modeSubmit()) {
    $click_action = '/' ;
    $data = [];
    if($post->exists) {
        $click_action = $post->url;
        $data = [
            'type' => 'post',
            'postIdx' => $post->idx
        ];
    }

    $image_url = cafe()->appIcon()->url ?? '';

    $req = [
        TITLE =>in('title', ''),
        BODY =>in('body', ''),
        CLICK_ACTION => $click_action,
        DATA => $data,
        IMAGE_URL => $image_url
    ];
    $res = sendMessageToTopic(cafe()->id, $req);

    if($res['name']) {
        jsAlert("Sending Push Notification Success");
    }
}



?>

<ul>
    <li>

        <?php
        $count = cafe()->countTokens();
        ?>
        There are <?=$count?> tokens for the cafe.
    </li>
    <li>
        To send a message, you can input title and body. Then, submit.
        <ul>
            <li>User will land on the cafe main page.</li>
        </ul>
    </li>
    <li>
        If you send the message with a post, then users will land on the post view page.
    </li>

    <ul>
        <li>To select a post, click 'push message' button on post view page.</li>
    </ul>
</ul>


<form>
    <?=hiddens(mode: 'submit', kvs: ['postIdx'=>in('postIdx'), 'p' => 'cafe.admin.message'])?>
    <div class="form-group">
        <label for="titleBox">Message Title</label>
        <input type="text" class="form-control" id="titleBox" name="title" aria-describedby="input title" value="<?=$title??''?>">
        <small id="titleHelp" class="form-text text-muted">Input title in 20 letters</small>
    </div>
    <div class="form-group">
        <label for="bodyBox">Message Body</label>
        <input type="text" class="form-control" id="bodyBox" name="body" value="<?=$body??''?>">
        <small id="bodyHelp" class="form-text text-muted">Input body in 20 letters</small>
    </div>


    <div class="form-group d-flex justify-content-end">
        <button class="btn btn-primary" type="submit">Send</button>
    </div>
</form>
