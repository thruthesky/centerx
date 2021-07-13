<?php

$q_where = '1';
if ( modeCreate() ) {
    $conds = [];
    if (in('userIdx')) $conds[] = "userIdx='" . in('userIdx') . "'";
    if (in('tokenApply')) $conds[] = "tokenApply='" . in('tokenApply') . "'";
    if (in('reason')) $conds[] = "reason='" . in('reason') . "'";
    if (in('begin')) $conds[] = "createdAt>='" . strtotime(in('begin')) . "'";
    if (in('end')) $conds[] = "createdAt<'" . strtotime(in('end')) + 24 * 60 * 60 . "'";
    if ( $conds ) $q_where = implode(" AND ", $conds);
}

if ( modeSubmit() ) {
    $conds = [];
    if (in('userIdx')) $conds[] = "userIdx='" . in('userIdx') . "'";
    if (in('reason')) $conds[] = "reason='" . in('reason') . "'";
    if (in('begin')) $conds[] = "createdAt>='" . strtotime(in('begin')) . "'";
    if (in('end')) $conds[] = "createdAt<'" . strtotime(in('end')) + 24 * 60 * 60 . "'";
    if ( $conds ) $q_where = implode(" AND ", $conds);
}

$histories = aTokenHistory()->search(where: $q_where, limit: 100);

?>

<h2>토큰 지급</h2>

<form action="/">
    <?=hiddens(['p', 'w'], 'create')?>
    <div class="form-group">
        <label>User Idx</label>
        <input type="text" class="form-control" name="createUserIdx" value="<?=in('userIdx')?>">
    </div>
    <div class="form-group">
        <label>A-Token value</label>
        <input type="text" class="form-control" name="createTokenApply" value="<?=in('tokenApply')?>">
    </div> <div class="form-group">
        <label>A-Token reason</label>
        <input type="text" class="form-control" name="createReason" value="<?=in('reason')?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<P></P>
<h2>토큰 내역 검색</h2>

<form action="/">
    <?=hiddens(['p', 'w'], 'submit')?>
    <div class="form-group">
        <label>User Idx</label>
        <input type="text" class="form-control" name="userIdx" value="<?=in('userIdx')?>">
    </div>
    <div class="form-group">
        <label>A-Token reason</label>
        <input type="text" class="form-control" name="reason" value="<?=in('reason')?>">
    </div>
    <div>
        <label>Search by date</label>
        <div>
            <input name="begin" placeholder="Date begin(YYYYMMDD)" value="<?=in('begin')?>">
            ~
            <input name="end" placeholder="Date end(YYYYMMDD)" value="<?=in('end')?>">
        </div>
        <br>
        input format) YYYYMMDD
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">User(Idx)</th>
        <th scope="col">Reason</th>
        <th scope="col">Amount</th>
        <th scope="col">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($histories as $history) {
        $user = user( $history->userIdx );
        ?>
        <tr>
            <th scope="row"><?=$history->idx?></th>
            <td><?=$user->name?>(<?=$user->idx?>)</td>
            <td><?=$history->reason?></td>
            <td><?=number_format($history->toKenApply)?></td>
            <td><?=date('Y/m/d H:i', $history->createdAt)?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

