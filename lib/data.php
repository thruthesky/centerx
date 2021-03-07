<?php
/**
 * @file data.php
 */

/**
 * 국가 코드 2자리와 국가 이름을 리턴한다. 국가 이름을 보여주고, 선택하면 국가 코드를 저장하려 할 때 사용가능.
 *
 * @param string $sortby - 이 값이 CountryNameEn 이면, 국가 이름을 영어 이름 정렬한다. 기본적으로 한글 정렬.
 * @return mixed
 * - 리턴되는 국가 코드는 대문자이다.
 * - 리턴 값 예) ['US' => '미국', 'KR' => '한국', ... ]
 *
 * @todo 3 자리 국가 코드를 옵션으로 리턴할 수 있도록 한다.
 *
 * @example
<label class="fs-sm" for="countryCode">교민 카페 운영 국가</label>
<select class="form-select" id="countryCode" name="countryCode" aria-label="Country selection box">
    <option selected>국가를 선택해주세요.</option>
        <?
            foreach( country_code() as $co ) {
        ?>
            <option value="<?=$co['2digitCode']?>"><?=$co['CountryNameKR']?></option>
        <? } ?>
</select>
 */
function country_code($sortby='CountryNameKR') {
    $countries = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-code.json'), true);
    usort($countries, function($a, $b) use ($sortby) {
        if ($a[$sortby] == $b[$sortby]) return 0;
        else if ( $a[$sortby] > $b[$sortby] ) return 1;
        else return -1;
    });

    return $countries;
}

/**
 * 국가 코드 2자리를 입력하면, 국가명을 리턴한다.
 *
 * @param $code
 * @param string $lang
 * @return mixed
 */
function country_name($code, $lang="CountryNameKR") {
    $countries = json_decode(file_get_contents(ROOT_DIR . 'etc/data/country-code.json'), true);
    return $countries[$code][$lang];
}

