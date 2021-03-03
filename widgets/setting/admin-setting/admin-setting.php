<div class="container">
    <div class="row">
        <div class="col-3">
            <h3>Settings</h3>

        </div>
        <div class="col-9">
            <form>
                <input type="hidden" name="p" value="admin.index">
                <input type="hidden" name="w" value="setting/admin-setting">
                <input type="hidden" name="mode" value="update">
                <input type="text" class="form-control mb-2" name='admins' value="<?=''?>" placeholder="제목 입력">
                <input type="text" class="form-control mb-2" name='siteName' value="<?=''?>" placeholder="설명 입력">

                <button type="submit" class="btn btn-primary mb-2">Update</button>
            </form>
        </div>
    </div>
</div>