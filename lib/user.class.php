<?php
/**
 * @file user.class.php
 */
/**
 * Class User
 * @property-read string $email;
 * @property-read string $name;
 * @property-read string $nickname;
 * @property-read int $photoIdx;
 * @property-read int $point;
 * @property-read string $phoneNo;
 * @property-read string $gender;
 * @property-read int $birthdate;
 * @property-read string $countryCode;
 * @property-read string $province;
 * @property-read string $city;
 * @property-read string $address;
 * @property-read string $zipcode;
 * @property-read string $createdAt;
 * @property-read string $updatedAt;
 * @property-read string $provider; // social login
 * @property-read string $plid; // pass login
 * @property-read string $ci; // pass login
 */
class User extends Entity {


    public function __construct(int $idx)
    {
        parent::__construct(USERS, $idx);
    }

    /**
     * 회원 정보를 읽어서 data 에 보관한다.
     *
     * 회원 정보를 읽을 때, password 를 없애고, sessionId 를 추가한다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        $data = $this->getData();
        unset($data[PASSWORD]);
        $data[SESSION_ID] = getSessionId($this->getData());
        $this->setData($data);
        return $this;
    }


    /**
     * Create a user account and return his profile.
     *
     * @param array $in
     * @return User
     */
    public function register(array $in): self {

        if ( isset($in[EMAIL]) == false ) return $this->error(e()->email_is_empty);
        if ( !checkEmailFormat($in[EMAIL]) ) return $this->error(e()->malformed_email);
        if ( isset($in[PASSWORD]) == false ) return $this->error(e()->password_is_empty);

        $found = $this->exists([EMAIL=>$in[EMAIL]]);
        if ( $found ) return $this->error(e()->email_exists);

        $in[PASSWORD] = encryptPassword($in[PASSWORD]);

        return $this->create($in);
    }


    /**
     *
     * @param array $in
     * @return mixed
     *
     * 예제)
     * d(user()->login(email: '...', password: '...');
     */
    public function login(array $in):mixed {
        if ( isset($in[EMAIL]) == false || !$in[EMAIL] ) return e()->email_is_empty;
        if ( isset($in[PASSWORD]) == false || !$in[PASSWORD] ) return e()->empty_password;

        $users = $this->search(select: PASSWORD, conds: [EMAIL => $in[EMAIL]]);
        if ( !$users ) return $this->error(e()->user_not_found_by_that_email);
        $password = $users[0][PASSWORD];

        if ( ! checkPassword($in[PASSWORD], $password) ) return $this->error(e()->wrong_password);

        // 회원 정보 및 메타 정보 업데이트
        unset($in[PASSWORD]);

        // 로그인을 할 때, 추가 정보를 저장한다.
        $this->update($in);

        $profile = $this->profile();
        point()->login($profile);
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
    public function update(array $in): self {
        if ( ! $this->idx ) return $this->error(e()->idx_not_set);
        parent::update($in);
        $this->init();
        return $this->profile();
    }


    /**
     * 회원 정보를 클라이언트로 전달하기 위한 값을 리턴한다.
     *
     * 에러가 있으면, 에러 문자열. 아니면, 사용자 레코드와 메타를 배열로 리턴한다.
     *
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        return $this->getData();
    }

    /**
     * @return array|string
     * 예제)
     * d( user(48)->profile() );
     */
    public function profile(): array|string {
        return $this->response();
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
                $profile = login()->profile();
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






