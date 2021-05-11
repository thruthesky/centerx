<?php

if (modeSubmit()) {
    if (in(POINT_LIKE) < 0) jsBack('앗! 추천 받는 사람의 포인트는 0 이상이어야 합니다.');
    if (in(POINT_DISLIKE) > 0) jsBack('앗! 비추천 받는 사람의 포인트는 0 이하이어야 합니다.');
    config()->set(POINT_REGISTER, in(POINT_REGISTER));
    config()->set(POINT_LOGIN, in(POINT_LOGIN));
    config()->set(POINT_LIKE, in(POINT_LIKE));
    config()->set(POINT_DISLIKE, in(POINT_DISLIKE));
    config()->set(POINT_LIKE_DEDUCTION, in(POINT_LIKE_DEDUCTION));
    config()->set(POINT_DISLIKE_DEDUCTION, in(POINT_DISLIKE_DEDUCTION));
    config()->set(POINT_LIKE_HOUR_LIMIT, in(POINT_LIKE_HOUR_LIMIT));
    config()->set(POINT_LIKE_HOUR_LIMIT_COUNT, in(POINT_LIKE_HOUR_LIMIT_COUNT));
    config()->set(POINT_LIKE_DAILY_LIMIT_COUNT, in(POINT_LIKE_DAILY_LIMIT_COUNT));
}


?>

<section data-cy="admin-point-setting-page">

    <h1>포인트 설정</h1>

    <div class="hint">
        <ul>
            <li>
                음수 값을 지정하면 포인트가 차감됩니다.
            </li>
            <li>
                출석 도장은 게시판 설정으로 하면 됩니다.
                게시판 설정에 1일 1회 글 쓰기로 제한하고, 글 쓰기 포인트를 지정하면 되는 것입니다.
            </li>
        </ul>
    </div>

    <form action="?" method="post">
        <input type="hidden" name="p" value="<?= in('p') ?>">
        <input type="hidden" name="w" value="<?= in('w') ?>">
        <input type="hidden" name="mode" value="submit">

        <div class="box border-radius-md">
            <div class="mb-3">
                <label class="form-label"><?= ek('Registration point', '회원 가입 포인트') ?></label>
                <input type="number" class="form-control" name="POINT_REGISTER" placeholder="0" value="<?= config(POINT_REGISTER, 0) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label"><?= ek('Login point', '로그인 포인트') ?></label>
                <input type="number" class="form-control" name="POINT_LOGIN" placeholder="0" value="<?= config(POINT_LOGIN, 0) ?>">
            </div>
        </div>

        <div class="box border-radius-md mt-3">
            <h3>추천/비추천</h3>
            <hr>
            <div class="hint">
                <ul>
                    <li>추천 받는 사람 포인트는 추천을 받는 사람(내가 아닌 다른 사람)이 얻게 되는 포인트.</li>
                    <li>비추천 받는 사람 포인트는 비 추천을 받는 사람(내가 아닌 다른 사람)이 얻게되는 포인트. 주로 0 또는 음수 값.</li>
                    <li>추천하는 사람 포인트는 추천을 하는 사람(나)이 얻게되는 포인트.</li>
                    <li>비추천 받는 사람의 포인트는 비 추천을 받으면 얻게되는 포인트. 주로 0 또는 음수 값.</li>
                    <li>
                        시간 제한과 회수 제한은 같이 사용되는 것으로 하루에 5번까지만 추천 포인트가 주어지게 한다면
                        시간에 24, 회수에 5를 입력하면 됨.
                        시간/회수 제한을 넘어서도 추천/비추천 가능하지만, 포인트 증/감은 하지 않음.
                    </li>
                    <li>
                        일/수 제한은 하루에 몇 회까지 허용 할지 제한하는 것.
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label"><?= ek('Point for like receiver', '추천 받는 사람 포인트') ?></label>
                    <input type="number" class="form-control" name="POINT_LIKE" placeholder="0" value="<?= config(POINT_LIKE, 0) ?>">
                </div>
                <div class="col">
                    <label class="form-label"><?= ek('Point for dislike receiver', '비추천 받는 사람 포인트') ?></label>
                    <input type="number" class="form-control" name="POINT_DISLIKE" placeholder="0" value="<?= config(POINT_DISLIKE, 0) ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label class="form-label"><?= ek('Point for like recommender', '추천하는 사람 포인트') ?></label>
                    <input type="number" class="form-control" name="POINT_LIKE_DEDUCTION" placeholder="0" value="<?= config(POINT_LIKE_DEDUCTION, 0) ?>">
                </div>
                <div class="col">
                    <label class="form-label"><?= ek('Point for dislike recommender', '비추천 하는 사람 포인트') ?></label>
                    <input type="number" class="form-control" name="POINT_DISLIKE_DEDUCTION" placeholder="0" value="<?= config(POINT_DISLIKE_DEDUCTION, 0) ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label class="form-label"><?= ek('Point change limit by hour', '추천/비추천 포인트 증/감 시간 제한. 단위) 시간') ?></label>
                    <input type="number" class="form-control" name="POINT_LIKE_HOUR_LIMIT" placeholder="0" value="<?= config(POINT_LIKE_HOUR_LIMIT, 0) ?>">
                </div>
                <div class="col">
                    <label class="form-label"><?= ek('Point change limit by count for the hour', '추천/비추천 포인트 증/감 회수 제한') ?></label>
                    <input type="number" class="form-control" name="POINT_LIKE_HOUR_LIMIT_COUNT" placeholder="0" value="<?= config(POINT_LIKE_HOUR_LIMIT_COUNT, 0) ?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <label class="form-label"><?= ek('Point change limit by day', '일/수 제한') ?></label>
                    <input type="number" class="form-control" name="POINT_LIKE_DAILY_LIMIT_COUNT" placeholder="0" value="<?= config(POINT_LIKE_DAILY_LIMIT_COUNT, 0) ?>">
                </div>
            </div>

        </div>

        <div class="d-grid">
            <button class="btn btn-primary mt-3" type="submit">저장</button>
        </div>

    </form>
</section>