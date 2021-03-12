<?php

/**
 * Class Translation
 *
 * 언어화 코드는 
 *
 */
class Translation extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(TRANSLATIONS, $idx);
    }


    /**
     * @param $in
     * @return string
     * @throws \Kreait\Firebase\Exception\DatabaseException
     */
    public function createCode($in) {
        if ( !isset($in['code']) || empty($in['code']) ) return e()->empty_code;
        foreach( SUPPORTED_LANGUAGES as $ln ) {

            $this->create([
                'language' => $ln,
                'code' => $in[CODE],
                'text' => $in[$ln]
            ]);

        }
        setRealtimeDatabaseDocument('/notifications/translations', ['time' => time()]);
        return $in;
    }

    public function updateCode($in) {
        if ( !isset($in['code']) || empty($in['code']) ) return e()->empty_code;

        if ( $in['currentCodeName'] != $in['code'] ) {
            $re = $this->get('code', $in['code']);
            if ( $re ) return e()->code_exists;
        }
        $this->deleteCode($in['currentCodeName']);
        return $this->createCode($in);
    }
    public function deleteCode($code) {
        $idxes = $this->search(where: "code='$code'");
        foreach(ids($idxes) as $idx) {
            translation($idx)->delete();
        }
    }

    /**
     * @return array
     *  - Returns two dimensional assoc array with the code as the first dimensional assoc array key.
     *    For instance, it will be in the format of
     *      [ apple => [ 'en' => 'Apple', 'ko' => '사과' ], banana => ... ]
     * @throws Exception
     */
    public function load() {
        $rets = [];
        foreach( ids($this->search(limit: 1230000, order: 'code', by: 'ASC')) as $idx ) {
            $row = translation($idx)->get(select: 'idx, language, code, text');
            if ( ! isset($rets[ $row['code'] ] ) ) $rets[ $row['code'] ] = []; // init
            $rets[ $row['code'] ][ $row['language'] ] = $row['text'];
        }
        return $rets;
    }


    /**
     * @return array
     *  - Returns two dimensional assoc array with the language as the first dimensional assoc array key.
     *    For instance, it will be in the format of
     *      [ en => [ 'apple' => 'Apple', 'banana' => 'Banana', ... ], en => [ 'apple' => 삭과', ... ] ]
     */
    public function loadByLanguageCode() {
        $rets = [];
        foreach( ids($this->search(limit: 1230000, order: 'code', by: 'ASC')) as $idx ) {
            $row = translation($idx)->get(select: 'idx, language, code, text');

            if (!isset($rets[$row['language']])) $rets[$row['language']] = []; // init
            $rets[$row['language']][$row['code']] = $row['text'];
        }
        return $rets;
    }


    public function text(string $language, string $code) {
        $rows = $this->search("language='$language' AND code='$code'", select: 'language, code, text');
        if ( count($rows) ) {
            return $rows[0]['text'];
        }
        return '';
    }

}


/**
 * Returns Translation instance.
 *
 * @param int $idx
 * @return Translation
 */
function translation(int $idx=0): Translation
{
    return new Translation($idx);
}
