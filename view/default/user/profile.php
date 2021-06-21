<section class="m-5">
    <form action="./">
        <input type="hidden" name="p" value="user.profile.submit">
        <div class="form-group">
            <label>Email address</label>
            <div><?=login()->email?></div>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" value="<?=login()->name?>">
        </div>
        <div class="form-group">
            <label>Phone No</label>
            <input type="text" class="form-control" name="<?=PHONE_NO?>" value="<?=login()->phoneNo?>">
        </div>
        <div class="form-group">
            <label>Your favorite color</label>
            <input type="text" class="form-control" name="color" value="<?=login()->color?>">
        </div>
        <button type="submit" class="btn btn-primary">Profile Update</button>
    </form>
</section>