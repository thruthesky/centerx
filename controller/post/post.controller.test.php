<?php
postCRUD();
postFetch();
postVoteAndReport();
function postCRUD() {
    $re = request("post.create");
    isTrue($re == e()->not_logged_in, "user must login first");

    $user = registerUser();

    $re = request("post.create", [ SESSION_ID => $user->sessionId]);
    isTrue($re == e()->category_id_is_empty, "Expected::e()->category_id_is_empty:: " . e()->category_id_is_empty);


    $re = request("post.create", [
        'categoryId' => 'xyzBanana',
        SESSION_ID => $user->sessionId
    ]);
    isTrue($re == e()->category_not_exists, "Expected::e()->category_not_exists:: " . e()->category_not_exists);


    $admin = setLoginAsAdmin();
    $category = request("category.create", [
        'id' => 'xyzBanana' . time(),
        SESSION_ID => $admin->sessionId
    ]);

    $post = request("post.create", [
        'categoryId' => $category[ID],
        SESSION_ID => $user->sessionId
    ]);
    isTrue($post[CATEGORY_IDX] == $category[IDX], "Expected:: post success");


    $post = request("post.update", [
        'title' => 'newTitle',
        IDX => $post[IDX],
        SESSION_ID => $user->sessionId
    ]);
    isTrue($post[TITLE] == "newTitle", "Expected:: post update");


    $getPostFromPath = request("post.get", [
        'path' => $post['url'],
        SESSION_ID => $user->sessionId
    ]);
    isTrue($getPostFromPath[IDX] == $post[IDX], "Expected:: post get success");


    isTrue($getPostFromPath['deletedAt'] == 0, "Expected:: post before Delete");
    $deletedPost = request("post.delete", [
        IDX => $post[IDX],
        SESSION_ID => $user->sessionId
    ]);
    isTrue($deletedPost['deletedAt'] > 0, "Expected:: post mark delete ");
}

function postFetch() {
    $admin = setLoginAsAdmin();
    $category = request("category.create", [
        'id' => 'postFetch' . time(),
        SESSION_ID => $admin->sessionId
    ]);

    $userA = registerUser();
    $time = time();
    $title = "postFetch" . $time;
    $post1 = request("post.create", [
        CATEGORY_ID => $category[ID],
        TITLE => $title,
        SESSION_ID => $userA->sessionId
    ]);

    $userB = registerUser();
    $post2 = request("post.create", [
        CATEGORY_ID => $category[ID],
        TITLE => "Post B" . $time,
        SESSION_ID => $userB->sessionId
    ]);

    $today = request("post.today", []);
    isTrue($today == e()->empty_category_idx, "Expected:: error empty category idx ");

    $today = request("post.today", [
        CATEGORY_ID => $category[ID],
    ]);
    isTrue(count($today) == 2, "Expected:: must have 2 post");

    $userATodayPost = request("post.today", [
        CATEGORY_ID => $category[ID],
        USER_IDX => $userA->idx
    ]);
    isTrue(count($userATodayPost) == 1, "Expected:: must have 1 post ");
    isTrue($userATodayPost[0][TITLE] == $title, "Expected:: title should be same ");

    $postGets = request("post.gets", [
        IDXES => $post1[IDX] . ',' . $post2[IDX]
    ]);
    isTrue(count($postGets) == 2, "get multiple post via gets");

    $postSearch = request("post.search", [
        SEARCH_KEY => $time
    ]);
    isTrue(count($postSearch) == 2, "get posts via search");

    $postCount = request("post.count", [
        'conds' => [ USER_IDX => $userA->idx ]
    ]);
    isTrue($postCount['count'] == 1, "get posts via search");
}

function postVoteAndReport() {
    $admin = setLoginAsAdmin();
    $category = request("category.create", [
        'id' => 'postVote' . time(),
        SESSION_ID => $admin->sessionId
    ]);
    $userA = registerUser();
    $post = request("post.create", [
        CATEGORY_ID => $category[ID],
        TITLE => "post vote " . time(),
        SESSION_ID => $userA->sessionId
    ]);

    $vote = request("post.vote");
    isTrue($vote == e()->idx_is_empty, "vote:: idx empty");

    $vote = request("post.vote", [
        IDX => $post[IDX]
    ]);
    isTrue($vote == e()->empty_vote_choice, "vote:: choice empty");
    $vote = request("post.vote", [
        IDX => $post[IDX],
        CHOICE => 'Y',
    ]);
    isTrue($vote == e()->not_logged_in, "vote:: not login");

    $vote = request("post.vote", [
        IDX => $post[IDX],
        CHOICE => 'Y',
        SESSION_ID => $userA->sessionId
    ]);
    isTrue($vote['Y'] == 1 , "vote Y:: Y = 1");
    isTrue($vote['N'] == 0,  "vote Y:: N = 0");

    $vote = request("post.vote", [
        IDX => $post[IDX],
        CHOICE => 'N',
        SESSION_ID => $userA->sessionId
    ]);
    isTrue($vote['Y'] == 0 , "vote N:: Y = 0");
    isTrue($vote['N'] == 1,  "vote N:: N = 1");


    $vote = request("post.vote", [
        IDX => $post[IDX],
        CHOICE => 'N',
        SESSION_ID => $userA->sessionId
    ]);
    isTrue($vote['Y'] == 0 , "vote N again:: Y = 0");
    isTrue($vote['N'] == 0,  "vote N again:: N = 0");

    $report = request("post.report");
    isTrue($report == e()->idx_is_empty , "report idx empty");

    $report = request("post.report", [
        IDX => $post[IDX],
        SESSION_ID => $userA->sessionId
    ]);
    isTrue($report['report'] == 1 , "report success");

    $userB = registerUser();
    $report = request("post.report", [
        IDX => $post[IDX],
        SESSION_ID => $userB->sessionId
    ]);
    isTrue($report['report'] == 2 , "other report the post");
}