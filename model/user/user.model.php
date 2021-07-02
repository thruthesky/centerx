<?php
/**
 * @file user.model.php
 */
/**
 * Class UserModel
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read string $sessionId
 * @property-read string $firebaseUid
 * @property-read string $name
 * @property-read string $nickname
 * @property-read string $nicknameOrName - 실제 DB 에 존재하지 않는 필드. 닉네임 또는 이름을 리턴한다. 만약, 닉네임 또는 이름이 존재하지 않으면, 이메일 주소의 계정에서 뒷자리 3자리를 xxx 로 변경해서 리턴한다.
 * @property-read int $photoIdx
 * @property-read string $phoneNo
 * @property-read string $gender
 *
 *
 * User entity 의 변수는 기본적으로 캐시가 된다. 즉, point 의 값을 변경했는데, 기존의 변경되지 않은 값이 읽혀질 수 있다.
 * 그래서, DB 에서 변경된, 새로운 point 값이 필요한 경우, 이 변수를 사용하지 말고, 가능한, DB 에서 직접 가져오는 getPoint() 를 사용해야 한다.
 * @property-read string $point - 주의: 이 변수는 캐시된 값을 가지고 있다. 실제 값을 얻기 위해서는 getPoint() 함수를 이용한다.
 *
 * @property-read int $birthdate
 * @property-read string $countryCode
 * @property-read string $province
 * @property-read string $city
 * @property-read string $address
 * @property-read string $zipcode
 * @property-read string $createdAt
 * @property-read string $updatedAt
 * @property-read string $provider - 소셜 로그인을 했을 때, 로그인 제공자. 예) naver, kakao
 * @property-read string $verifier - 본인 인증을 했을 때, 인증 제공자. 예) passlogin, danal.
 * @property-read string $verified - 본인 인증을 했으면 true 를 리턴. 아니면, false 를 리턴.
 * @property-read string $plid - pass login
 * @property-read string $ci - pass login
 * @property-read string photoUrl
 * @property-read int age - user's age
 */
class UserModel extends Entity {

    public function __construct(int $idx)
    {
        parent::__construct(USERS, $idx);
    }


    /**
     * getter 에 verified 를 추가.
     * @param $name
     * @return mixed
     */
//    public function __get($name): mixed {
//        if ( $name == 'verified' ) {
//            return $this->verifier;
//        } else if ( $name == 'nicknameOrName' ) {
//            if ( $this->nickname ) return $this->nickname;
//            else if ( $this->name ) return $this->name;
//            else {
//                $email = $this->email;
//                if ( str_contains($email, '@') ) {
//                    $arr = explode('@', $email, 2);
//                    $account_name = $arr[0];
//                    if ( strlen($account_name) < 3 ) return 'xxx';
//                    return substr($account_name, 0, strlen($account_name)-3) . 'xxx';
//                } else {
//                    return '(No nameOrNickname or Email)';
//                }
//            }
//        } else if ( $name == 'age' ) {
//            if ( strlen($this->birthdate) == 6) $birthYear = substr($this->birthdate, 0, 2);
//            else if ( strlen($this->birthdate) == 8) $birthYear = substr($this->birthdate, 2, 2);
//            else return '?';
//
//            if ( $birthYear < 30 ) $birthYear = "20$birthYear";
//            else $birthYear = "19$birthYear";
//            return (date('Y') - $birthYear) + 1;
//        }
//        else {
//            return parent::__get($name);
//        }
//    }

    public function nicknameOrName() {
        if ( $this->nickname ) return $this->nickname;
        else if ( $this->name ) return $this->name;
        else {
            $email = $this->email;
            if ( str_contains($email, '@') ) {
                $arr = explode('@', $email, 2);
                $account_name = $arr[0];
                if ( strlen($account_name) < 3 ) return 'xxx';
                return substr($account_name, 0, strlen($account_name)-3) . 'xxx';
            } else {
                return '(No nameOrNickname or Email)';
            }
        }
    }

    /// 나이를 계산할 수 없으면 -1 을 리터한다.
    public function age() {
        if ( strlen($this->birthdate) == 6) $birthYear = substr($this->birthdate, 0, 2);
        else if ( strlen($this->birthdate) == 8) $birthYear = substr($this->birthdate, 2, 2);
        else return -1;

        if ( $birthYear < 30 ) $birthYear = "20$birthYear";
        else $birthYear = "19$birthYear";
        return (intval(date('Y')) - intval($birthYear)) + 1;
    }

