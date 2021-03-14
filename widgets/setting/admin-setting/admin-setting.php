<?php
    if ( modeUpdate() ) {
        adminSettings()->set(in());
        setRealtimeDatabaseDocument('/notifications/settings', ['time' => time()]);
    }

    $ms = adminSettings()->get();

    d($ms);
?>
<div class="container">
    <div class="row">
        <div class="col-3">
            <h3>Settings</h3>

        </div>
        <div class="col-9">
            <form method="post" action="/">
                <input type="hidden" name="p" value="admin.index">
                <input type="hidden" name="w" value="<?=in('w')?>">
                <input type="hidden" name="mode" value="update">
                <input type="text" class="form-control mb-2" name='siteName' value="<?=$ms['siteName'] ?? ''?>" placeholder="사이트 이름">
                <div class="form-text">
                    웹 브라우저 상단 제목이나 검색 엔진에 색인 될 사이트 이름입니다.
                    가능한 특수 문자를 입력하지 마세요.
                </div>

                <input type="text" class="form-control mb-2" name='siteDescription' value="<?=$ms['siteDescription'] ?? ''?>" placeholder="사이트 설명">
                <div class="form-text">
                    검색 엔진에 색인 될 기본 사이트 설명입니다. 가능한 특수 문자를 입력하지마세요.
                    각 글 읽기 페이지는 글 내용에 대한 설명이 색인됩니다.
                </div>



                <hr>
                <h2><?=ln("Global Forum Settings", "게시판 설정")?></h2>

                <div>
                    <label for="search_categories" class="form-label"><?=ln("Search Categories", "검색 가능한 카테고리")?></label>
                    <input class="form-control" id="search_categories" type="text" name="search_categories" value="<?=$ms['search_categories'] ?? ''?>">
                    <div class="form-text">
                        여기에 기록하는 카테고리만 검색이 됩니다. 공백으로 구분해서 입력 가능. 예) qna,job<br>
                        검색을 할 때, 전체 게시판 검색을 할 수 있게 하려면, 공백으로 두세요.
                    </div>


                </div>


                <label>
                    Like
                </label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="toggle_forum_like"  type="radio" name="forum_like" value="Y" <?php if (isset($ms['forum_like']) && $ms['forum_like']=='Y') echo 'checked' ?>>
                        <label class="form-check-label" for="toggle_forum_like">보이기</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="toggle_forum_like2"  type="radio" name="forum_like" value="N" <?php if (!isset($ms['forum_like']) || $ms['forum_like']!='Y') echo 'checked' ?>>
                        <label class="form-check-label" for="toggle_forum_like2">숨기기</label>
                    </div>

                </div>

                <label>
                    Dislike
                </label>
                <div>


                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="show_forum_dislike" type="radio" name="forum_dislike" value="Y" <?php if (isset($ms['forum_dislike']) && $ms['forum_dislike']=='Y') echo 'checked' ?>>
                        <label class="form-check-label" for="show_forum_dislike">보이기</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="hide_forum_dislike" type="radio" name="forum_dislike" value="N" <?php if (!isset($ms['forum_dislike']) || $ms['forum_dislike']!='Y') echo 'checked' ?>>
                        <label class="form-check-label" for="hide_forum_dislike">숨기기</label>
                    </div>



                </div>


                <hr>


                <h2><?=ln(['en' => 'User Agreements', 'ko' => '이용자 동의'])?></h2>
                <div class="row">
                    <div class="col-6">

                        <h3><?=ln(['en' => 'Terms and Conditions', 'ko' => '가입 약관'])?></h3>
                        <textarea class="w-100" rows="4" name="terms_and_conditions"><?=$ms['terms_and_conditions']??''?></textarea>

                    </div>
                    <div class="col-6">

                        <h3><?=ln(['en' => 'Privacy Policy', 'ko' => '개인 정보 보호'])?></h3>
                        <textarea class="w-100" rows="4" name="privacy_policy"><?=$ms['privacy_policy']??''?></textarea>

                    </div>
                </div>

                <hr>



                <div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>


            </form>
        </div>
    </div>
</div>