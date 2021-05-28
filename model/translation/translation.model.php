<?php
/**
 * @file translation.model.php
 */
/**
 * Class TranslationModel
 *
 * Translation class can be used on both functional(inside PHP) and restful(by API calling).
 *
 * - For client-end, the app should listen to the `/notifications/translation` document in Firebase realtime database.
 *   And when the document is updated, the app would get the translated text from backend and re-render updated text on app.
 *
 *
 * 언어화 코드는 여러개의 레코드가 모여서 하나의 정보를 구성한다. 따라서, 일반적인 Entity 클래스의 사용 방식과 약간다르다.
 *
 * - For functional use, below is the code sample.
 *
 * ```php
 * d(ln('code', 'default value'));
 *
 * // Another way to display text based on user's language.
 * // This may be better to reduce database access and size.
 * // Consider when you deliver all of the text code to client-end,
 * // It might be painful if the size of translation is big.
 * ln(['en' => 'User Agreements', 'ko' => '이용자 약관', 'ch' => '...', ]);
 * ```
 *
 * - User can use their languages by;
 *
 * ```html
 * <form action="/">
 *  <input type="hidden" name="p" value="setting.language.submit">
 *  <select name="language" onchange="this.form.submit()">
 *      <option value="">Choose language</option>
 *      <?php foreach( SUPPORTED_LANGUAGES as $ln ) { ?>
 *          <option value="<?=$ln?>"><?=ln($ln, $ln)?></option>
 *      <?php } ?>
 *  </select>
 * </form>
 * ```
 *
 * - If `FIX_LANGAUGE` is set, then user language is ignored, and this applies only on web.
 *
 *
 * @example ../tests/next.translation.test.php
 *
 * @property-read string $language
 * @property-read string $code
 * @property-read string $text
 */
class TranslationModel extends Entity
{

    public function __construct(int $idx)
    {
        parent::__construct(TRANSLATIONS, $idx);
    }

    /**
     * - `[ 'code' => 'apple', 'en' => 'Apple', 'ko' => '사과' ]` 와 같이 값을 입력 받아 저장을 한다.
     * - 저장 후, Firebase realtime database 의 notification 도큐먼트에 time 을 업데이트 한다.
     *
     * @param $in
     * @return string
     * - 에러가 있으면 에러 문자열
     * - 저장을 했으면, 'code' 값이 리턴된다.
     */
    public function createCode($in): string {
        if ( !isset($in['code']) || empty($in['code']) ) return e()->empty_code;
        if ( $this->exists([CODE => $in[CODE]]) ) return e()->code_exists;
        foreach( SUPPORTED_LANGUAGES as $ln ) {

            $this->create([
                'language' => $ln,
                'code' => $in[CODE],
                'text' => isset($in[$ln]) ? $in[$ln] : ""
            ]);

        }
//        setRealtimeDatabaseDocument('/notifications/translations', ['time' => time()]);
        if ( $this->hasError ) return $this->getError();
        return $in[CODE];
    }

    /**
     * Update translation cod and text.
     * 코드와 텍스트를 변경한다.
     *
     * - Note, that it will produce error if new code name exists.
     * - 코드를 변경하는 경우, 새로은 코드 이름이 이미 존재한다면, 에러.
     *
     * @param $in
     *   $in['currentCodeName'] is the current code name.
     *   $in['code'] is the new code name.
     *   - To update 'currentCodeName' and 'code' must have same value.
     *   - To change code, 'currentCodeName' must be the currentCodeName, and 'code' should have new code name.
     *   Example input)
     *      ['code' => '...', 'currentCodeName' => '...', 'en' => '...', 'ko' => '...']
     *
     * @return string
     * @throws \Kreait\Firebase\Exception\DatabaseException
     */
    public function updateCode($in):string {
        if ( !isset($in['code']) || empty($in['code']) ) return e()->empty_code;

        if ( $in['currentCodeName'] != $in['code'] ) {
            if ( $this->exists([CODE => $in[CODE]]) ) return e()->code_exists;
        }
        $this->deleteCode($in['currentCodeName']);
        return $this->createCode($in);
    }

    /**
     * 코드 삭제
     * @param string $code
     * @return string $code
     */
    public function deleteCode(string $code): string {
        $idxes = $this->search(where: "code=?", params: [$code]);
        foreach(ids($idxes) as $idx) {
            translation($idx)->delete();
        }
        return $code;
    }

    /**
     * @return array
     *  - Returns two dimensional assoc array with the code as the first dimensional assoc array key.
     *    For instance, it will be in the format of
     *      [ apple => [ 'en' => 'Apple', 'ko' => '사과' ], banana => ... ]
     * @throws Exception
     */
    public function load():array {
        $rets = [];
        foreach( ids($this->search(order: 'code', by: 'ASC', limit: 1234567)) as $idx ) {
            $tr = translation($idx);
            if ( ! isset($rets[ $tr->code ] ) ) $rets[ $tr->code ] = []; // init
            $rets[ $tr->code ][ $tr->language ] = $tr->text;
        }
        return $rets;
    }


    /**
     * @return array
     *  - Returns two dimensional assoc array with the language as the first dimensional assoc array key.
     *    For instance, it will be in the format of
     *      [ en => [ 'apple' => 'Apple', 'banana' => 'Banana', ... ], en => [ 'apple' => 삭과', ... ] ]
     */
    public function loadByLanguageCode():array {
        $rets = [];
        foreach( ids($this->search(order: 'code', by: 'ASC', limit: 1234567)) as $idx ) {
            $tr = translation($idx);

            if (!isset($rets[$tr->language])) $rets[$tr->language] = []; // init
            $rets[$tr->language][$tr->code] = $tr->text;
        }
        return $rets;
    }


    /**
     * 해당 언어의 해당 코드에 해당하는 text 를 리턴한다.
     *
     * 메모리 캐시를 해서, 동일한 코드를 두번 DB 액세스 하지 않도록 한다.
     * 참고로, 가장 좋은 방법은 번역 기능을 하지 않아서, DB 액세스 자체를 사용하지 않는 것이다.
     *
     * @param string $language
     * @param string $code
     * @return mixed
     */
    public function text(string $language, string $code): mixed {

        global $translationCache;

        // 캐시에 존재하면, 캐시 값을 리턴
        if ( isset($translationCache[$code]) && isset($translationCache[$code][$language]) ) return $translationCache[$code][$language];

        // DB 에서 값을 가져와 캐시에 저장하고, 리턴
        $rows = $this->search(select: 'language, code, text', where: "language=? AND code=?", params: [$language, $code]);
        if ( count($rows) ) {
            $translationCache[$code][$language] = $rows[0]['text'];
            return $translationCache[$code][$language];
        }


        // 글로벌 변수에 존재하면, 그 값을 캐시하고, 리턴
        global $translations;
        if ( isset($translations[$code]) && isset($translations[$code][$language]) ) {
            $translationCache[$code][$language] = $translations[$code][$language];
            return $translationCache[$code][$language];
        }

        // 값이 존재하지 않으면, 존재하지 않는 값을 캐시하고, 리턴
        $translationCache[$code][$language] = '';
        return $translationCache[$code][$language];
    }


}

$translationCache = [];

/**
 * Returns Translation instance.
 *
 * @param int $idx
 * @return TranslationModel
 */
function translation(int $idx=0): TranslationModel
{
    return new TranslationModel($idx);
}


function translate(string $code, array $texts = [] ) {
    global $translationCache;
    $translationCache[$code] = $texts;
}