    /**
     * 회원 정보를 읽어서 data 에 보관한다.
     *
     * 회원 정보를 읽을 때, password 를 없애고, sessionId 를 추가한다.
     * 참고, 현재 객체에 read() 메소드를 정의하면, 부모 클래스의 read() 메소드를 overridden 한다. 그래서 부모 함수를 호출해야한다.
     * read() 메소드를 정의하지 않고, 그냥 constructor 에서 정의 할 수 있는데, 그렇게하면 각종 상황에서 read() 가 호출되는데, 그 때 적절한 패치를 못할 수 있다.
     *
     *
     * - 참고, 관리자 인지 아닌지 판단은 read() 와 response() 둘 다 한다.
     *   - PHP 에서 객체로 쓸 때, response() 는 호출되지 않고,
     *   - 컨트롤러로 로그인된 사용자의 response() 만 호출할 때, read() 가 호출되지 않는다.
     *
     * @param int $idx
     * @return self
     *
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        $data = $this->getData();
        $data[SESSION_ID] = getSessionId($this->getData());
        $this->setMemoryData($data);
        $one = files()->findOne([CODE => 'photoUrl', USER_IDX => $this->idx]);
        if ( $one->exists ) {
            $this->updateMemoryData('photoIdx', $one->idx);
            $this->updateMemoryData('photoUrl', $one->url);
        }
        $this->updateMemoryData('nicknameOrName', $this->nicknameOrName());
        $this->updateMemoryData('age', $this->age());
        $this->updateMemoryData('verified', $this->verifier);

        $data[ADMIN] = admin($this->email) ? 'Y' : 'N';

        return $this;
    }


    /**
     * Create a user account and return his profile.
     *
     * 주의: 이 함수는 기존의 에러를 없애고, 이 함수에서 발생하는 에러를 저장한다.
     * 주의, 이 함수는 회원 가입만 하고, 쿠키에 로그인 정보를 저장하지 않는다. 즉, 회원 가입을 한 후, 별도로 쿠키에 저장을 해야 한다.
     *
     * @param array $in
     * @return self
     */
    public function register(array $in): self {
        $this->resetError();
        if ( isset($in[EMAIL]) == false || empty($in[EMAIL]) ) return $this->error(e()->email_is_empty);
        if ( !checkEmailFormat($in[EMAIL]) ) return $this->error(e()->malformed_email);
        if ( isset($in[PASSWORD]) == false || empty($in[PASSWORD]) ) return $this->error(e()->password_is_empty);


        $found = $this->exists([EMAIL=>$in[EMAIL]]);

        if ( $found ) return $this->error(e()->email_exists);

        $in[PASSWORD] = encryptPassword($in[PASSWORD]);

        /// When user register, point become 0. User cannot change his point when register.
        $in[POINT] = 0;
        $this->create($in);

        act()->register($this);

        return $this;
    }

    /**
     * 비밀번호 변경
     *
     * @param string $newPassword
     * @return self
     *
     * @example
     *      user()->by('thruthesky@gmail.com')->changePassword('abc123d')
     */
    public function changePassword(string $newPassword): self {
        return parent::update([PASSWORD => encryptPassword($newPassword)]);
    }





    /**
     * 이 메일이 존재하면 true, 아니면 false 를 리턴한다.
     * @param $email
     * @return bool
     */
    public function emailExists($email): bool {
        return count($this->search(conds: [EMAIL => $email])) == 1;
    }

    /**
     * 회원 로그인
     *
     * 회원 로그인 성공하면, 현재 객체를 로그인한 사용자 것으로 변경한다.
     *
     * @param array $in
     * @return self
     *
     * 예제)
     * d(user()->login(email: '...', password: '...');
     */
    public function login(array $in): self {

        if ( isset($in[EMAIL]) == false || !$in[EMAIL] ) return $this->error(e()->email_is_empty);
        if ( isset($in[PASSWORD]) == false || !$in[PASSWORD] ) return $this->error(e()->empty_password);

        $users = $this->search(select: 'idx, password', conds: [EMAIL => $in[EMAIL]], object: true);
        if ( !$users ) return $this->error(e()->user_not_found_by_that_email);
        $user = $users[0];

        if ( ! checkPassword($in[PASSWORD], $user->password) ) return $this->error(e()->wrong_password);

        // 회원 정보 및 메타 정보 업데이트
        // 로그인을 할 때, 추가 정보를 저장한다. 이 때, 비밀번호는 저장되지 않게 한다.
        unset($in[PASSWORD]);

        // User cannot change his point.
        if(isset($in[POINT])) return $this->error(e()->user_cannot_update_point);

        // 회원 로그인 성공하면, 현재 객체를 로그인한 사용자 것으로 변경한다.
        $this->idx = $user->idx;
        $this->update($in);

//        d($this);
        act()->login($this);
//        point()->login($this->profile());
        return $this;
    }




