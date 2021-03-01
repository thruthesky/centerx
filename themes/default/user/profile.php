<section class="m-5">
    <form action="./">
        <input type="hidden" name="p" value="user.profile.submit">
        <div class="form-group">
            <label>Email address</label>
            <div><?=my(EMAIL)?></div>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?=my(NAME)?>">
        </div>
        <div class="form-group">
            <label>Phone No</label>
            <input type="text" class="form-control" name="<?=PHONE_NO?>" value="<?=my(PHONE_NO)?>">
        </div>
        <div class="form-group">
            <label>Your favorite color</label>
            <input type="text" class="form-control" name="color" value="<?=my('color')?>">
        </div>
        <button type="submit" class="btn btn-primary">Profile Update</button>
    </form>
</section>