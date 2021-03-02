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
            <a class="btn btn-primary" href="/?p=admin.user.list">Admin</a>
        <?php } ?>
    </div>


<?php


d(post()->getFromPath());






d( login()->profile() );






