<?php
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
