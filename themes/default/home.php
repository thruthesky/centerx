<?php




?>

<h1>Home</h1>

<?php if ( loggedIn() ) { ?>
    어서오세요, <?=my(NAME)?>님.
<?php } else { ?>
    Please, login first.
<?php } ?>
    <div class="m-5">
        <a class="btn btn-primary" href="/?p=user.register">Register</a>
        <a class="btn btn-primary" href="/?p=user.login">Login</a>
        <a class="btn btn-primary" href="/?p=user.profile">Profile</a>
        <a class="btn btn-primary" href="/?p=user.logout.submit">Logout</a>
        <a class="btn btn-primary" href="/?p=forum.post.list&categoryId=qna">QnA</a>

        <?php if ( admin() ) { ?>
            <a class="btn btn-primary" href="/?p=admin.index">Admin</a>
        <?php } ?>
    </div>

<img src="http://local.itsuda50.com/etc/phpThumb/phpThumb.php?src=67&wl=300&h=300&zc=1&f=jpeg&q=95">
<img src="http://local.itsuda50.com/etc/phpThumb/phpThumb.php?src=/root/files/uploads/learn-24052061920-10.jpg&wl=300&h=300&zc=1&f=jpeg&q=95">
<?php


d(post()->getFromPath());






d( login()->profile() );






