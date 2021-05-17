<?php
$o = getWidgetOptions();
$category = $o['category'];

$post_topic = NOTIFY_POST . $category->id;
$comment_topic = NOTIFY_COMMENT . $category->id;

function isSubscribedToTopic($topic): bool
{
    return login()->v($topic) === "Y";
}
?>
<template>
    <div>
        <b-form-checkbox v-model="checked" name="check-button" switch @change="onChangeSubscribeOrUnsubscribeTopic('<?= $post_topic ?>')">
            Get Notified
        </b-form-checkbox>
    </div>
</template>
<script>


    mixins.push({
        data: {
            checked: <?=isSubscribedToTopic($post_topic) ? 'true' : "false" ?>
        },
        methods: {
            onChangeSubscribeOrUnsubscribeTopic: function(topic) {
                console.log(app.checked);
                if ( !Cookies.get('sessionId') ) {
                    alert("Please login first");
                    app.checked = false;
                    return;
                }

                request(
                    "notification.topicSubscription",
                    { topic: topic, subscribe: app.checked ? "Y" : "N" },
                    function (res) {
                        // this.$data.user[topic] = mode ? "Y" : "N";
                    },
                    this.error
                );
            },
        }
    });
</script>
