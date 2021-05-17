<?php
/**
 * @size icon
 * @options ...
 * @dependency vue.js 2.x.x
 */
?>
<div @click="forumNotification()">Notify <i class="fa fa-bell"></i></div>

<script>
    mixins.push({
        data: {},
        methods: {
            forumNotification: function() {
                console.log("subscribe or unsubscribe")
            }
        }
    });
</script>
