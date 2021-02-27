<?php

class Config extends Entity {


    /**
     *
     * Config constructor.
     * @param string $prefix - config table 의 code 앞에 붙는 prefix. 보통 taxonomy 에 따라서,
     *      사용자의 경우, 'user.사용자번호.' 로 되고
     *      게시판의 경우, 'post.글번호.' 와 같이 되고,
     *      코멘트의 경우, 'comment.코멘트번호' 와 같이 된다.
     *      첨부 파일의 경우, 가능한 wc_files 로 끝을 낸다.
     */
    public function __construct(private string $prefix='')
    {
        parent::__construct(CONFIG);
    }

    /**
     *
     *
     * @param string $code
     * @param null $_
     * @return array|null - 값이 없으면 null 이 리턴된다.
     */
    public function get(string $code, $_=null): array|null
    {
        $entity = parent::get(CODE, $code);
        if ( $entity ) return $entity['data'];
        else return [];
    }


    /**
     * prefix 로 시작하는 모든 설정을 리턴한다.
     *
     * 예를 들어, 사용자의 모든 config 를 한번에 가져오고자 할 때 사용한다.
     * 이 때, code 에서 prefix 를 제거해서 리턴한다.
     *
     * @return array
     */
    public function getAll(): array {
        $rows = db()->get_results("SELECT * FROM {$this->getTable()} WHERE code LIKE '{$this->prefix}%'", ARRAY_A);
        $rets = [];
        foreach($rows as $row) {
            $row['code'] = str_replace($this->prefix, '', $row['code']);
            $rets[] = $row;
        }
        return $rets;
    }


    /**
     * code 에 prefix 를 붙여서 저장한다.
     *
     * @param string $code
     * @param mixed $value
     * @return mixed
     */
    private function _set(string $code, mixed $value): mixed {
        return entity(CONFIG)->create([CODE=> $this->prefix . $code, DATA=>$value]);
    }

    /**
     * 성공하면 config 의 idx(또는 idx 배열)을 리턴한다.
     * 실패함현 false 또는 false 배열을 리턴한다.
     * @param string|array $code
     * @param mixed|null $value
     * @return mixed
     */
    public function set(string|array $code, mixed $value=null): mixed
    {
        if ( is_array($code) ) {
            $idxes = [];
            foreach( $code as $k => $v ) {
                $idxes[] = $this->_set($k, $v);
            }
            return $idxes;
        } else {
            return $this->_set($code, $value);
        }
    }

}


$__Config = null;
/**
 * Config 자체가 별거 없는 클래스라서 항상 새로 생성해서 리턴한다.
 * @return Config
 */
function config($prefix=''): Config
{
    return new Config($prefix);
}



