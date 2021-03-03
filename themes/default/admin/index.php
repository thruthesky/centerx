<?php

?>
<h1>Admin Page</h1>
<a href="/?p=admin.index&w=user/admin-user-list">User</a>
<a href="/?p=admin.index&w=category/admin-category-list">Category</a>
<a href="/?p=admin.index&w=category/admin-post-list">Posts</a>
<a href="/?p=admin.user.list">Mall</a>
<hr>
<?php
include widget(in('w') ?? 'user/admin-user-list');

