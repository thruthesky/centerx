<?php





?>

<h1>Sonub Theme</h1>
<hr>
<?php if ( loggedIn() ) { ?>
    어서오세요, <?=login()->name ? login()->name : '이름 없음'?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>

<hr>
themes/sonub/README.md 파일
<?php
$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render ($md);
?>

