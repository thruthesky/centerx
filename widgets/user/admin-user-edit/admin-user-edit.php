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
                <input type="text" class="form-control" placeholder="IDX" name="idx" id="idx"  value="<?=$profile->idx?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="point"><?=ek('Point', '포인트')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Point', '포인트')?>" name="point" id="point"  value="<?=$profile->point?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="email"><?=ek('Email', '이메일')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Email', '이메일')?>" name="email" id="email"  value="<?=$profile->email?>">
            </div>
            <div class="form-group col-6">
                <label for="firebaseUid">firebaseUid</label>
                <input type="text" class="form-control" placeholder="firebaseUid" name="firebaseUid" id="firebaseUid"  value="<?=$profile->firebaseUid?>">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="name"><?=ek('Name', '이름')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Name', '이름')?>" name="name" id="name"  value="<?=$profile->name?>">
            </div>


            <div class="form-group col-6">
                <label for="nickname"><?=ek('Nickname', '별명')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Nickname', '별명')?>" name="nickname" id="nickname"  value="<?=$profile->nickname?>">
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-6">
                <label for="phoneNo"><?=ek('Phone Number', '전화 번호')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Phone Number', '전화 번호')?>" name="phoneNo" id="phoneNo"  value="<?=$profile->phoneNo?>">
            </div>

            <div class="form-group col-6">
                <label for="gender"><?=ek('Gender', '성별')?></label>
                <select class="custom-select" id="gender" name="gender">
                    <option value="" <?=$profile->gender == '' ? 'selected': ''?>><?=ek('Select Gender', '성별을 선택하세요')?></option>
                    <option value="M" <?=$profile->gender == 'M' ? 'selected': ''?>><?=ek('Male', '남성')?></option>
                    <option value="F" <?=$profile->gender == 'F' ? 'selected': ''?>><?=ek('Female', '여자')?></option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="birthdate"><?=ek('Birth Date', '생일')?></label>
                <input type="text" class="form-control" placeholder="YYMMDD" name="birthdate" id="birthdate"  value="<?=$profile->birthdate?>">
            </div>

            <div class="form-group col-6">
                <label for="countryCode"><?=ek('Country Code', '국가 코드')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Country Code', '국가 코드')?>" name="countryCode" id="countryCode" maxlength="2" value="<?=$profile->countryCode?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="province"><?=ek('Province', '지방')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Province', '지방')?>" name="province" id="province"  value="<?=$profile->province?>">
            </div>

            <div class="form-group col-6">
                <label for="city"><?=ek('City', '시티')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('City', '시티')?>" name="city" id="city"  value="<?=$profile->city?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="address"><?=ek('Address', '주소')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Address', '주소')?>" name="address" id="address"  value="<?=$profile->address?>">
            </div>

            <div class="form-group col-6">
                <label for="zipcode"><?=ek('Zipcode', '우편 번호')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Zipcode', '우편 번호')?>" name="zipcode" id="zipcode"  value="<?=$profile->zipcode?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="createdAt"><?=ek('Created at', '만든 날짜')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Created at', '만든 날짜')?>" name="createdAt" id="createdAt"  value="<?=date('Y/m/d H:i', $profile->createdAt)?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="updatedAt"><?=ek('Updated At', '업데이트 날짜')?></label>
                <input type="text" class="form-control" placeholder="<?=ek('Updated At', '업데이트 날짜')?>" name="updatedAt" id="updatedAt"  value="<?=date('Y/m/d H:i', $profile->updatedAt)?>" disabled>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="block"><?=ek('Block', '차단')?></label>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="block" name="block" value="Y" <?=$profile->block == 'Y' ? 'checked' : ''?>>
                    <label class="custom-control-label" for="block"><?=ek('Block user for posting','사용자 글 쓰기 차단')?></label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-start mt-2 mb-3">
            <div class=" mr-5">
                <button type="submit" class="btn btn-primary">
                    <?=ek('Save', '저장')?>
                </button>
            </div>
            <div>
                <a class="btn btn-outline-secondary"
                   href="/?p=admin.index&w=user/admin-user-list"><?=ek('Cancel', '취소')?></a>
            </div>
        </div>
    </form>
</section>

