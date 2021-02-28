<?php

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
    public function get(string $code=null, $_=null): mixed
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
 * Config 자체가 별거 없는 클래스라서 항상 새로 생성해서 리턴한다.
 * @return Config
 */
function config(): Config
{
    return new Config();
}



