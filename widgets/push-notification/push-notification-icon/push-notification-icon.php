<?php
/**
 * @size icon
 * @options category
 * @dependency vue.js 2.x.x
 */

$o = getWidgetOptions();
$category = $o['category'];

$post_topic = NOTIFY_POST . $category->id;
$comment_topic = NOTIFY_COMMENT . $category->id;

function isSubscribedToTopic($topic): bool
{
    return login()->v($topic) === "on";
}
?>
<div class="push-notification-icon">
    <b-form-checkbox v-model="notifyPost" name="check-button" switch @change="onChangeSubscribeOrUnsubscribeTopic('<?= $post_topic ?>', 'notifyPost')">
        New Post
    </b-form-checkbox>
    <b-form-checkbox v-model="notifyComment" name="check-button" switch @change="onChangeSubscribeOrUnsubscribeTopic('<?= $comment_topic ?>', 'notifyComment')">
        New Comment
    </b-form-checkbox>
</div>
<script>
    mixins.push({
        data: {
            notifyPost: <?=isSubscribedToTopic($post_topic) ? 'true' : 'false' ?>,
            notifyComment: <?=isSubscribedToTopic($comment_topic) ? 'true' : 'false' ?>
        },
        methods: {
            onChangeSubscribeOrUnsubscribeTopic: function(topic, field) {
                // console.log(topic, field);
                // console.log(app.$data[field]);

                if ( !Cookies.get('sessionId') ) {
                    alert("Please login first");
                    app.$data[field] = false;
                    return;
                }
                console.log(Cookies.get('sessionId'));
                request(
                    "notification.topicSubscription",
                    { topic: topic, subscribe: field ? "on" : "off" },
                    function (res) {
                        console.log("request",res);
                        // this.$data.user[topic] = mode ? "Y" : "N";
                    },
                    this.error
                );
            },
        }
    });
</script>

<style>
    .push-notification-icon {
        display: flex;
    }
    .push-notification-icon > div {
        margin-right: 0.5em;
    }
</style>
