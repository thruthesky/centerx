<?php
/**
 * @file user.class.php
 */
/**
 * Class User
 */
class User extends Entity {

    public string $email;
    public string $name;
    public string $nickname;
    public string $photoIdx;
    public string $point;
    public string $phoneNo;
    public string $gender;
    public string $birthdate;
    public string $countryCode;
    public string $province;
    public string $city;
    public string $address;
    public string $zipcode;
    public string $createdAt;
    public string $updatedAt;
    public string $provider; // social login
    public string $plid; // pass login
    public string $ci; // pass login

    private array $profile = [];

    public function __construct(int $idx)
    {
        parent::__construct(USERS, $idx);
        $this->init();
    }

    private function init() {
        $u = $this->profile();
        if ( isError($u) || empty($u) ) return;

        $this->profile = $u;



        $this->email = $u[EMAIL];
        $this->name = $u[NAME];
        $this->nickname = $u[NICKNAME] ?? '';
        $this->photoIdx = $u['photoIdx'] ?? 0;
        $this->point = $u['point'];
        $this->phoneNo = $u['phoneNo'];
        $this->gender = $u['gender'];
        $this->birthdate = $u['birthdate'];
        $this->countryCode = $u['countryCode'];
        $this->province = $u['province'];
        $this->city = $u['city'];
        $this->address = $u['address'];
        $this->zipcode = $u['zipcode'];

        $this->createdAt = $u[CREATED_AT];
        $this->updatedAt = $u[UPDATED_AT];

        $this->provider = $u['provider'] ?? '';
        $this->plid = $u['plid'] ?? '';
        $this->ci = $u['ci'] ?? '';


    }

    /**
     * 사용자 필드를 가져오는 magic getter
     *
     * users 테이블과 meta 테이블에서 데이터를 가져온고, 레코드가 없으면 null 를 리턴한다.
     * @attention 주의 할 것은,
     *  1. 객체 초기화를 할 때, init() 함수에서
     *  2. users 테이블은 멤버 변수로 설정하고,
     *  3. 그리고 users 테이블과 meta 테이블의 모든 값은 $profile 에 저장한다.
     *  4. magic getter 로 값을 읽을 때, 새로 DB 에서 가져오는 것이 아니라, (멤버 변수로 설정되지 않았다면, 즉, meta 의 경우,) $profile 에서 가져온다.
     *  5 $this->update() 를 하면, 다시 init() 을 호출 한다.
     *
     *
     * @param $name
     * @return mixed
     *
     * @example
     *  d( user(49)->password );
     *  d( user(49)->oooo === null ? 'is null' : 'is not null' );
     *  $user = user($u[IDX]);
     *  isTrue($u[EMAIL] == $user->email, "same email");
     *  $updated = $user->update(['what' => 'blue']);
     *  isTrue($user->v('what') == 'blue', 'should be blue. but ' . $user->v('color'));
     *  isTrue($user->what == 'blue', 'should be blue. but ' . $user->what);
     */
    public function __get($name) {
        $u = $this->profile;
        if ( $u && isset($u[$name]) ) return $u[$name];
        else return null;
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

        $profile = user($record[IDX])->profile();

        point()->register($profile);

        return $profile;
    }

    public function loginOrRegister(array $in): array|string {
        $re = $this->login($in);
        if ( $re == e()->user_not_found_by_that_email ) {
            return $this->register($in);
        } else {
            return $re;
        }
//        d($re);
//        if ( isError($re) == false ) return $re;
//        else return $this->register($in);
    }

    /**
     *
     * @attention User may not be logged in. So, login check must be done before calling this method like in route.
     *  But $this->idx must be set.
     *
     *
     * @param array $in
     * @return self|string
     * - error_idx_not_set if current instance has not `idx`.
     * - profile on success.
     *
     * @example
     *  user(123)->update();
     *  login()->update()
     */
    public function update(array $in): self|string {
        if ( ! $this->idx ) return e()->idx_not_set;
        parent::update($in);
        $this->init();
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
    public function profile(bool $unsetPassword=true, bool $cache=true): mixed {
        if ( ! $this->idx ) return e()->idx_not_set;
        $record = $this->get('idx', $this->idx, cache: $cache);
        if ( !$record ) return e()->user_not_found_by_that_idx;
        $record[SESSION_ID] = getSessionId($record);
        if ( $unsetPassword ) unset($record[PASSWORD]);
        return $record;
    }

    /**
     * 글/코멘트 용으로 전달할(보여줄) 간단한 프로필 정보를 리턴한다.
     */
    public function postProfile() {
        return [
            'idx' => $this->idx,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'photoIdx' => $this->photoIdx,
        ];
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

        // 회원 정보 및 메타 정보 업데이트
        unset($in[PASSWORD]);
        $this->update($in);

        $profile = $this->profile();
        point()->login($profile);
        return $profile;
    }




    public function setPoint($p) {
        $this->update([POINT => $p]);
    }
    public function getPoint() {
        if ( $this->idx ) {
            return $this->get(select: POINT, cache: false)[POINT];
        } else {
            return 0;
        }
    }

    /**
     * Returns User instance by idx or email.
     * @param int|string $uid
     * @return User
     *
     *  - If there is no user by email, then it returns User(0).
     *
     * @example
     *      user()->by($email)->setPoint(0);
     */
    public function by(int|string $uid): User {
        if ( is_int($uid) ) return user($uid);
        $row = parent::get(EMAIL, $uid);
        if ( $row ) return user($row[IDX]);
        return user();
    }

    /**
     * Update User Option Setting - to set userMeta[OPTION] to Y or N
     * if $in[OPTION] is null or 'Y' then change it to N
     * if $in[OPTION] is 'N' then change it to Y
     *
     * @param $in
     * @return array|string
     */
    public function updateOptionSetting(array $in): array|string
    {
        if ( notLoggedIn() ) return e()->not_logged_in;
        if ( ! isset($in[OPTION]) && empty($in[OPTION]) ) return e()->option_is_empty;
        if ( my($in[OPTION]) == null  || my($in[OPTION]) == "Y" ) {
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
 * Returns User class instance with the login user. Or optionally, meta value of user field.
 *
 * Note, that it does not only returns `wc_users` table, but also returns from `wc_metas` table.
 * Use `$cache` to get critical information. Like getting user point before updating it.
 *
 * @param string|null $field
 * @param bool $cache
 * @return User|int|string|array|null
 *
 * Example)
 *  d(user()->profile()); // Result. error_idx_not_set
 *  d(login()->profile()); // Result. it will return user profile if the user has logged in or erorr.
 *
 * You may check if user had logged in before calling this method.
 *
 * @example
 *  login('color', false); // returns color meta.
 *  login()->color; // returns color meta also.
 */
function login(string $field=null, bool $cache=true): User|int|string|array|null {
    global $__login_user_profile;
    if ( $field ) {             // Want to get only 1 field?
        if (loggedIn()) {       // Logged in?
            if ($cache) {       // Want cached value?
                return $__login_user_profile[$field] ?? null;
            } else {            // Real value from database.
                $profile = login()->profile(cache: false);
                if ( isset($profile[$field]) ) { // Has field?
                    return $profile[$field];
                } else {
                    return null; // No field.
                }
            }
        } else {
            return null;        // Not logged in to get a field.
        }
    } else {
        return new User($__login_user_profile[IDX] ?? 0);
    }

}






