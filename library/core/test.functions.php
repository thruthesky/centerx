<?php

/**
 * 로그인한 사용자의 프로필을 담는 변수.
 *
 * 이 변수에 사용자 프로필이 있으면 그 사용자가 로그인을 한 사용자가 된다. 로그인 사용자를 변경하고자 한다면 이 변수를 다른 사용자의 users 레코드를 넣으면 된다.
 * 이 변수를 직접 사용하지 말고, 사용자 로그인을 시킬 때에는 setUserAsLogin() 을 쓰고, 사용 할 때에는 login() 을 사용하면 된다.
 */
global $__login_user_profile;

/**
 * Set the user of $profile as logged into the system.
 *
 * @attention, it does not save login information into cookies. It only set the user login in current session.
 *
 * @param int|array $profile
 * @return UserTaxonomy
 */
function setUserAsLogin(int|array $profile): UserTaxonomy {
    global $__login_user_profile;
    if ( is_int($profile) ) $profile = user($profile)->getData();
    $__login_user_profile = $profile;
    return user($profile[IDX] ?? 0);
}

// Alias of setUserAsLogin
function setLogin(int|array $profile): UserTaxonomy {
    return setUserAsLogin($profile);
}
// Alias of setUserAsLogin
function loginAs(UserTaxonomy $user): UserTaxonomy {
    return setUserAsLogin($user->idx);
}

function setLogout() {
    global $__login_user_profile;
    $__login_user_profile = [];
}
// Login any user. It could be root user. Use it only for test.
function setLoginAny(): UserTaxonomy {
    $users = user()->search(limit: 1, object: true);
    return setLogin($users[0]->idx);
}
function setLogin1stUser(): UserTaxonomy {
    return setLoginAny();
}

/**
 * 테스트를 할 때에 사용되는 것으로, setLoginAny() 는 테이블에서 맨 마지막에 가입된 사용자로 로그인을 하는데,
 * 이 함수는 2번째로 마지막에 가입된 사용자로 로그인을 한다.
 * 주의, 로그인을 하므로, setLoginAny() 와 같은 다른 로그인과 같이 쓰면 로그인이 꼬일 수 있다.
 * 두번 째 사용자 객체만 필요하면, getSecondUser() 함수를 사용한다.
 * @return UserTaxonomy
 */
function setLogin2ndUser(): UserTaxonomy {
    $users = user()->search(limit: 2, object: true);
    return setLogin($users[1]->idx);
}

/**
 * 맨 마지막에 가입한 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserTaxonomy
 */
function getFirstUser(): UserTaxonomy {
    $users = user()->search(limit: 1, object: true);
    return $users[0];
}


/**
 * 맨 마지막에서 두번째(가입한) 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserTaxonomy
 */
function getSecondUser(): UserTaxonomy {
    $users = user()->search(limit: 2, object: true);
    return $users[1];
}

/**
 * 맨 마지막에서 세번째(가입한) 사용자의 객체를 리턴한다.
 * 테스트에 사용.
 * @return UserTaxonomy
 */
function getThirdUser(): UserTaxonomy {
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
 * @return UserTaxonomy
 */
$__generateUserCount = 0;
function registerUser(): UserTaxonomy {
    global $__generateUserCount;
    $__generateUserCount ++;
    $email = "random-$__generateUserCount-" . time() . "@test.com";
    $user = user()->register([EMAIL => $email, PASSWORD => '12345a']);

    return $user;
}

/**
 * Registers with random email and logs into the system.
 * @return UserTaxonomy
 */
function registerAndLogin(): UserTaxonomy {
    $user = registerUser();
    setLogin($user->idx);
    return $user;
}




function createPost(): PostTaxonomy {
    if (category(POINT)->exists() == false) category()->create([ID => POINT]); // create POINT category if not exists.
    return post()->create([CATEGORY_ID => POINT, TITLE => TITLE, CONTENT => CONTENT]);
}
