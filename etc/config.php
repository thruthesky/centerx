<?php
/**
 * @file config.php
 */
/**
 * Class Config
 */
class Config {

    /**
     * @var array - 업데이트 불가능한 필드를 기록
     * @see README.md
     */
    public array $blockUserFields = [];


    /**
     * @var bool - 닉네임이 변경 가능한가?
     * @see README.md
     */
    public bool $isNicknameChangeable = true;


    /**
     * @var bool - 동일한 닉네임이 가능한다.
     * @see README.md
     */
    public bool $isNicknameDuplicatable = true;





    // For test
    public int $version = 1;



    // For singleton
    private static ?Config $instance = null;

    /**
     * Lazy initialization 을 통해서 딱 한번만 객체를 생성하여, $instance 에 저장한다.
     */
    public static function getInstance(): Config
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
    /**
     * constructor 를 외부에서 호출하지 못하도록 한다. 즉, 싱글톤으로만 사용 가능하도록 한다.
     * Config::getInstance() 를 통해서 사용하면 된다.
     */
    private function __construct()
    {
    }

    /**
     * 클론이 되지 않도록 한다. 클론이되면, Singleton 이 되지 않기 때문이다.
     */
    private function __clone()
    {
    }

    /**
     * Unserialize 가 되지 않도록 한다. Unserialize 해서, 새로운 객체를 만들 수 있기 때문이다.
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}

function config(): Config {
    return Config::getInstance();
}