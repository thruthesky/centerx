<?php

include_once ROOT_DIR . 'routes/notification.route.php';
//d(in());

if(modeSubmit()) {
//    d(in());
    $push = new NotificationRoute();

    $in = in();
    if (in('notify') == 'all' ) {
        $in[TOPIC] = DEFAULT_TOPIC;
        $res = $push->sendMessageToTopic($in);
    } else if (in('notify') == 'topic' ) {
        $res = $push->sendMessageToTopic($in);
    } else if (in('notify') == 'tokens' ) {
        $res = $push->sendMessageToTokens($in);
    }

    d($res);

//    if (is_string($res)) jsAlert("Error::" . $res);
//    else jsAlert('Send Success');
}


?>
<h1><?=ek('Push Notification', '@t push notification')?></h1>
<section id="push-notification-create">

    <form>
        <?=hiddens(in: ['p', 'w'], mode: 'submit')?>

        <div class="form-group">
            <label for="status">Mode</label>
            <select class="custom-select" id="notify" name="notify" v-model="notify">
                <option value="all">All</option>
                <option value="topic">Topic</option>
                <option value="tokens">Token</option>
            </select>
        </div>
        <div class="form-group" v-if="notify == 'topic'">
            <label for="idx">Topic</label>
            <input type="text" class="form-control" placeholder="topic" name="topic" id="topic" value="<?=in('topic')?>">
        </div>
        <div class="form-group"v-if="notify == 'tokens'">
            <label for="idx">Tokens</label>
            <input type="text" class="form-control" placeholder="tokens" name="tokens" id="tokens" value="<?=in('tokens')?>">
        </div>
        <div class="form-group">
            <label for="idx">Landing Post idx</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="idx" name="idx" id="idx"  v-model="idx">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary px-5" type="button" @click="loadPostIdx()">Load Post Idx</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="idx">Title</label>
            <input type="text" class="form-control" placeholder="Title" name="title" id="title" value="<?=in('title')?>">
        </div>
        <div class="form-group">
            <label for="idx">Body</label>
            <input type="text" class="form-control" placeholder="Content" name="body" id="body" value="<?=in('body')?>">
        </div>

        <div class="d-flex justify-content-between mt-2 mb-3">
            <div>
                <button type="submit" class="btn btn-primary">
                    Send Notification
                </button>
            </div>
        </div>
    </form>

</section>


<script>
    mixins.push({
        data: {
            idx: "<?=in('idx')?>",
            notify: "<?=in('notify', 'all')?>"
        },
        methods: {
            loadPostIdx() {
                console.log(this.idx);
            }
        }
    });
</script>

