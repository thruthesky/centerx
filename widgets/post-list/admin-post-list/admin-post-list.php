<?php
/**
 * @type admin
 */


foreach( post()->search() as $post ) {
?>
    <div>
        <?=$post->title?>
    </div>
<?php
}