<?php
$page = in('page', 1) < 1 ? 1 : in('page', 1);
$limit = 15;
$key = in('key');
$where = '1';
if ( $key ) {
    $where = "name LIKE '%$key%' OR email LIKE '%$key%' OR phoneNo LIKE '%$key%'";
}
$users = user()->search(where: $where, order: IDX, by: 'DESC', page: $page, limit: $limit);
$total = user()->count(where:  $where);

?>
<h1>Admin User List</h1>

<section class="mx-5">

    <form>
        <input type="hidden" name="p" value="admin.index">
        <input type="hidden" name="w" value="user/admin-user-list">
        <div class="form-row align-items-center">
            <div class="col-auto">
                <input type="text" class="form-control mb-2" name='key' placeholder="사용자 메일 주소, 이름을 입력해주세요.">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </div>
        </div>
    </form>
</section>


검색된 사용자: <?=$total?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Email</th>
        <th scope="col">Name</th>
        <th scope="col">Phone No.</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach( $users as $user) {
        ?>

        <tr>
            <th scope="row"><?=$user->idx?></th>
            <td><?=$user->email?></td>
            <td><?=$user->name?></td>
            <td><?=$user->phoneNo?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
include widget('pagination/pagination-default', [
        'total' => $total,
    'page' => $page,
    'limit' => $limit,
    'url' => "/?p=admin.index&w=user/admin-user-list&page={page}&key=$key"
]);
