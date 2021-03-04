<?php
/**
 * @file config.class.php
 */
/**
 * Class Config
 *
 * There is no `config` taxonomy. Read the readme.
 */
class Config extends Entity {


    /**
     *
     * Config constructor.
     */
    public function __construct()
    {
        parent::__construct(CONFIG, 0);
    }

    /**
     * 설정을 읽는다. 설정은 metas 테이블에 저장되며, taxonomy=config, entity=0 이 된다.
     *
     * @param string $code
     * @param null $_
     * @return mixed - 값이 없으면 null 이 리턴된다.
     */
    public function get(string $code=null, mixed $_=null, string $__='', bool $____ = true): mixed
    {
       return $this->getMeta($code);
    }

    /**
     * 설정을 저장(또는 업데이트)한다. 설정은 metas 테이블에 저장되며, taxonomy=config, entity=0 이 된다.
     * @param string $code
     * @param $value
     * @return mixed
     */
    public function set(string $code, $value) {
        return $this->updateMetas($this->idx, [$code => $value]);
    }
}


/**
 * Returns Config instance or value of a code.
 *
 * The taxonomy of Config class does not exists.
 * With, Config class, you can set/get meta data.
 *
 * @param string $code
 * @param mixed|null $default_value
 * @return Config|int|string|array|null
 *
 * @example
 *  config(POINT_REGISTER, 0)
 *  config()->get(POINT_REGISTER);
 */
function config(string $code='', mixed $default_value=null): Config|int|string|array|null
{
    if ( $code ) {
        $got = config()->get($code);
        if ( $got === null ) return $default_value;
        else return $got;
    }
    return new Config();
}



