<?php
/**
 * @file category.model.php
 */
/**
 * Class CategoryModel
 *
 */
class CafeModel extends CategoryModel
{

    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }

    public function create($in):self {
        if( notLoggedIn() ) return $this->error(e()->not_logged_in);

        if( !isset($in['rootDomain']) ) return $this->error(e()->empty_root_domain);

        if( !isset($in['countryCode']) ) return $this->error(e()->empty_country_code);
        if( strlen($in['countryCode']) != 2 || is_numeric($in['countryCode']) ) return $this->error(e()->malformed_country_code);

        if( !isset($in['domain']) ) return $this->error(e()->empty_domain);

        if( preg_match("/^[a-zA-z][0-9a-zA-z]+/", $in['domain']) !== 1 ) return $this->error(e()->domain_should_be_alphanumeric_and_start_with_letter);


        $domain = strtolower($in['domain']) . '.' . $in['rootDomain'];

        if( strlen($domain) > 32 ) return $this->error(e()->domain_too_long);

        $data = [
            USER_IDX => login()->idx,
            ID => $domain,
            DOMAIN => $in['rootDomain'],
            'countryCode' => in('countryCode')
        ];
        return parent::create($data);
    }


}


/**
 * @param int|string $idx
 * @return CafeModel
 *
 */
function cafe(int|string $idx = 0): CafeModel
{
    // 문자열로 입력되었으면, 카테고리 ID 로 찾아 리턴한다.
    if ( $idx && !is_numeric($idx) ) {
        // If the input is string, then it is considered as category id. And returns Category instance with its idx.
        return cafe()->findOne([ID => $idx]);
    }
    return new CafeModel($idx);
}
