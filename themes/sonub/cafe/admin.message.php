<?php
include theme()->file('cafe.admin.menu');

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
    @todo if post is selected, then, display original post author, title, content, and input it onto title box and content box.
    <div class="form-group">
        <label for="titleBox">Message Title</label>
        <input type="text" class="form-control" id="titleBox" aria-describedby="input title">
        <small id="titleHelp" class="form-text text-muted">Input title in 20 letters</small>
    </div>
    <div class="form-group">
        <label for="bodyBox">Message Body</label>
        <input type="text" class="form-control" id="bodyBox">
        <small id="bodyHelp" class="form-text text-muted">Input body in 20 letters</small>
    </div>


    <div class="form-group d-flex justify-content-end">
        <button class="btn btn-primary" type="submit">Send</button>
    </div>
</form>
