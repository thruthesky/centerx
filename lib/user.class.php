<?php
/**
 * @file user.class.php
 */
/**
 * Class User
 */
class User extends Entity {

    public bool $loggedIn = false;

    public function __construct(int $idx)
    {
        parent::__construct(USERS, $idx);

        global $__login_user_profile;
        if ( isset($__login_user_profile) && $__login_user_profile && isset($__login_user_profile[IDX]) ) {
            $this->loggedIn = true;
        }
    }


    /**
     * 사용자 필드를 가져오는 getter
     *
     * 레코드가 없거나 값이 없으면 null 를 리턴한다.
     * 권장되지는 않는데, defines 에 정의되지 않은 필드(레코드)를 가져 올 때, 사용 가능하다.
     *
     *
     * @param $name
     * @return mixed
     *
     * 예)
     *  d( user(49)->password );
     *  d( user(49)->oooo === null ? 'is null' : 'is not null' );
     */
    public function __get($name) {
        return $this->data($name);
    }

    /**
     * 현재 객체에 회원 idx 를 지정한다.
     * @param string $email
     * @return mixed
     * - 에러가 있으면 에러 코드를 리턴한다.
     * - 에러가 없으면, (password 필드를 포함하는) 회원 프로필 레코드를 리턴한다.
     */
    private function _setUserByEmail(string $email): mixed {
        $record = $this->get(EMAIL, $email);
        if ( !$record ) return e()->user_not_found_by_that_email;
        $this->setIdx($record[IDX]);
        return $record;
    }

    /**
     * 현재 사용자의 users 테이블 또는 meta(config) 테이블에서, field 의 값을 가져온다.
     *
     * @param string $field
     * @param mixed|null $_
     * @return mixed
     * - 에러이면, 에러 코드를 리턴한다.
     * - 필드가 존재하지 않으면 null 을 리턴한다.
     * - 그 외, 필드 값을 리턴한다.
     *
     * 예제)
     *  d( user(48)->get(PASSWORD) );
     */
    public function data(string $field): mixed {
        $record = $this->profile(unsetPassword: false);
        if ( e($record)->isError ) return $record;
        return isset($record[$field]) ? $record[$field] : null;
    }


    /**
     * Create a user account and return his profile.
     *
     * @param array $in
     * @return array|string
     */
    public function register(array $in): array|string {

        if ( isset($in[EMAIL]) == false ) return e()->email_is_empty;
        if ( !checkEmailFormat($in[EMAIL]) ) return e()->malformed_email;
        if ( isset($in[PASSWORD]) == false ) return e()->password_is_empty;

        $user = $this->get(EMAIL, $in[EMAIL]);
        if ( $user ) return e()->email_exists;

        $in[PASSWORD] = encryptPassword($in[PASSWORD]);

        $record = $this->create($in);

        if ( isError($record) ) return $record;

        return user($record[IDX])->profile();
    }

    public function loginOrRegister(array $in): array|string {
        $re = $this->login($in);
        if ( isError($re) == false ) return $re;
        else return $this->register($in);
    }

    /**
     * @attention User must be logged and the entity.idx must be set. Which means, it must be called with entity idx like below.
     *   user(123)->update();
     *   login()->update()
     *
     * @param array $in
     * @return array|string
     * - error_idx_not_set if current instance has not `idx`.
     * - profile on success.
     */
    public function update(array $in): array|string {
        if ( notLoggedIn() ) return e()->not_logged_in;
        parent::update($in);
        return $this->profile();
    }

    /**
     * 회원 정보를 리턴한다.
     * meta(config) 에 설정된 값들도 같이 리턴한다.
     * @param bool $unsetPassword - false 이면, 비밀번호를 같이 리턴한다.
     * @return mixed
     *
     * 예제)
     * d( user(48)->profile() );
     */
    public function profile($unsetPassword=true): mixed {
        if ( ! $this->idx ) return e()->idx_not_set;
        $record = $this->get('idx', $this->idx);
        if ( !$record ) return e()->user_not_found_by_that_idx;
        $record[SESSION_ID] = getSessionId($record);
        if ( $unsetPassword ) unset($record[PASSWORD]);
        return $record;
    }

    /**
     *
     * @return mixed
     *
     * 예제)
     * d(user()->login(email: '...', password: '...');
     */
    public function login(array $in):mixed {
        if ( isset($in[EMAIL]) == false || !$in[EMAIL] ) return e()->email_is_empty;

        if ( isset($in[PASSWORD]) == false || !$in[PASSWORD] ) return e()->empty_password;
        $profile = $this->_setUserByEmail($in[EMAIL]);
        if ( isError($profile) ) return $profile;

        if ( ! checkPassword($in[PASSWORD], $profile[PASSWORD]) ) return e()->wrong_password;
        return $this->profile();
    }

    /**
     * Update User Option Setting
     *
     * @param $in
     * @return array|string
     */
    public function updateOptionSetting(array $in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[OPTION]) && empty($in[OPTION]) ) return e()->option_is_empty;
        if ( my($in[OPTION]) == "Y" ) {
            parent::update( [ $in[OPTION] => 'N' ]);
        } else {
            parent::update( [ $in[OPTION] => 'Y' ]);
        }
        return $this->profile();
    }


}

/**
 * User 는 uid 를 입력 받으므로 항상 새로 생성해서 리턴한다.
 *
 * $_COOKIE[SESSION_ID] 에 값이 있으면, 사용자가 로그인을 확인을 해서, 로그인이 맞으면 해당 사용자의 idx 를 기본 사용한다.
 * @param int $idx
 * @return user
 */
function user(int $idx=0): User
{
    return new User($idx);
}

/**
 * Returns User class instance with the login user.
 *
 * @return User
 *
 * Example)
 *  d(user()->profile()); // Result. error_idx_not_set
 *  d(login()->profile()); // Result. it will return user profile if the user has logged in or erorr.
 *
 * You may check if user had logged in before calling this method.
 */
function login(): User {
    global $__login_user_profile;
    return new User($__login_user_profile[IDX] ?? 0);
}






