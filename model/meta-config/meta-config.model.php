<?php
/**
 * @file metaConfig.model.php
 */
/**
 * Class MetaConfig
 *
 * There is no `metaConfig` model. Read the readme.
 *
 * `MetaConfig` 이 `MetaModel` 을 extends 하지 않는 이유는,
 *      - 사실, extends 하는게 가장 좋지만,
 *      - 생성자나 메소드에서 conflict 이 발생하기 때문이다. 편하게 쓰기 위해서 MetaModel 을 extends 하지 않는다.
 */
class MetaConfig {


    /**
     *
     * metaConfig constructor.
     * @param string $taxonomy
     * @param int $entity
     */
    public function __construct(public string $taxonomy, public int $entity = 0)
    {
    }

    /**
     * 설정을 읽어 그 값(레코드)을 리턴한다.
     * 설정은 metas 테이블에 저장되며, taxonomy=metaConfig 이며, entity 는 0 이면, 일반 설정, 1 이면 관리자 설저이다.
     *
     * @param string|null $code - 코드 값이 주어지면 1개의 값만, 아니면, 현재 taxonomy 와 entity 의 전체 값을 리턴한다.
     * @return mixed - 값이 없으면 null 이 리턴된다.
     */
    public function get(string $code=null): mixed
    {
        return meta()->get($this->taxonomy, $this->entity, $code );
    }

    /**
     * 설정을 저장(또는 업데이트)한다. 설정은 metas 테이블에 저장되며, taxonomy=metaConfig, entity=0 이 된다.
     * @param array|string $code - 문자열이면 1개의 값, 배열이면 여러개의 값을 저장한다.
     *  if $code is an array, then it updates multiple settings.
     * @param mixed $value
     * @return void
     *
     * 주의, 값 자체에는 배열을 저장하지 못한다.
     *
     * 주의, 에러가 있어도 에러를 리턴하지 않는다. meta()->updates() 함수 자체가 에러가 있어도 무시를 한다.
     *      따라서, 성공 여부를 확인해야 한다면, 데이터가 올바로 저장되었는지, 저장한 값을 읽어서 확인을 해야 한다.
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
     * @return string
     *  - error code on error.
     *  - empty string('') on success.
     */
    public function delete(string $code): string {
        $meta = meta()->delete($this->taxonomy, $this->entity, $code);
        if ( $meta->hasError ) return $meta->getError();
        else return '';
    }


}


/**
 * Returns metaConfig instance or value of a code.
 *
 * The taxonomy of metaConfig class does not exists. @see readme.md for detals.
 *
 * @param string $code
 *  - if $code is set, it returns the value of the metaConfig meta.
 * @param mixed|null $default_value
 * @return MetaConfig|int|string|array|null
 *
 * @example
 *  metaConfig(POINT_REGISTER, 0)
 *  metaConfig()->get(POINT_REGISTER);
 *  d( metaConfig(3)->getMetas() );
 */
function metaConfig(string $code='', mixed $default_value=null): MetaConfig|int|string|array|null
{
    if ( $code ) {
        $data = metaConfig()->get($code);
        if ( $data === null ) return $default_value;
        else return $data;
    }
    return new MetaConfig('config');
}


/**
 * Taxonomy 는 metaConfig 로 하되, entity 는 1 로 주어서, 일반 설정이 아닌, 관리자 설정으로 표시한다.
 * 즉, entity 가 1 이면, 관리자 설정인 것이다.
 * @return MetaConfig
 */
function adminSettings(): MetaConfig {
    return new MetaConfig('config', ADMIN_SETTINGS);
}



