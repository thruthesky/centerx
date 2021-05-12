<?php
$page = in('page', 1) < 1 ? 1 : in('page', 1);
$limit = 15;
$key = in('key');
$where = '1';
if ($key) {
    $where = "name LIKE '%?%' OR nickname LIKE '%?%' OR email LIKE '%?%' OR phoneNo LIKE '%?%'";
    $users = user()->search(where: $where, params: [$key, $key, $key, $key], page: $page, limit: $limit, object: true);
} else {
    $users = user()->search(page: $page, limit: $limit, object: true);
}
$total = user()->count();
?>

<section data-cy="admin-user-list-page">
    <div class="d-flex justify-content-end mb-3">
        <div class="mt-2 fw-700">
            <?= ek('No of Users', '검색된 사용자') ?>: <?= $total ?>
        </div>

        <span class="flex-grow-1"></span>

        <form>
            <input type="hidden" name="p" value="admin.index">
            <input type="hidden" name="w" value="user/admin-user-list">
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <input type="text" class="form-control mb-2" name='key' placeholder="사용자 메일 주소, 이름을 입력해주세요." value="<?= $key ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2"><?= ek('Submit', '@T Submit') ?></button>
                </div>
            </div>
        </form>
    </div>


    <div class="p-1 mb-3 border-radius-sm" style="border: 1px solid #e8e8e8;">
        <div class="m-2"><?= ek('Fields', '@T Fields') ?></div>
        <div class="custom-control custom-checkbox custom-control-inline m-2 fs-sm align-middle" v-for="(option, key) in options" :key="key">
            <input :data-cy="key + '-option'" type="checkbox" class="custom-control-input" :id="key + '-option'" v-model="options[key]">
            <label class="custom-control-label text-capitalize" :for="key + '-option'">{{key}}</label>
        </div>
    </div>

    <section class="overflow-auto">
        <table class="table table-striped fs-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="align-middle" scope="col">#</th>
                    <th class="align-middle" data-cy="firebaseUid-col-header" scope="col" v-if="options.email"><?= ek('Email', '@T Email') ?></th>
                    <th class="align-middle" scope="col" v-if="options.firebaseUid"><?= ek('Firebase UID', '@T Firebase UID') ?></th>
                    <th class="align-middle" scope="col" v-if="options.name"><?= ek('Name', '@T Name') ?></th>
                    <th class="align-middle" scope="col" v-if="options.nickname"><?= ek('Nickname', '@T Nickname') ?></th>
                    <th class="align-middle" scope="col" v-if="options.point"><?= ek('Point', '@T Point') ?></th>
                    <th class="align-middle" scope="col" v-if="options.phoneNo"><?= ek('Phone No.', '@T Phone No.') ?></th>
                    <th class="align-middle" data-cy="gender-col-header" scope="col" v-if="options.gender"><?= ek('Gender', '@T Gender') ?></th>
                    <th class="align-middle" scope="col" v-if="options.birthdate"><?= ek('Birthdate', '@T Birthdate') ?></th>
                    <th class="align-middle" scope="col" v-if="options.countryCode"><?= ek('Country Code', '@T Country Code') ?></th>
                    <th class="align-middle" scope="col" v-if="options.province"><?= ek('Province', '@T Province') ?></th>
                    <th class="align-middle" scope="col" v-if="options.city"><?= ek('City', '@T City') ?></th>
                    <th class="align-middle" scope="col" v-if="options.address"><?= ek('Address', '@T Address') ?></th>
                    <th class="align-middle" scope="col" v-if="options.zipcode"><?= ek('Zipcode', '@T Zipcode') ?></th>
                    <th class="align-middle" scope="col" v-if="options.createdAt"><?= ek('Created At', '@T Created At') ?></th>
                    <th class="align-middle" scope="col" v-if="options.updatedAt"><?= ek('Updated At', '@T Updated At') ?></th>
                    <th class="align-middle" scope="col"><?= ek('Edit', '@T Edit') ?></th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($users as $user) {
                ?>

                    <tr>
                        <th scope="row"><?= $user->idx ?></th>
                        <td v-if="options.email"><?= $user->email ?></td>
                        <td v-if="options.firebaseUid"><?= $user->firebaseUid ?></td>
                        <td v-if="options.name"><?= $user->name ?></td>
                        <td v-if="options.nickname"><?= $user->nickname ?></td>
                        <td v-if="options.point"><?= $user->point ?></td>
                        <td v-if="options.phoneNo"><?= $user->phoneNo ?></td>
                        <td v-if="options.gender"><?= $user->gender ?></td>
                        <td v-if="options.birthdate"><?= $user->birthdate ?></td>
                        <td v-if="options.countryCode"><?= $user->countryCode ?></td>
                        <td v-if="options.province"><?= $user->province ?></td>
                        <td v-if="options.city"><?= $user->city ?></td>
                        <td v-if="options.address"><?= $user->address ?></td>
                        <td v-if="options.zipcode"><?= $user->zipcode ?></td>
                        <td v-if="options.createdAt"><?= $user->createdAt ?></td>
                        <td v-if="options.updatedAt"><?= $user->updatedAt ?></td>
                        <td>
                            <a data-cy="user-info-edit-button" class="btn btn-sm btn-outline-primary" href="/?p=admin.index&w=user/admin-user-edit&userIdx=<?= $user->idx ?>">📝</a>
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
                createdAt: false,
                updatedAt: false,
            }
        },
    });
</script>