<?php
/**
 * @size wide
 * @options none
 * @dependency must be admin
 */

include_once ROOT_DIR . 'routes/notification.route.php';

//if(modeSubmit()) {
//    $push = new NotificationRoute();
//
//    $in = in();
//    $res = null;
//    if (in('notify') == 'all' ) {
//        $in[TOPIC] = DEFAULT_TOPIC;
//        $res = $push->sendMessageToTopic($in);
//    } else if (in('notify') == 'topic' ) {
//        if(!isset($in[TOPIC]) || empty($in[TOPIC])) {
//            jsAlert("Topic is empty");
//        } else {
//            $res = $push->sendMessageToTopic($in);
//        }
//    } else if (in('notify') == 'tokens' ) {
//        if(!isset($in[TOKENS]) || empty($in[TOKENS])) {
//            jsAlert("Token/s is empty");
//        } else {
//            $res = $push->sendMessageToTokens($in);
//        }
//    }
//
////    d($res);
//
//    if ($res) {
//
//        if( in('notify') === 'tokens') {
//            if (count($res['success']) > 0) {
//                jsAlert('Success Sending push notification to tokens.');
//            } else if (count($res['error']) > 0){
//                jsAlert('Error Sending push notification to tokens. ' . $res['error'][0]);
//            } else {
//                jsAlert('Api Error on sending to tokens.');
//            }
//        } else {
//            jsAlert('Success Sending push notification to topic.');
//        }
//
//    }
//}


?>
<h1><?=ln('Push Notification', '푸시 알림')?></h1>
<section data-cy="push-notification-create-page">

    <form>
        <?=hiddens(in: ['p', 'w'], mode: 'submit')?>

        <div class="form-group">
            <label for="status"><?=ln('Mode', '방법')?></label>
            <select class="custom-select" id="notify" name="notify" v-model="notify">
                <option value="all"><?=ln('All', '모두')?></option>
                <option value="topic"><?=ln('Topic', '대체론')?></option>
                <option value="tokens"><?=ln('Tokens', '토큰')?></option>
            </select>
        </div>
        <div class="form-group" v-if="notify == 'topic'">
            <label for="idx"><?=ln('Topic', '대체론')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Topic', '대체론')?>" name="topic" id="topic" v-model="topic">
        </div>
        <div class="form-group"v-if="notify == 'tokens'">
            <label for="idx"><?=ln('Tokens', '토큰')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Tokens', '토큰')?>" name="tokens" id="tokens" v-model="tokens">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Landing Post idx', '랜딩 포스트 IDX')?></label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="<?=ln('Post idx', 'Idx 게시')?>" name="idx" id="idx"  v-model="idx">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary px-5" type="button" @click="loadPostIdx()"><?=ln('Load Post Idx', '포스트 Idx로드')?></button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="idx"><?=ln('Title', '표제')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Title', '표제')?>" name="title" id="title" v-model="title">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Content', '함유량')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Content', '함유량')?>" name="body" id="body" v-model="body">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Click Url', '클릭 URL')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Click Url', '클릭 URL')?>" name="click_action" id="click_action" v-model="click_action">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Image Url', '이미지 URL')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Image Url', '이미지 URL')?>" name="imageUrl" id="imageUrl" v-model="imageUrl">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Sound', '소리')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Sound', '소리')?>" name="sound" id="sound" v-model="sound">
            <div class="text-muted">Make sure to include the file extension. It will not work on IOS if it dont have file extension.</div>
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Channel Id', '채널 ID')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Channel Id', '채널 ID')?>" name="channel" id="channel" v-model="channel">
        </div>

        <div class="d-flex justify-content-between mt-2 mb-3">
            <div>
<!--                <button type="submit" class="btn btn-primary mr-5">-->
<!--                    --><?//=ln('Send Notification php', '알림 보내기')?>
<!--                </button>-->
                <button type="button" class="btn btn-primary" @click="sendPushNotification()">
                    <?=ln('Send Notification vue', '알림 보내기')?>
                </button>
            </div>
        </div>
    </form>

</section>


<script>
    mixins.push({
        data: {
            idx: "<?=in('idx', '')?>",
            notify: "<?=in('notify', 'all')?>",
            topic: "<?=in('topic', '')?>",
            tokens: "<?=in('tokens', '')?>",
            title: "<?=in('title')?>",
            body: "<?=in('body')?>",
            click_action: "<?=in('click_action')?>",
            imageUrl: "<?=in('imageUrl')?>",
            sound: "<?=in('sound', 'telephoneringwav.wav')?>",
            channel: "<?=in('channel', 'PUSH_NOTIFICATION')?>",
        },
        created: function (){
            console.log('created');
            this.loadPostIdx();
        },
        methods: {
            loadPostIdx: function() {
                console.log(this.idx);
                if (this.idx === '') return;
                axios.post('/index.php', {
                    sessionId: '<?= login()->sessionId ?>',
                    route: 'post.get',
                    idx: this.idx,
                }).then(function(res) {
                    console.log(res);
                    let post = res.data.response;
                    app.$data.title = post.title;
                    app.$data.body = post.content;
                    app.$data.click_action = post.url;

                    if(post.files.length > 0) {
                        app.$data.imageUrl = post.files[0].url;
                    }
                }).catch(alert);
            },
            sendPushNotification: function() {
                const data = {
                    route: "notification.sendMessageToTopic",
                    title: this.title,
                    body: this.body,
                    idx: this.idx,
                    sessionId: '<?= login()->sessionId ?>',
                    click_action: this.click_action,
                    imageUrl: this.imageUrl,
                    sound: this.sound,
                    channel: this.channel,
                };
                if (this.notify === 'all' ) {
                    data['topic'] = "<?=DEFAULT_TOPIC?>";
                } else if (this.notify === 'topic' ) {
                    data['topic'] = this.topic;
                } else if (this.notify === 'tokens' ) {
                    data['route'] = "notification.sendMessageToTokens";
                    data['tokens'] = this.tokens;
                }
                axios.post('/index.php', data).then(function(res) {
                    console.log(res);
                    console.log(res.data.response);
                    if( app.$data.notify === 'tokens') {
                        if (res.data.response['success'].length > 0) {
                            alert('Success Sending push notification to tokens.')
                        } else if (res.data.response['error'].length > 0){
                            alert('Error Sending push notification to tokens. ' + res.data.response['error'][0])
                        } else {
                            alert('Api Error on sending to tokens.')
                        }
                    } else {
                        alert('Success Sending push notification to topic.')
                    }

                }).catch(alert);


            }
        }
    });
</script>

