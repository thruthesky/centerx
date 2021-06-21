<?php

//d(in());
if(modeSubmit()) {
    $in = in();
    unset($in['mode'],$in['p'],$in['w']);

    $in['block'] = $in['block'] ?? '';
    $profile = user(in('idx'))->update($in);

    if($profile->hasError) {
        jsAlert('Edit Failed: ' . $profile->getError());
        $profile = user(in('idx'))->read();
    }
} else {
    if(!(in('userIdx'))) {
        jsAlertGo('userIdx is empty', '/?p=admin.index&w=user/admin-user-list');
    }
    $profile = user(in('userIdx'))->read();
}


?>

<h1>User Edit</h1>
<section id="admin-user-edit">

    <form method="post" action="/" class="text-capitalize">

        <?=hiddens(in: ['p', 'w'], mode: 'submit',kvs: ['idx'=> $profile->idx ])?>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="idx">IDX</label>
                <input data-cy="user-edit-form-idx" type="text" class="form-control" placeholder="IDX" name="idx" id="idx"  value="<?=$profile->idx?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="point"><?=ln('point')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('point')?>" name="point" id="point"  value="<?=$profile->point?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="email"><?=ln('email')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('email')?>" name="email" id="email"  value="<?=$profile->email?>">
            </div>
            <div class="form-group col-6">
                <label for="firebaseUid">firebaseUid</label>
                <input type="text" class="form-control" placeholder="firebaseUid" name="firebaseUid" id="firebaseUid"  value="<?=$profile->firebaseUid?>">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="name"><?=ln('name')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('name')?>" name="name" id="name"  value="<?=$profile->name?>">
            </div>


            <div class="form-group col-6">
                <label for="nickname"><?=ln('nickname')?></label>
                <input data-cy="user-edit-nickname" type="text" class="form-control" placeholder="<?=ln('nickname')?>" name="nickname" id="nickname"  value="<?=$profile->nickname?>">
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-6">
                <label for="phoneNo"><?=ln('phone_no')?></label>
                <input data-cy="user-edit-phone-number" type="text" class="form-control" placeholder="<?=ln('phone_no')?>" name="phoneNo" id="phoneNo"  value="<?=$profile->phoneNo?>">
            </div>

            <div class="form-group col-6">
                <label for="gender"><?=ln('gender')?></label>
                <select data-cy="user-edit-gender-select" class="custom-select" id="gender" name="gender">
                    <option value="" <?=$profile->gender == '' ? 'selected': ''?>><?=ln('select_gender')?></option>
                    <option value="M" <?=$profile->gender == 'M' ? 'selected': ''?>><?=ln('male')?></option>
                    <option value="F" <?=$profile->gender == 'F' ? 'selected': ''?>><?=ln('female')?></option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="birthdate"><?=ln('birthdate')?></label>
                <input type="text" class="form-control" placeholder="YYMMDD" name="birthdate" id="birthdate"  value="<?=$profile->birthdate?>">
            </div>

            <div class="form-group col-6">
                <label for="countryCode"><?=ln('country_code')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('country_code')?>" name="countryCode" id="countryCode" maxlength="2" value="<?=$profile->countryCode?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="province"><?=ln('province')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('province')?>" name="province" id="province"  value="<?=$profile->province?>">
            </div>

            <div class="form-group col-6">
                <label for="city"><?=ln('city')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('city')?>" name="city" id="city"  value="<?=$profile->city?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="address"><?=ln('address')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('address')?>" name="address" id="address"  value="<?=$profile->address?>">
            </div>

            <div class="form-group col-6">
                <label for="zipcode"><?=ln('zipcode')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('zipcode')?>" name="zipcode" id="zipcode"  value="<?=$profile->zipcode?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="createdAt"><?=ln('created_at')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('created_at')?>" name="createdAt" id="createdAt"  value="<?=date('Y/m/d H:i', $profile->createdAt)?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="updatedAt"><?=ln('updated_at')?></label>
                <input type="text" class="form-control" placeholder="<?=ln('updated_at')?>" name="updatedAt" id="updatedAt"  value="<?=date('Y/m/d H:i', $profile->updatedAt)?>" disabled>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="block"><?=ln(['en' => 'Block', 'ko' => '차단'])?></label>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="block" name="block" value="Y" <?=$profile->block == 'Y' ? 'checked' : ''?>>
                    <label class="custom-control-label" for="block"><?=ln(['en' => 'Block user for posting', 'ko' => '사용자 글 쓰기 차단'])?></label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-start mt-2 mb-3">
            <div class=" mr-5">
                <button data-cy="user-edit-submit" type="submit" class="btn btn-primary">
                    <?=ln('save')?>
                </button>
            </div>
            <div>
                <a class="btn btn-outline-secondary"
                   href="/?p=admin.index&w=user/admin-user-list"><?=ln('cancel')?></a>
            </div>
        </div>
    </form>
</section>

