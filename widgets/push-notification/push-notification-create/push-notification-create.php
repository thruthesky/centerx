<?php
/**
 * @size wide
 * @options none
 * @dependency none
 */
?>
<h1><?=ln('push notification')?></h1>
<section data-cy="push-notification-create-page">

    <form>
        <?=hiddens(in: ['p', 'w'], mode: 'submit')?>

        <div class="form-group">
            <label for="status"><?=ln('sending option')?></label>
            <select class="custom-select" id="notify" name="notify" v-model="notify">
                <option value="all"><?=ln('all')?></option>
                <option value="topic"><?=ln('topic')?></option>
                <option value="tokens"><?=ln('token')?></option>
            </select>
        </div>
        <div class="form-group" v-if="notify == 'topic'">
            <label for="idx"><?=ln('topic')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('topic')?>" name="topic" id="topic" v-model="topic">
        </div>
        <div class="form-group"v-if="notify == 'tokens'">
            <label for="idx"><?=ln('token')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('token')?>" name="tokens" id="tokens" v-model="tokens">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('landing post idx')?></label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="<?=ln('post idx')?>" name="idx" id="idx"  v-model="idx">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary px-5" type="button" @click="loadPostIdx()"><?=ln('load post idx')?></button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="idx"><?=ln('title')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('title')?>" name="title" id="title" v-model="title">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('content')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('content')?>" name="body" id="body" v-model="body">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('click url')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('click url')?>" name="click_action" id="click_action" v-model="click_action">
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('Icon Url')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('Icon Url')?>" name="imageUrl" id="imageUrl" v-model="imageUrl">
            <small class="form-text text-muted">
                If the post has an image, that image will be used as Icon. or Default image in 'config.php' will be used.
            </small>
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('sound')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('sound')?>" name="sound" id="sound" v-model="sound">
            <div class="text-muted">Make sure to include the file extension. It will not work on IOS if it dont have file extension.</div>
        </div>
        <div class="form-group">
            <label for="idx"><?=ln('channel id')?></label>
            <input type="text" class="form-control" placeholder="<?=ln('channel id')?>" name="channel" id="channel" v-model="channel">
        </div>

        <div class="d-flex justify-content-between mt-2 mb-3">
            <div>
                <button type="button" class="btn btn-primary" @click="sendPushNotification()">
                    <span v-if="!send_notification_loading"><?=ln('send notification')?></span>
                    <span v-if="send_notification_loading"><?=ln('loading')?></span>
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
            imageUrl: "<?=in('imageUrl') ?? PUSH_NOTIFICATION_ICON_URL?>",
            sound: "<?=in('sound', 'telephoneringwav.wav')?>",
            channel: "<?=in('channel', 'PUSH_NOTIFICATION')?>",
            send_notification_loading: false
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
                    app.title = post.title;
                    app.body = post.content;
                    app.click_action = post.url;

                    if(post.files.length > 0) {
                        app.imageUrl = post.files[0].url;
                    }
                }).catch(alert);
            },
            sendPushNotification: function() {
                if (app.send_notification_loading) return;
                app.send_notification_loading = true
                const data = {
                    route: "notification.sendMessageToTopic",
                    title: this.title,
                    body: this.body,
                    sessionId: '<?= login()->sessionId ?>',
                    click_action: this.click_action,
                    imageUrl: this.imageUrl,
                    sound: this.sound,
                    channel: this.channel,
                };
                if (this.idx) {
                    data['data'] = {
                        idx: this.idx,
                        type: "post"
                    }
                }
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
                    app.send_notification_loading = false;
                }).catch( function(e) {
                    app.send_notification_loading = false;
                    alert(e);
                });
            }
        }
    });
</script>

