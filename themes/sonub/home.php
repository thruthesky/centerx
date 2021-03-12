<?php




?>

<h1>Sonub Theme</h1>
<hr>
<?php if ( loggedIn() ) { ?>
    어서오세요, <?=login()->name?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>

<?php
d(login()->profile());

$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render ($md);
?>

