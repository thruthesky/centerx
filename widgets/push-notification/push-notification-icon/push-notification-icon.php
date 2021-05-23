<?php
/**
 * @size icon
 * @options string `topic`, string `label`
 * @dependency none
 * @description it will display if the user is subscribe to the given topic and by clicking the icon it will subscribe or unsubscribe to topic
 */

$o = getWidgetOptions();
$__topic = $o['topic'] ?? "widgetDefaultTopic";
$__label = $o['label'] ?? "";
$__topicData = 'push_icon_' . $__topic;
?>
<div class="push-notification-icon">
    <b-form-checkbox v-model="$data['<?=$__topicData?>']" name="check-button" switch @change="onChangeSubscribeOrUnsubscribeTopic('<?= $__topic ?>')">
        <?=$__label?>
    </b-form-checkbox>
</div>
<script>
    mixins.push({
        data: {
            '<?=$__topicData?>': <?=isSubscribedToTopic($__topic) ? 'true' : 'false' ?>,
        },
        methods: {
            onChangeSubscribeOrUnsubscribeTopic: function(topic) {
                if ( notLoggedIn() ) {
                    alert("Please login first");
                    app.$data['<?=$__topicData?>'] = false;
                    return;
                }
                request(
                    "notification.topicSubscription",
                    { topic: topic, subscribe: app.$data['<?=$__topicData?>'] ? "on" : "off" },
                    function (res) {
                        console.log("request",res);
                    },
                    alert
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
