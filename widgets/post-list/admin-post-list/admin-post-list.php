<?php



foreach( post()->search() as $post ) {
?>
    <div>
        <?=$post[TITLE]?>
    </div>
<?php
}