<?php
/**
 * @file config.class.php
 */
/**
 * Class Config
 *
 * There is no `config` taxonomy. Read the readme.
 */
class ConfigTaxonomy {


    /**
     *
     * Config constructor.
     * @param string $taxonomy
     * @param int $entity
     */
    public function __construct(public string $taxonomy, public int $entity = 0)
    {
    }

    /**
     * 설정을 읽는다. 설정은 metas 테이블에 저장되며, taxonomy=config, entity=0 이 된다.
     *
     * @param string|null $code - 코드 값이 주어지면 1개의 값만, 아니면, 현재 taxonomy 와 entity 의 전체 값을 리턴한다.
     * @return mixed - 값이 없으면 null 이 리턴된다.
     */
    public function get(string $code=null): mixed
    {
        return meta()->get($this->taxonomy, $this->entity, $code );
    }

    /**
     * 설정을 저장(또는 업데이트)한다. 설정은 metas 테이블에 저장되며, taxonomy=config, entity=0 이 된다.
     * @param array|string $code - 문자열이면 1개의 값, 배열이면 여러개의 값을 저장한다.
     *  if $code is an array, then it updates multiple settings.
     * @param mixed $value
     * @return void
     */
    public function set(array|string $code, mixed $value=null): void {
        if ( is_array($code) ) {
            meta()->updates($this->taxonomy, $this->entity, $code);
        } else {
            meta()->update([TAXONOMY => $this->taxonomy, ENTITY => $this->entity, CODE => $code, DATA => $value ]);
        }
    }

    /**
     * @param string $code
     * @return string $code
     */
    public function deleteCode(string $code): string {
        $idxes = meta()->search(where: "code=?", params: [$code]);
        foreach(ids($idxes) as $idx) {
            meta($idx)->delete();
        }
        return $code;
    }
}




/**
 * Returns Config instance or value of a code.
 *
 * The taxonomy of Config class does not exists. @see readme.md for detals.
 *
 * @param string $code
 *  - if $code is set, it returns the value of the config meta.
 * @param mixed|null $default_value
 * @return ConfigTaxonomy|int|string|array|null
 *
 * @example
 *  config(POINT_REGISTER, 0)
 *  config()->get(POINT_REGISTER);
 *  d( config(3)->getMetas() );
 */
function config(string $code='', mixed $default_value=null): ConfigTaxonomy|int|string|array|null
{
    if ( $code ) {
        $data = config()->get($code);
        if ( $data === null ) return $default_value;
        else return $data;
    }
    return new ConfigTaxonomy('config');
}


/**
 * @return ConfigTaxonomy
 */
function adminSettings(): ConfigTaxonomy {
    return new ConfigTaxonomy('config', ADMIN_SETTINGS);
}



