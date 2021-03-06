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
    public function __construct(int $idx = 0)
    {
        parent::__construct(CONFIG, $idx);
    }

    /**
     * 설정을 읽는다. 설정은 metas 테이블에 저장되며, taxonomy=config, entity=0 이 된다.
     *
     * @param string|null $field
     * @param null $_
     * @param string $__
     * @param bool $____
     * @param bool $cache
     * @return mixed - 값이 없으면 null 이 리턴된다.
     */
    public function get(string $field=null, mixed $_=null, string $__='', bool $____ = true, bool $cache = true): mixed
    {
       return $this->getMeta($field);
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
 * The taxonomy of Config class does not exists. @see readme.md for detals.
 *
 * @param int|string $code
 *  - if $code is string, it returns the value of the config meta.
 *  - if $code is int, then it returns the config instance with the idx of the value in $code.
 * @param mixed|null $default_value
 * @return Config|int|string|array|null
 *
 * @example
 *  config(POINT_REGISTER, 0)
 *  config()->get(POINT_REGISTER);
 *  d( config(3)->getMetas() );
 */
function config(int|string $code='', mixed $default_value=null): Config|int|string|array|null
{
    if ( $code ) {
        if ( is_numeric($code) ) {
            return new Config($code);
        } else {
            $got = config()->get($code);
            if ( $got === null ) return $default_value;
            else return $got;
        }
    }
    return new Config();
}




