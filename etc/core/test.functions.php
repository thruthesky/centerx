<?php

// Alias of setUserAsLogin
function setLogin(int|array $profile): UserModel {
    return setUserAsLogin($profile);
}
// Alias of setUserAsLogin
function loginAs(UserModel $user): UserModel {
    return setUserAsLogin($user->idx);
}

// Login any user. It could be root user. Use it only for test.
function setLoginAny(): UserModel {
    $users = user()->search(limit: 1, object: true);
    return setLogin($users[0]->idx);
}

// Login as admin.
// Note that this will change admin configuration. So, admin need to reset the admin email on admin page.
// @attention this function is available only on unit testing.
if ( defined('UNIT_TEST') || in('test') ) {
    function setLoginAsAdmin(): UserModel {
        $user = createTestUser();
        metaConfig()->set(ADMIN, $user->email);
        setLogin($user->response());
        return $user;
    }
}


function setLogin1stUser(): UserModel {
    return setLoginAny();
}

/**
 * 테스트를 할 때에 사용되는 것으로, setLoginAny() 는 테이블에서 맨 마지막에 가입된 사용자로 로그인을 하는데,
 * 이 함수는 2번째로 마지막에 가입된 사용자로 로그인을 한다.
 * 주의, 로그인을 하므로, setLoginAny() 와 같은 다른 로그인과 같이 쓰면 로그인이 꼬일 수 있다.
 * 두번 째 사용자 객체만 필요하면, getSecondUser() 함수를 사용한다.
 * @return UserModel
 */
function setLogin2ndUser(): UserModel {
    $users = user()->search(limit: 2, object: true);
    return setLogin($users[1]->idx);
}

/**
 * 맨 마지막에 가입한 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserModel
 */
function getFirstUser(): UserModel {
    $users = user()->search(limit: 1, object: true);
    return $users[0];
}


/**
 * 맨 마지막에서 두번째(가입한) 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserModel
 */
function getSecondUser(): UserModel {
    $users = user()->search(limit: 2, object: true);
    return $users[1];
}

/**
 * 맨 마지막에서 세번째(가입한) 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserModel
 */
function getThirdUser(): UserModel {
    $users = user()->search(limit: 3, object: true);
    return $users[2];
}

/**
 * Generate a random user by registering with random email address.
 *
 * Note, Use it for test only.
 * Note, Newly registered user is logged into the system.
 *
 * password is: 12345a
 *
 * @return UserModel
 */
$__generateUserCount = 0;
function registerUser(): UserModel {
    global $__generateUserCount;
    $__generateUserCount ++;
    $email = "random-$__generateUserCount-" . time() . "@test.com";
    $user = user()->register([EMAIL => $email, PASSWORD => '12345a']);

    return $user;
}

/**
 * Registers with random email and logs into the PHP runtime(system).
 *
 * 만약, 포인트가 주어지면, 그 포인트를 설정한다.
 * 만약, 포인트가 주어지지 않으면, 회원 가입 보너스 포인트 등이 설정될 수 있다.
 *  - 만약, 회원 가입 보너스 포인트를 원치 않으면, 테스트 전에 회원 가입 포인트를 0 으로 설정하면 된다.
 *
 * @param int $point
 * @return UserModel
 */
function registerAndLogin($point = 0): UserModel {
    $user = registerUser();
    setLogin($user->idx);
    if ( $point ) $user->_setPoint($point);
    return $user;
}






function createCategory(string $id = null): CategoryModel {
    return category()->create([ID => $id ?? 'category-test-'. time()]);
}


function createPost(string $categoryId=null, string $title = null, string $content = null, string $files = ''): PostModel {
    if (category($categoryId ?? POINT)->exists() == false) category()->create([ID => $categoryId ?? POINT]); // create POINT category if not exists.
    return post()->create([CATEGORY_ID => $categoryId ?? POINT,
        TITLE => $title ?? TITLE,
        CONTENT => $content ?? CONTENT,
        'files' => $files,
        ]);
}

function createComment(string $categoryId=null): CommentModel {
    if (category($categoryId ?? POINT)->exists() == false) category()->create([ID => $categoryId ?? POINT]); // create POINT category if not exists.
    $post = post()->create([CATEGORY_ID => $categoryId ?? POINT, TITLE => TITLE, CONTENT => CONTENT]);
    return comment()->create([ ROOT_IDX => $post->idx, CONTENT => 'comment content read' ]);
}

/**
 * Returns mock data for post.
 *
 * @attention The returned posts are the real posts that exists in wc_posts table. It returns the first posts from
 * wc_posts table.
 *
 * @warning The returned posts are real existing posts. It is recommended to post some test posts when the sysystem is setup.
 *
 *
 * @param int $limit
 *
 * @return PostModel[]
 *
 * @attention only the first 5 post has image.
 */
function postMockData(int $limit = 1, bool $photo = null ): array {
    return post()->first(limit: $limit, photo: $photo);
}
function firstPost(bool $photo = true ): PostModel {
    $posts = post()->first(photo: $photo);
    if ( empty($posts) ) return post();
    return $posts[0];
}



/**
 * Create a test user or login the test user that has just created for the test session.
 * @return UserModel
 */
function createTestUser(): UserModel {
    $email = 'user-register' . time() . '@test.com';
    $pw = '12345a';
    return user()->loginOrRegister([EMAIL=>$email, PASSWORD=>$pw, 'color' => 'blue']);
}