    /**
     *
     * @attention This does not login to PHP run time. It will only return login session and user information.
     *
     * @param array $in
     * @return self
     */
    public function loginOrRegister(array $in): self {
        $re = $this->login($in);
        if ( $re->getError() == e()->user_not_found_by_that_email ) {
            return $this->register($in);
        } else {
            return $re;
        }
    }


    /**
     * 회원 정보를 클라이언트로 전달하기 위한 값을 리턴한다.
     *
     * 에러가 있으면, 에러 문자열. 아니면, 사용자 레코드와 메타를 배열로 리턴한다.
     * 주의, 로그인을 했는지 안했는지는 검사하지 않는다.
     *
     * - sessionId 는 객체 생성시 read() 에 의해 이미 적용되어져 있다.
     * - admin 속성에 관리자이면 Y 아니면 N 이 저장되어 리턴된다.
     *
     * @return array|string
     *
     * - 주의, 로그인을 안해도, 여기서는 절대 빈 배열을 리턴해서는 안된다. 다른 사용자의 정보를 리턴 할 수도 있다.
     * - 로그인을 안했거나 $this->data 에 정보가 없으면 {'admin': 'N'} 정도만 리턴된다.
     * - 참고, 관리자 인지 아닌지 판단은 read() 와 response() 둘 다 한다.
     *   - PHP 에서 객체로 쓸 때, response() 는 호출되지 않고,
     *   - 컨트롤러로 로그인된 사용자의 response() 만 호출할 때, read() 가 호출되지 않는다.
     */
    public function response(string $fields = null): array|string {
        if ( $this->hasError ) return $this->getError();
        $data = $this->getData();
        unset($data[PASSWORD]);
        $data[ADMIN] = admin($this->email) ? 'Y' : 'N';
        return $data;
    }

    /**
     * Alias of response()
     *
     * 단순히, $this->data() 를 배열로 리턴한다.
     *
     * @return array|string
     * 예제)
     * d( user(48)->profile() );
     */
    public function profile(): array|string {
        return $this->response();
    }

    /**
     *
     * @attention The returned data is a slim version of User::response data.
     *  And it has same field properties. Which means, it can be used by the same User Model on client side.
     *
     * 글/코멘트/기타 용으로 전달할(보여줄) 간단한 프로필 정보를 리턴한다.
     *
     * 주의, 배열을 리턴한다.
     * @param bool $firebaseUid - if it is set to true, returns data will include firebaseUid.
     * @return array
     */
    public function shortProfile(bool $firebaseUid = false): array {
        $ret = [
            'idx' => $this->idx,
            'name' => $this->name != null ? $this->name : '',
            'nickname' => $this->nickname,
            'nicknameOrName' => $this->nicknameOrName,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'age' => $this->age,
            'verified' => $this->verified,
            'point' => $this->point,
            'photoIdx' => $this->photoIdx ?? 0,
            'photoUrl' =>  $this->photoIdx ? thumbnailUrl($this->photoIdx ?? 0, 100, 100) : ($this->photoUrl ?? ''),
        ];
        if ( $firebaseUid ) {
            $ret['firebaseUid'] = $this->firebaseUid;
        }
        return $ret;

    }


    /**
     * Update user point.
     *
     * @주의, 이 함수는 내부적으로만 사용되어야 한다. 컨트롤러에 포함하거나 사용자가 직접 자신을 포인트를 수정하게 해서는 안된다.
     *  특히, user()->update() 호출로는 포인트 업데이트를 못하므로, 이 함수는 DB 에 직접 포인트를 업데이트한다.
     *
     * @attention User cannot update their point by `user()->update()` since it blocks updating user point. So, it
     *  updates directly into db.
     *
     * @attention Don't let user to update his point. This method is only for internal use.
     * @attention Don't export this method with controller.
     * @param $p
     * @return self
     */
    public function setPoint($p): self {

        db()->update($this->getTable(), [POINT => $p], [IDX => $this->idx]);
        return $this;

//        return $this->update([POINT => $p]);
    }


