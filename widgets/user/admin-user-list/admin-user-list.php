<?php
$page = in('page', 1) < 1 ? 1 : in('page', 1);
$limit = 15;
$key = in('key');
$where = '1';
if ( $key ) {
    $where = "name LIKE '%$key%' OR nickname LIKE '%$key%' OR email LIKE '%$key%' OR phoneNo LIKE '%$key%'";
}
$users = user()->search(where: $where, order: IDX, by: 'DESC', page: $page, limit: $limit);
$total = user()->count(where:  $where);

?>

<section id="admin-user-list">
    <div class="d-flex justify-content-end">
        <form>
            <input type="hidden" name="p" value="admin.index">
            <input type="hidden" name="w" value="user/admin-user-list">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <input type="text" class="form-control mb-2"
                           name='key' placeholder="사용자 메일 주소, 이름을 입력해주세요."
                           value="<?=$key?>"
                    >
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </div>
            </div>
        </form>
    </div>


    <div class="mb-3">
        <?=ek('No of Users', '검색된 사용자')?>: <?=$total?>
    </div>


    <hr>
    <div class="fs-sm">Display Options:</div>
    <div class="custom-control custom-checkbox custom-control-inline mb-3" v-for="(option, key) in options" :key="key">
        <input type="checkbox" class="custom-control-input" :id="key + '-option'" v-model="options[key]">
        <label class="custom-control-label text-capitalize" :for="key + '-option'">{{key}}</label>
    </div>
    <section class="overflow-auto">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"  v-if="options.email">Email</th>
            <th scope="col"  v-if="options.firebaseUid">firebaseUid</th>
            <th scope="col"  v-if="options.name">Name</th>
            <th scope="col"  v-if="options.nickname">nickname</th>
            <th scope="col"  v-if="options.point">point</th>
            <th scope="col"  v-if="options.point">a-token</th>
            <th scope="col"  v-if="options.point">g-token</th>
            <th scope="col"  v-if="options.phoneNo">Phone No.</th>
            <th scope="col"  v-if="options.gender">gender</th>
            <th scope="col"  v-if="options.birthdate">birthdate</th>
            <th scope="col"  v-if="options.countryCode">countryCode</th>
            <th scope="col"  v-if="options.province">province</th>
            <th scope="col"  v-if="options.city">city</th>
            <th scope="col"  v-if="options.address">address</th>
            <th scope="col"  v-if="options.zipcode">zipcode</th>
            <th scope="col"  v-if="options.createdAt">createdAt</th>
            <th scope="col"  v-if="options.updatedAt">updatedAt</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach( $users as $user) {
            ?>

            <tr>
                <th scope="row"><?=$user->idx?></th>
                <td v-if="options.email"><?=$user->email?></td>
                <td v-if="options.firebaseUid"><?=$user->firebaseUid?></td>
                <td v-if="options.name"><?=$user->name?></td>
                <td v-if="options.nickname"><?=$user->nickname?></td>
                <td v-if="options.point"><?=$user->point?></td>
                <td v-if="options.point"><?=$user->atoken?></td>
                <td v-if="options.point"><?=$user->gtoken?></td>
                <td v-if="options.phoneNo"><?=$user->phoneNo?></td>
                <td v-if="options.gender"><?=$user->gender?></td>
                <td v-if="options.birthdate"><?=$user->birthdate?></td>
                <td v-if="options.countryCode"><?=$user->countryCode?></td>
                <td v-if="options.province"><?=$user->province?></td>
                <td v-if="options.city"><?=$user->city?></td>
                <td v-if="options.address"><?=$user->address?></td>
                <td v-if="options.zipcode"><?=$user->zipcode?></td>
                <td v-if="options.createdAt"><?=$user->createdAt?></td>
                <td v-if="options.updatedAt"><?=$user->updatedAt?></td>
                <td>
                    <a class="btn btn-outline-primary"
                       href="/?p=admin.index&w=user/admin-user-edit&userIdx=<?=$user->idx?>">🖉</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </section>

</section>

<?php
include widget('pagination/pagination-default', [
    'total' => $total,
    'page' => $page,
    'limit' => $limit,
    'url' => "/?p=admin.index&w=user/admin-user-list&page={page}&key=$key"
]);

?>
<script>
    mixins.push({
        data: {
            options: {
                email: true,
                firebaseUid: false,
                name: true,
                nickname: true,
                point: true,
                phoneNo: true,
                gender: false,
                birthdate: false,
                countryCode: false,
                province: false,
                city: false,
                address: false,
                zipcode: false,
                createdAt:  false,
                updatedAt:  false,
            }
        },
    });
</script>

