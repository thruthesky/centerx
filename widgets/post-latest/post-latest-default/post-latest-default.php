<?php

$posts = post()->latest(limit: 50);


foreach($posts as $post) {
    ?>
    <a href="<?=$post['url']?>"><?=$post[TITLE]?></a>
<?php
}