    /**
     * 사용자 포인트를 리턴한다.
     *
     * 포인트는 캐시된 값을 쓰면 안되고, DB 에서 값을 가져와야하는 경우가 많으므로, `$this->point` 는 쓰지 못한다.
     * `$this->point` 를 쓰려고 한다면, `User::$point must not be accessed before initialization` 에러를 만날 것이다.
     *
     * 주의, 로그인을 하지 않은 상태라도, 현재 User 객체의 $this->idx 값이 설정되어져 있으면, 그 entity 의 point 를 가져온다.
     *
     * @param bool $cache - 이 값이 true 이면, DB 에서 읽지 않고, 이미 읽은 데이터를 사용한다. 기본 값 false.
     * @return int
     */
    public function getPoint(bool $cache=false): int {
        if ( $cache ) {
            return $this->getData()['point'];
        } else {
            return $this->column(POINT, [IDX => $this->idx]);
        }
    }





    /**
     * Returns User instance by idx or email.
     *
     * Entity 클래스의 findOne() 설명을 참고한다.
     *
     * @example
     *      user()->by($email)->setPoint(0);
     *
     * @param int|string $uid user idx or email
     * @return self
     * - If there is no user by email, then error will be set.
     *
     */
    public function by(int|string $uid): self {
        if ( is_int($uid) ) return user($uid);
        return $this->findOne([EMAIL => $uid]);
    }

    /**
     * alias of by();
     * @param string $email
     * @return self
     */
    public function byEmail(string $email): self {
        return $this->by($email);
    }


    /**
     * @param array $in
     * @return $this
     */
    function update($in): self
    {
        // If email has passed, it can update(change) user's email.
        if ( isset($in[EMAIL]) ) {
            if ( empty($in[EMAIL]) ) return $this->error(e()->email_is_empty);
            if ($this->emailExists($in[EMAIL]) &&  $this->findOne([EMAIL => $in[EMAIL]])->idx != $this->idx) return $this->error(e()->email_exists);
        }
        // point cannot be changed by user.
        if ( isset($in[POINT] ) && admin() == false ) {
            return $this->error(e()->user_cannot_update_point);
        }
        return parent::update($in);
    }

}

/**
 * User 는 uid 를 입력 받으므로 항상 새로 생성해서 리턴한다.
 *
 * $_COOKIE[SESSION_ID] 에 값이 있으면, 사용자가 로그인을 확인을 해서, 로그인이 맞으면 해당 사용자의 idx 를 기본 사용한다.
 * @param int $idx
 * @return UserModel
 */
function user(int $idx=0): UserModel
{
    return new UserModel($idx);
}

/**
 * Returns User class instance of the login user.
 * Or returns meta value if user field is given.
 *
 *
 * Note, that it returns Not Only user's field, but also user's meta field.
 * Note, once user login object is created, it is reused.
 *
 * 만약, 로그인이 안된 상태에서 이 함수를 호출하면, login()->idx 의 값은 0 이 된다.
 *
 * @param string|null $field
 * @return UserModel|int|string|array|null
 *
 * Example)
 *  login()->update(['a' => 'apple']);
 *  login()->a == 'apple'
 *
 * You may check if user had logged in before calling this method.
 *
 * @example
 *  login('color', false); // returns color meta.
 *  login()->color; // returns color meta also.
 */
$__login_user_object = user(0); // memory cache
function login(string $field=null): UserModel|int|string|array|null {
    global $__login_user_profile, $__login_user_object;
    $profile = $__login_user_profile;
    if ( $field ) {             // Want to get only 1 field?
        if ( $profile ) {       // Logged in?
            if ( isset($profile[$field]) ) { // Has field?
                return $profile[$field];
            } else {
                return null; // No field.
            }
        } else {
            return null;        // Not logged in to get a field.
        }
    } else {
        if ( $__login_user_object->idx && $__login_user_object->idx == ($profile[IDX] ?? 0) ) return $__login_user_object;
        $__login_user_object = new UserModel($profile[IDX] ?? 0);
        return $__login_user_object;
    }
}









