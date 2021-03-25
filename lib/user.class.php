<?php
/**
 * @file user.class.php
 */
/**
 * Class User
 * @property-read string $email
 * @property-read string $password
 * @property-read string $sessionId
 * @property-read string $firebaseUid
 * @property-read string $name
 * @property-read string $nickname
 * @property-read int $photoIdx
 * @property-read string $phoneNo
 * @property-read string $gender
 *
 *
 * @attention
 * User entity 의 변수는 기본적으로 캐시가 된다. 즉, point 의 값을 변경했는데, 기존의 변경되지 않은 값이 읽혀질 수 있다.
 * 그래서, DB 에서 변경된, 새로운 point 값이 필요한 경우, 이 변수를 사용하지 말고, DB 에서 직접 가져오는 getPoint() 를 사용해야 한다.
 * @property-read string $point
 *
 * @property-read int $birthdate
 * @property-read string $countryCode
 * @property-read string $province
 * @property-read string $city
 * @property-read string $address
 * @property-read string $zipcode
 * @property-read string $createdAt
 * @property-read string $updatedAt
 * @property-read string $provider -  social login
 * @property-read string $plid - pass login
 * @property-read string $ci - pass login
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
     * 참고, 현재 객체에 read() 메소드를 정의하면, 부모 클래스의 read() 메소드를 overridden 한다. 그래서 부모 함수를 호출해야한다.
     * read() 메소드를 정의하지 않고, 그냥 constructor 에서 정의 할 수 있는데, 그렇게하면 각종 상황에서 read() 가 호출되는데, 그 때 적절한 패치를 못할 수 있다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self
    {
        parent::read($idx);
        $data = $this->getData();
        $data[SESSION_ID] = getSessionId($this->getData());
        $this->setData($data);
        return $this;
    }


    /**
     * Create a user account and return his profile.
     *
     * 주의: 이 함수는 기존의 에러를 없애고, 이 함수에서 발생하는 에러를 저장한다.
     *
     * @param array $in
     * @return User
     */
    public function register(array $in): self {
        $this->resetError();
        if ( isset($in[EMAIL]) == false ) return $this->error(e()->email_is_empty);
        if ( !checkEmailFormat($in[EMAIL]) ) return $this->error(e()->malformed_email);
        if ( isset($in[PASSWORD]) == false ) return $this->error(e()->password_is_empty);


        $found = $this->exists([EMAIL=>$in[EMAIL]]);

        if ( $found ) return $this->error(e()->email_exists);

        $in[PASSWORD] = encryptPassword($in[PASSWORD]);

        $this->create($in);

        point()->register($this->profile());

        return $this;
    }

    /**
     * 비밀번호 변경
     *
     * @param string $newPassword
     * @return User
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

        $users = $this->search(select: 'idx, password', conds: [EMAIL => $in[EMAIL]]);
        if ( !$users ) return $this->error(e()->user_not_found_by_that_email);
        $user = $users[0];

        if ( ! checkPassword($in[PASSWORD], $user->password) ) return $this->error(e()->wrong_password);

        // 회원 정보 및 메타 정보 업데이트
        // 로그인을 할 때, 추가 정보를 저장한다. 이 때, 비밀번호는 저장되지 않게 한다.
        unset($in[PASSWORD]);

        // 회원 로그인 성공하면, 현재 객체를 로그인한 사용자 것으로 변경한다.
        $this->idx = $user->idx;
        $this->update($in);

        point()->login($this->profile());
        return $this;
    }




    /**
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
     *
     * - sessionId 는 객체 생성시 read() 에 의해 이미 적용되어져 있다.
     * - admin 속성에 관리자이면 Y 아니면 N 이 저장되어 리턴된다.
     *
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        $data = $this->getData();
        unset($data[PASSWORD]);
        $data[ADMIN] = admin() ? 'Y' : 'N';
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
     * 글/코멘트/기타 용으로 전달할(보여줄) 간단한 프로필 정보를 리턴한다.
     *
     * 주의, 배열을 리턴한다.
     * @param bool $firebaseUid - if it is set to true, returns data will include firebaseUid.
     * @return array
     */
    public function shortProfile(bool $firebaseUid = false): array {
        $ret = [
            'idx' => $this->idx,
            'name' => $this->name ? $this->name : '',
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'point' => $this->point,
            'photoIdx' => $this->photoIdx ?? 0,
            'photoUrl' => thumbnailUrl($this->photoIdx ?? 0, 100, 100),

        ];
        if ( $firebaseUid ) {
            $ret['firebaseUid'] = $this->firebaseUid;
        }
        return $ret;

    }


    /**
     * @param $p
     * @return User
     */
    public function setPoint($p): self {
        return $this->update([POINT => $p]);
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
            return $this->getVar(POINT, [IDX => $this->idx]);
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
     * @return User
     * - If there is no user by email, then error will be set.
     *
     */
    public function by(int|string $uid): User {
        if ( is_int($uid) ) return user($uid);
        return $this->findOne([EMAIL => $uid]);
    }


    /**
     * @todo This is a optional switching (on/off) function. Make it generic like `entity()->on(OPTION)`, `entity()->off(OPTION)
     * @todo Make it like `user(123)->on('chat_room_id')`, `user(123)->off(...)`
     * @todo Move the function to route.
     *
     * Update User Option Setting - to set userMeta[OPTION] to Y or N
     * if $in[OPTION] is null or 'Y' then change it to N
     * if $in[OPTION] is 'N' then change it to Y
     *
     * @param $in
     * @return array|string
     */
//    public function updateOptionSetting(array $in): self
//    {
//        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
//        if ( ! isset($in[OPTION]) && empty($in[OPTION]) ) return $this->error(e()->option_is_empty);
//
//        if ( login()->v($in[OPTION]) != 'N' ) {
//            parent::update( [ $in[OPTION] => 'N' ]);
//        } else {
//            parent::update( [ $in[OPTION] => 'Y' ]);
//        }
//
//        return $this;
//    }


    /**
     * 사용자를 검색 후, User 객체를 배열로 리턴한다.
     *
     * @param string $where
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @param string $select
     * @param array $conds
     * @param string $conj
     * @return User[]
     */
    public function search(
        string $select='idx',
        string $where='1',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        array $conds=[],
        string $conj = 'AND',
    ): array
    {

        $users = parent::search(
            select: $select,
            where: $where,
            order: $order,
            by: $by,
            page: $page,
            limit: $limit,
            conds: $conds,
            conj: $conj
        );

        $rets = [];
        foreach( ids($users) as $idx ) {
            $rets[] = user($idx);
        }
        return $rets;
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
 * Returns User class instance of the login user. Or optionally, returns meta value of user field.
 *
 * Note, that it returns Not Only user's field, but also user's meta field.
 *
 * 만약, 로그인이 안된 상태에서 이 함수를 호출하면, login()->idx 의 값은 0 이 된다.
 *
 * @param string|null $field
 * @return User|int|string|array|null
 *
 * Example)
 *  d(user()->profile()); // Result. error_idx_not_set
 *  d(login()->profile()); // Result. it will return user profile if the user has logged in or error.
 *
 * You may check if user had logged in before calling this method.
 *
 * @example
 *  login('color', false); // returns color meta.
 *  login()->color; // returns color meta also.
 */
function login(string $field=null): User|int|string|array|null {
    global $__login_user_profile;
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
        return new User($profile[IDX] ?? 0);
    }

}






