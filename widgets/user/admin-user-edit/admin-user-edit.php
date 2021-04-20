<?php

//d(in());
if(modeSubmit()) {
    $in = in();
    unset($in['mode'],$in['p'],$in['w']);

    $profile = user(in('idx'))->adminProfileUpdate($in);
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
                <label for="idx">idx</label>
                <input type="text" class="form-control" placeholder="idx" name="idx" id="idx"  value="<?=$profile->idx?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="point">point</label>
                <input type="text" class="form-control" placeholder="point" name="point" id="point"  value="<?=$profile->point?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="email">email</label>
                <input type="text" class="form-control" placeholder="email" name="email" id="email"  value="<?=$profile->email?>">
            </div>
            <div class="form-group col-6">
                <label for="firebaseUid">firebaseUid</label>
                <input type="text" class="form-control" placeholder="firebaseUid" name="firebaseUid" id="firebaseUid"  value="<?=$profile->firebaseUid?>">
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="name">name</label>
                <input type="text" class="form-control" placeholder="name" name="name" id="name"  value="<?=$profile->name?>">
            </div>


            <div class="form-group col-6">
                <label for="nickname">nickname</label>
                <input type="text" class="form-control" placeholder="nickname" name="nickname" id="nickname"  value="<?=$profile->nickname?>">
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-6">
                <label for="phoneNo">phoneNo</label>
                <input type="text" class="form-control" placeholder="phoneNo" name="phoneNo" id="phoneNo"  value="<?=$profile->phoneNo?>">
            </div>

            <div class="form-group col-6">
                <label for="gender">gender</label>
                <select class="custom-select" id="gender" name="gender">
                    <option value="" <?=$profile->gender == '' ? 'selected': ''?>>Select Gender</option>
                    <option value="M" <?=$profile->gender == 'M' ? 'selected': ''?>>Male</option>
                    <option value="F" <?=$profile->gender == 'F' ? 'selected': ''?>>Female</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="birthdate">birthdate</label>
                <input type="text" class="form-control" placeholder="YYMMDD" name="birthdate" id="birthdate"  value="<?=$profile->birthdate?>">
            </div>

            <div class="form-group col-6">
                <label for="countryCode">countryCode</label>
                <input type="text" class="form-control" placeholder="countryCode" name="countryCode" id="countryCode" maxlength="2" value="<?=$profile->countryCode?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="province">province</label>
                <input type="text" class="form-control" placeholder="province" name="province" id="province"  value="<?=$profile->province?>">
            </div>

            <div class="form-group col-6">
                <label for="city">city</label>
                <input type="text" class="form-control" placeholder="city" name="city" id="city"  value="<?=$profile->city?>">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="address">address</label>
                <input type="text" class="form-control" placeholder="address" name="address" id="address"  value="<?=$profile->address?>">
            </div>

            <div class="form-group col-6">
                <label for="zipcode">zipcode</label>
                <input type="text" class="form-control" placeholder="zipcode" name="zipcode" id="zipcode"  value="<?=$profile->zipcode?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="createdAt">createdAt</label>
                <input type="text" class="form-control" placeholder="createdAt" name="createdAt" id="createdAt"  value="<?=date('Y/m/d H:i', $profile->createdAt)?>" disabled>
            </div>

            <div class="form-group col-6">
                <label for="updatedAt">updatedAt</label>
                <input type="text" class="form-control" placeholder="updatedAt" name="updatedAt" id="updatedAt"  value="<?=date('Y/m/d H:i', $profile->updatedAt)?>" disabled>
            </div>

        </div>
        <div class="d-flex justify-content-start mt-2 mb-3">
            <div class=" mr-5">
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
            <div>
                <a class="btn btn-outline-secondary"
                   href="/?p=admin.index&w=user/admin-user-list">Cancel</a>
            </div>
        </div>
    </form>




</section>

