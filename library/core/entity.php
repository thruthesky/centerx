<?php
/**
 * @file entity.class.php
 */


use function ezsql\functions\{
    eq,
    get_results
};


/**
 * Class Entity
 *
 *
 * - Taxonomy 는 데이터의 종류로서 하나의 테이블이라 생각하면 된다.
 * - Entity 는 하나의 레코드이다.
 * - Entity 를 객체화 할 때, $taxonomy 값(Taxonomy)은 필수이며, $idx (Entity 또는 레코드 번호) 값이 입력되면,
 *   해당 테이블의 해당 레코드 및 연결된 메타 데이터를 읽어 $this->data 에 저장한다.
 *   만약, $idx 에 해당하는 entity 를 찾을 수 없다면, entity_not_found 에러가 설정된다. 그리고 이는 entity(123)->notFound 와 같이 해서 확인 할 수 있다.
 *   즉, category(123), user(123) 과 같이 했을 때, 해당 $idx 에 맞는 레코드가 없으면 에러가 바로 설정이 된다.
 *   따라서, category(123)->exists() == false 와 같이 할 필요 없고, category(123)->hasError 와 같이 하면 된다.
 *   그런데, 카테고리가 존재하는지 안하는지를 확인하기 위해서 category(123) 과 같이 초기화하면, 레코드 전체를 읽으므로 쿼리가 느릴 수 있다.
 *   따라서, 존재하는지 안하는지 확인은 category()->exists([IDX => 123]) 이 낳다.
 *
 * @property-read bool $hasError 현재 객체(Entity instance)에 에러가 있으면 true 값을 가진다.
 * @property-read bool $ok $this->error 에 에러가 설정되지 않았으면, 즉, 아무 이상이 없으면 참을 리턴한다.
 * @property-read int $userIdx 테이블에 userIdx 가 있는 경우만 사용.
 * @property-read bool $notFound 처음 객체를 초기화 할 때, $this->idx 가 0 이거나 해당하는 레코드가 없으면 참을 리턴한다. 즉, 처음 객체를 초기화 할 때, e()->entity_not_found 에러가 발생하는지 확인을 하기 위해서이다.
 * @property-read bool $exists 현재 객체의 $this->idx 가 0 이면, false 아니면 true 이다. 주의 할 점은 함수 $this->exists() DB 에서 $this->idx 또는 조건 값을 검색해서 해당 레코드가 존재하는지 확인을 하지만, $exists 는 그냥 $this->idx 가 0 인지 아닌지만 검사한다.
 * @property-read bool $notExists 는 $this->idx 가 0 이면 true, 아니면 false 이다. $this->notExists() 함수는 DB 에서 확인을 하는데, 이 변수는 그냥 $this->idx 값만 검사한다.
 *
 */

class Entity {

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var string 에러가 있으면 에러 메시지를 지정한다.
     */
    private string $error = '';

    /**
     * Entity constructor.
     * @param string $taxonomy
     * @param int $idx - 테이블(taxonomy)의 레코드(entity) idx. 예를 들어, 사용자의 경우, 사용자 번호.
     *  - $idx may be set dynamically.
     */
    public function __construct(public string $taxonomy, public int $idx)
    {
        /**
         * 객체 초기화. 현재 $this->idx 에 해당하는 entity 를 읽어 $this->data 에 저장.
         */
        if ( $this->idx ) {
            $this->read($this->idx);
        }
    }

    /**
     * Alias of setError(). 짧게 쓰기 위해서, error() 로 쓴다.
     * @param string $code
     * @return $this
     */
    public function error(string $code): self {
        return $this->setError($code);
    }

    /**
     * 에러 문자열을 설정한다. 즉, 에러가 있음을 표시하는 것이다.
     * @param string $code
     * @return $this
     */
    public function setError(string $code): self {
        $this->error = $code;
        return $this;
    }
    public function getError(): string {
        return $this->error;
    }
    public function resetError(): self {
        $this->error = '';
        return $this;
    }

    /**
     * 현재 entity 의 필드 값 1개 또는 레코드 배열 전체를 리턴한다.
     *
     * 주의: 현재 객체에 에러가 설정되어져 있으면 $this->data 에 값이 있어도, 빈 배열 또는 null 이 리턴된다.
     * 따라서, 한번 에러가 발생하면, 더 이상 현재 객체를 사용하지 못한다. 그래서 같은 idx 로 새로운 객체를 만들어 다시 작업을 해야 한다.
     * 에러가 있는 상태에서, entity 삭제시, not your entity 등의 에러가 날 수 있다.
     * 이 부분에 실수 할 수 있으니 유의한다.
     *
     * 참고, $this->v() 는 내부적으로 getData() 를 사용하는 헬퍼 함수이다.
     *
     * @attention When the $field exists in $this->data, it returns the value (Event if it's null or false, it returns the value).
     *
     * @param string|null $field - 값이 주어지면, 특정 필드의 값 1개만 리턴한다.
     * @param mixed|null $default_value
     * @return array|int|float|string|null
     * - 에러가 있으면, $field 가 주어졌으면 null 아니면 빈 배열을 리턴한다.
     *   단, $field 가 주어진 경우, 기본 리턴 값을 $default_value 에 지정 할 수 있다.
     * - 아니면, $field 가 주어진 경우, $field 값. 아니면 전체 배열을 리턴한다.
     *
     *
     */
    public function getData(string $field=null, mixed $default_value=null): array|int|float|string|null
    {
        if ( $field ) {
            if ( $this->hasError ) return null;
            else return isset($this->data[$field]) && !empty($this->data[$field]) ? $this->data[$field] : $default_value;
        } else {
            if ( $this->hasError ) return [];
            return $this->data;
        }
    }

    /**
     * 에러가 설정되었으면, 에러 문자열을 리턴하고, 아니면, data(레코드 + meta + 기타 값) 배열 전체를 리턴한다.
     *
     * 사용처, 이 함수는 클라이언트로 현재 entity 의 data 값을 보내기 위해서 사용된다.
     *
     * @return array|string
     */
    public function response(): array|string {
        if ( $this->hasError ) return $this->getError();
        else return $this->getData();
    }

    /**
     * Alias of $this->getData()
     * $this->data 의 특정 값을 참조한다.
     *
     * @param string $field
     * @param mixed|null $default_value
     * @return array|float|int|string|null
     */
    public function v(string $field, mixed $default_value=null) {
        return $this->getData($field, $default_value);
    }



    /**
     * @param $attr
     * @return float|array|bool|int|string|null
     * @deprecated Use getData($field)
     */
    public function getAttribute($attr): float|array|bool|int|string|null
    {
        return $this->getData($attr);
//        if ( $this->hasError ) return null;
//        if ( isset($this->data[$attr]) ) return isset($this->data[$attr]);
//        else return null;
    }


    /**
     * Set memory data. It does not change database.
     *
     * 현재 entity 의 $data 값을 변경한다.
     * 주의, 이 함수는 메모리의 $data 변수 값만 바꾼다. DB 를 바꾸려면 `$this->update()` 를 사용해야한다.
     *
     * 이렇게 하면 idx 부터 모두 바뀌므로, 완전 다른 entity 가 된다.
     * @param array $data
     */
    public function setMemoryData(array $data) {
        $this->data = $data;
        if ( isset($this->data[IDX]) ) $this->idx = $this->data[IDX];
    }


    /**
     * 입력된 $entity 의 모든 properties 를 현재 객체의 properties  업데이트해서 리턴한다.에
     * 즉, 현재 객체를 입력된 $entity 로 바꾸어서 리턴한다.
     * 다시 말하면, 객체 entity $A, $B 가 있는 경우, $A 의 이전 값들을 모두 버리고, $B 의 것을 복사해서 쓰기 위한 것이다.
     * read() 와 비슷한데, read 는 DB 로 부터 레코드를 읽어, 현재 객체에 지정하는데, 만약, 다른 객체의 레코드를 read() 해야 한다면, copyWith() 은 DB 접속을 한 번 줄일 수 있게 해 준다.
     *
     * 사용 예)
     *  - $A 로 작업을 하다가, $A 에는 에러가 설정되었는데, $A 의 많은 정보를 그대로 유지하면서, $B 가 가진 모든 정보들 만 $A 로 복사해서 쓰는것이다.
     *  - $B 를 $C 로 복사해서, $B 를 $C 로 복사(백업)한 두 개를 따로 사용 할 수 있다. 객체가 reference 로 연결되지 않고, 별개로 분리된다.
     *
     * @param $entity
     * @return Entity
     *
     * @example tests/cache.test.php 에서 캐시 객체를 복사(백업)해서, 사용하는 예제를 볼 수 있다.
     */
    public function copyWith($entity): self {
        $this->setMemoryData($entity->data);
        $this->taxonomy = $entity->taxonomy;
        $this->error = $entity->error;
        return $this;
    }


    /**
     * @deprecated Use updateMemoryData().
     * $this->data 배열을 업데이트한다. 키가 존재하지 않으면 추가한다.
     * 주의, 이 함수는 메모리의 $data 변수 값만 바꾼다. DB 를 바꾸려면 `$this->update()` 를 사용해야한다.
     *
     * $this->setData() 는 $this->data 배열 전체를 바꾸는 것이며 $this->idx 까지 바꾼는데, 이 함수는 특정 필드 1개만 바꾼다.
     *
     * @param $k
     * @param $v
     *
     * @return self
     * @example
     * category(123)->updateData('subcategories', separateByComma($this->subcategories));
     */
    public function updateData($k, $v): self {
        return $this->updateMemoryData($k, $v);
    }

    /**
     * @deprecated
     * @param $k
     * @param $v
     * @return $this
     */
    public function updateMemory($k, $v): self {
//        $this->data[$k] = $v;
//        return $this;
        return $this->updateMemoryData($k, $v);
    }



    /**
     * 현재 객체의 속성을 담은 $this->data 배열을 업데이트한다. 키가 존재하지 않으면 추가한다.
     *
     * 주의, 이 함수는 메모리의 $data 변수 값만 바꾼다. DB 를 바꾸려면 `$this->update()` 를 사용해야한다.
     *
     * $this->setData() 는 $this->data 배열 전체를 바꾸는 것이며 $this->idx 까지 바꾼는데, 이 함수는 특정 필드 1개만 바꾼다.
     *
     * @param $k
     * @param $v
     *
     * @return self
     * @example
     * category(123)->updateData('subcategories', separateByComma($this->subcategories));
     */
    public function updateMemoryData($k, $v): self {
        $this->data[$k] = $v;
        return $this;
    }




    /**
     * 필드를 가져오는 magic getter
     *
     * posts 테이블과 meta 테이블에서 데이터를 가져오고, 레코드가 없으면 null 를 리턴한다.
     * @attention 주의 할 것은,
     *  1. 객체 초기화를 할 때, init() 함수에서
     *  2. posts 테이블의 필드는 멤버 변수로 설정하고,
     *  3. 그리고 posts 테이블과 meta 테이블의 모든 값은 $data 에 저장한다.
     *  4. magic getter 로 값을 읽을 때, 새로 DB 에서 가져오는 것이 아니라, (멤버 변수로 설정되지 않았다면, 즉, meta 의 경우,) $data 에서 가져온다.
     *     (참고로, 멤버 변수는 magic getter 호출에 사용되지 않는다.)
     *  5 $this->update() 를 하면, 다시 init() 을 호출 한다.
     *
     * 주의: 에러가 있으면 null 이 리턴된다.
     *
     * @param $name
     * @return mixed
     *
     * @example
     *  $post->update(['eat' => 'apple pie']);
     *  isTrue($post->eat == 'apple pie', 'Must eat apple pie');
     */
    public function __get($name): mixed
    {
        /// `$this->hasError` 에러가 있으면 true 를 리턴
        if ( $name == 'hasError' ) {
            return $this->error !== '';
        }
        /// $this->error 에 에러가 설정되지 않았으면, 즉, 아무 이상이 없으면 참을 리턴한다.
        if ( $name == 'ok' ) {
            return ! $this->hasError;
        }
        if ( $name == 'exists' ) return $this->idx > 0;
        if ( $name == 'notExists' ) return $this->idx == 0;

        /// 처음 객체를 초기화 했을 때,
        /// - $this->idx 가 0 이거나,
        /// - $this->idx 에 해당하는 레코드를 찾지 못하면
        /// 곧 바로 entity_not_found 가 설정되는데, $this->notFound 가 참을 리턴한다.
        if ( $name == 'notFound' ) {
            if ( $this->idx == 0 ) return true;
            else if ( $this->getError() == e()->entity_not_found ) return true;
            else return false;
        }

        /// 필드 값을 가져오려고 할 때, 현재 객체에 에러가 있으면, null 을 리턴.
        if ( $this->hasError ) return null;

        /// 에러가 없으면 값을 리턴. 값이 없으면 null 리턴.
        if ( $this->data && isset($this->data[$name]) ) return $this->data[$name];
        else return null;
    }


    /**
     * 주의: $this->data 배열 이 외의 것은 이 함수로 호출되지 않는다. 실제 존재하는 멤버 변수는 이 함수로 호출되지 않는다.
     * @param $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return isset($this->data[$name]);
    }








    /**
     * Create a entity(record) with given $in.
     *
     * 새로운 레코드 생성 후, 전체 레코드를 읽어서, 현재 객체로 전환한다.
     *
     *
     * entity 에 필드를 저장한다.
     *
     * 만약, Taxonomy 테이블에 존재하지 않는 필드가 입력되면, 자동으로 metas 테이블에 저장한다.
     *
     * 주의: $in 배열 변수의 키와 레코드 필드 명이 동일해야합니다.
     * 참고: 만약, 레코드 필드명에 존재하지 않는 키가 있으면, meta 테이블의 code, value 에 키/값이 저장된다.
     * 참고, 에러가 설정되어져 있으면, (이전에 에러가 있었으면) 생성을 하지 않고, 그냥 현재 객체를 리턴한다.
     *
     * 생성 후, 현재 객체에 보관한다. $this->idx 도 현재 생성된 객체로 변경된다.
     *
     * @param array $in
     *
     *
     * - error string on error.
     * - entity record on success.
     *
     *
     * @note user is_success() to check if it was success()
     *
     *
     * @example
     * $idx = entity(CATEGORIES)->create($in);
     * return entity(CATEGORIES, $idx)->get();
     *
     *
     * @see readme for detail.
     *
     *
     */
    public function create( array $in ): self {

        if ( ! $in ) return $this->error(e()->empty_param);

        /// If idx is set and has value, return error.
        if ( isset($in[IDX]) ) {
            if ( $in[IDX] ) return $this->error(e()->idx_must_not_set);
            else unset($in[IDX]); /// isset() 인데, falsy 이면, unset.
        }

        //
        $record = $this->getRecordFields($in);
        $record[CREATED_AT] = time();
        $record[UPDATED_AT] = time();

        // Hook before entity create
        $re = hook()->run("{$this->taxonomy}-before-create", $record, $in);
        // If there is error after hook, then return error.
        if ( isError($re) ) return $this->error($re);


//        debug_log("db()->insert(table: ", $this->getTable());
//        debug_log("db()->insert(record: ", $record);

        $idx = db()->insert( $this->getTable(), $record );

        if ( !$idx ) return $this->error(e()->insert_failed);

        meta()->creates($this->taxonomy, $idx, $this->getMetaFields($in));


        // read entity
        $this->read($idx);

        // Hook after entity create
        $re = hook()->run("{$this->taxonomy}-after-create", $this->data, $in);
        // If there is error after hook, then return error.
        if ( isError($re) ) return $this->error($re);

        return $this;
    }




    /**
     * Update an entity.
     *
     * 수정 후, 전체 레코드를 읽어 들인다.
     * 주의, 기존의 $this->data 변수가 모두 리셋된다. 즉, 메모리 변수의 값 전체가 사라지고, 새로 DB 에서 읽어들인다. 이것은 $this->read() 때문에 그렇다.
     *
     * @attention entity.idx must be set.
     *
     * 업데이트를 하기 위해서는 `$this->idx` 가 지정되어야 하며, $in 에 업데이트 할 값을 지정하면 된다.
     * 참고, $in 이 빈 값으로 들어 올 수 있다. 그러면 updatedAt 만 업데이트를 한다.
     *
     * Taxonomy 에 존재하지 않는 필드는 meta 에 자동 저장(추가 또는 업데이트)된다.
     *
     * 참고, 업데이트 후 $this->read() 를 통해서 현재 객체의 $this->data 에 DB 로 부터 새로 데이터를 다시 읽는다.
     * 참고, 에러가 설정되어져 있으면, (이전에 에러가 있었으면) 업데이트를 하지 않고, 그냥 현재 객체를 리턴한다.
     * 참고, 에러, 퍼미션 점검은 이 함수를 호출하기 전에 미리 해야 한다.
     * 참고, createdAt 은 업데이트하지 않는다. 하지만 cache.class.php 처럼, 원한다면, 프로그래밍적으로 직접 업데이트를 할 수 있다.
     *
     * @param $in - 연관 배열. 키/값을 바탕으로 한 사용자 추가 메타 업데이트
     *
     * @return self
     * - error string on error.
     * - or the entity record.
     *
     *
     * 예제)
     *  d(user(77)->update(['name'=>'name 77', 'a' => 'apple', 'color' => 'myColor']));
     *
     * 예제) 로그인 한 사용자의 프로필 정보를 FORM 으로 입력 받아 수정
     *  login()->update(in());
     *  d(login()->profile());
     *
     * 예제)
     *  $this->idx = 123;
     *  $this->update(['color' => 'blue']);
     *
     * @todo 훅 처리
     */
    public function update(array $in): self {
        if ( $this->hasError ) return $this;

        if ( ! $this->idx ) return $this->error(e()->idx_not_set);

        // 레코드에 있는 필드들을 업데이트
        $up = $this->getRecordFields($in);
        $up[UPDATED_AT] = time();

        $re = db()->update($this->getTable(), $up, [IDX => $this->idx]);
        if ( $re === false ) return $this->error(e()->update_failed);

        // 레코드에 없는 필드들은 메타에 업데이트
//        debug_log("update: tax: {$this->taxonomy}, entity: {$this->idx}, meta fields: ", $this->getMetaFields($in));
//        updateMeta($this->taxonomy, $this->idx, $this->getMetaFields($in));


        meta()->updates($this->taxonomy, $this->idx, $this->getMetaFields($in));

        return $this->read();
    }

    /**
     * 레코드 삭제
     * Delete records.
     *
     * 참고, 이전에 에러가 발생했으면, 삭제하지 않고, 그냥 현재 객체를 리턴한다.
     * 참고, 삭제 후, $this->data 는 빈 배열로 되지만, $this->idx 값은 유지한다.
     * 참고, 에러가 있으면 에러가 설정된다.
     *
     * @attention When it is deleted, the entity record had removed immediately from the table but the data still exists
     * in memory. So to check if it is deleted, you may need to check if there was an error after delete.
     * @attention You can still use deleted data since it is alive in $this->data variable.
     *
     * @return self
     *
     * @todo entity 레코드 뿐만아니라, 메타 데이터도 삭제를 해야한다. 그리고 첨부 파일도 같이 삭제를 해야 한다.
     */
    public function delete(): self {
        if ( $this->hasError ) return $this;
        if ( ! $this->idx ) return $this->error(e()->idx_not_set);
        $re = db()->delete($this->getTable(), [IDX => $this->idx]);
        if ( $re === false ) return $this->error(e()->delete_failed);
        return $this;
    }


    /**
     * It does not delete the record. But mark it as deleted by updating deletedAt.
     *
     * You may empty the content of the record when that is deleted.
     *
     * @attention `idx` must be set.
     *
     * @return self
     * - error string on error.
     * - the deleted record on success.
     *
     */
    public function markDelete(): self {
        if ( $this->hasError ) return $this;
        if ( ! $this->idx ) return $this->error(e()->idx_not_set);
        if ( $this->deletedAt > 0 ) return $this->error(e()->entity_deleted_already);
        return self::update([DELETED_AT => time()]);
    }

    /**
     * 현재 Taxonomy 를 유지한 채, entity 만 바꾸고자 할 때 사용.
     * 사실 이것은 read(123) 와 같은 것이다.
     *
     * 주의, 기존 에러 설정을 없앤다. 즉, 기존에 에러가 있었던 객체에 reset() 을 하면 에러가 사라지고,
     * 입력된 $idx 로 초기화 된다.
     *
     * @param int $idx
     * @return $this
     *
     * @example 삭제 실패한 코멘트를 다시 삭제 표시만 하기
     *  isTrue($comment->delete()->getError() == e()->comment_delete_not_supported);
     *  isTrue($comment->reset($comment->idx)->markDelete()->deletedAt > 0);
     */
    public function reset(int $idx): self {
        $this->setError('');
        return $this->read($idx);
    }


    /**
     * Entity(레코드와 메타)를 DB 로 부터 읽어 현재 객체에 보관한다.
     *
     * $idx 가 주어지면, 해당 $idx 를 읽어, 현재 객체의 $data 에 보관하고, $this->idx = $idx 와 같이 entity idx 도 업데이트 한다.
     * $idx 가 주어지지 않았거나, 객체를 생성 할 때, $idx 가 주어지지 않았다면, 빈 배열을 보관한다.
     *
     * $idx 가 주어졌는데, 레코드를 찾을 수 없다면, entity_not_found 에러를 저장한다.
     *
     * 주의: 이 함수 호출 이전에 에러가 있었으면, 그대로 리턴한다. 즉, 에러가 있으면 이 함수를 사용 할 수가 없다.
     * 따라서, login(), register() 등의 함수에서 필요한 작업을 하기 전에 미리 이전 에러를 초기화 해 줄 필요가 있다.
     *
     * @usage 처음 객체 생성시, read() 를 한번 호출한다.
     *  그 후에 $idx 를 주어서 $entity->read(123) 과 같이 호출 하면, entity.idx 와 data 를 바꾼다.
     *  또는 데이터베이스로 부터 새로 정보를 읽고자 할 때 사용한다.
     *
     * @param int $idx
     * @return self
     */
    public function read(int $idx = 0): self {


        if ( $this->hasError ) return $this;

        if ( ! $idx ) $idx = $this->idx;

        $q = "SELECT * FROM {$this->getTable()} WHERE idx = ?";


//        d("read() q: $q");

        $record = db()->row($q, $idx);

        if ( $record ) {

            $meta = meta()->get($this->taxonomy, $idx);
            $this->setMemoryData(array_merge($record, $meta));
            $this->idx = $this->data['idx'];
        } else {
            $this->error( e()->entity_not_found );
            $this->setMemoryData([]);
        }


        return $this;
    }


    /**
     * Switch `on` or `off` on the $optionName.
     *
     * To know if it is `on` or `off`, just use `$this->v($optionName)`. If it returns null, then it never switched.
     *
     * @param string $optionName
     * @return self
     */
    public function switch(string $optionName): self {
        if ( empty($optionName) ) return $this->error(e()->option_is_empty);

        $v = $this->v($optionName);
        if ( empty($v) || $v == 'off' ) {
            $v = 'on';
        } else {
            $v = 'off';
        }
        return $this->update([$optionName => $v]);
    }

    /**
     * Switch On
     *
     * @param string $optionName
     * @return $this
     */
    public function switchOn(string $optionName): self {
        return $this->update([$optionName => 'on']);
    }

    /**
     * Switch Off
     *
     * @param string $optionName
     * @return $this
     */
    public function switchOff(string $optionName): self {
        return $this->update([$optionName => 'off']);
    }


    /**
     * Get idx
     *
     * Query to database based on the $conds and return idx.
     * @param array $conds
     * @param string $conj
     * @return int
     *  - integer if a record is found.
     *  - 0 if no record found.
     *
     */
    public function getIdxFromDB(array $conds, string $conj = 'AND'): int
    {
        $arr = self::search(conds: $conds, conj: $conj);
        if ( count($arr) ) return $arr[0][IDX];
        else return 0;
    }



    /**
     * Get field value
     *
     * Query to database and return a field value of a record based on the $conds.
     * If you don't need to query to database, then user $this->getData() to get the data from memory.
     *
     * 현재 Taxonomy 에서 1개의 레코드를 검색해서, 1개의 필드 값을 리턴한다.
     *
     * @param string $select - 1개의 필드만 입력해야 한다. 그 필드의 값을 리턴한다.
     * @param array $conds
     * @param string $conj
     * @return mixed
     *  - the value of the field.
     *  - or `null` if no record found.
     *
     * 예제) 현재 글(코멘트)의 루트 글의 카테고리 값 얻기
     *  post()->getVar(CATEGORY_IDX, [IDX => $rootIdx]);
     *
     * 예제) 현재 객체(예: 사용자 entity)의 point 필드의 값 얻기. 사용자의 포인트 값을 얻을 때 사용.
     *  $this->getVar(POINT, [IDX => $this->idx]);
     */
    public function column(string $select, array $conds, string $conj='AND'): mixed {
        $arr = self::search(select: $select, conds: $conds, conj: $conj, limit: 1);
        if ( ! $arr ) return null;
        return $arr[0][$select];
    }





    /**
     * DB 레코드에서 idx (또는 조건 배열)를 읽어서 존재하는지 아닌지 검사한다. 따라서 DB 접속을 원하지 않으면, 그냥 $this->idx 가 0 인지 아닌지 검사해도 된다.
     *
     * 참고, $conds 에 값이 넘어오면, 해당 조건에 존재하는 레코드가 있는지 확인한다.
     *  이 때, search() 함수를 사용하는데, search() 함수의 특성에 따라 $conds 조건에 맞는 여러개의 레코드가 존재 할 수 있다.
     *  만약, $conds 이 들어오지 않으면, $this->idx 로 검사하는 데, 오직 현재 레코드가 존재하는지만 검사한다.
     *  $conds 에 값이 넘어오지 않고, $this->idx 가 0 이면, false 가 리턴된다.
     *
     * 참고, DB 접속을 매번하므로, 원격 DB의 경우 connection 시간이 걸릴 수 있다.
     *
     *
     *
     * 참고, 카테고리가 존재하는지 안하는지를 확인하기 위해서 category(123) 과 같이 초기화하면, 레코드 전체를 읽으므로 쿼리가 느릴 수 있다.
     * 따라서, 존재하는지 안하는지 확인은 category()->exists([IDX => 123]) 이 낳다.
     * 예) 카테고리 존재하면 에러
     *  if ( category()->exists([ ID=>$in[ID] ]) ) return $this->error(e()->category_exists);
     *
     * @param array $conds
     * @param string $conj
     * @return bool
     *
     * @example
     *  $found = $this->exists([EMAIL=>$in[EMAIL]]);
     *  entity('...')->findOne([...])->exists(); // findOne() 에서 객체를 찾지 못했다면, $this->idx=0 이 되고, 에러가 설정된다. 그리고, ->exists() 에서는 false 가 리턴된다.
     */
    public function exists(array $conds = [], string $conj = 'AND'): bool {
        if ( $conds ) { // 조건 배열이 입력되면, 조건이 맞는 레코드가 존재하는지 확인.
            return self::getIdxFromDB($conds, $conj) > 0;
//            $arr = self::search(conds: $conds, conj: $conj);
//            return count($arr) > 0;
        }


        if ( ! $this->idx ) { // $this->idx 가 0 이면, false
            return false;
        }


        // Search the record.
        $rows = self::search(conds: [IDX => $this->idx]);
        return count($rows) > 0;

/*
        // Get the record of the idx.
        $q = "SELECT " . IDX . " FROM " . $this->getTable() . " WHERE " . IDX . " = ? ";
        $re = db()->column($q, $this->idx);
        if ( $re ) return true;
        else return false;
        */
    }


    /**
     * 검색 조건 없이 $this->idx 만으로 DB 에 레코드가 존재하는지 확인을 한다. DB 액세스를 한번 한다.
     * @return bool
     */
    public function notExists(): bool {
        return !$this->exists();
    }

    /**
     * 특정 레코드를 1개 찾아 현재 객체로 변환(변경)하여 리턴한다.
     *
     * 주의: 현재 Taxonomy 의 Entity 객체로 변환해서 리턴한다. 만약, 파일이 없으면, entity_not_found 에러가 설정된 Entity 객체가 리턴된다.
     *
     * 예를 들어, `user()->by('thruthesky@gmail.com')` 와 같이 호출하면, by() 가 리턴하는 값은
     * thruthesky@gmail.com 사용자의 User 객체가되는 것이다.
     *
     * $this->exits() 와 다른 점은 exists() 는 주어진 조건에 맞는 레코드가 존재하는지 확인하여 boolean 을 리턴한다.
     * 그리고 만약, 주어진 조건이 없으면 현재 $this->idx 의 레코드가 존재하는지 확인해서 boolean 을 리턴한다.
     *
     * 하지만, $this->find() 는 주어진 조건에 맞는 레코드 들 중 1개를 *현재 객체로 변경*하여 리턴한다.
     *
     * 예제) 아래의 코드에서 $user1 은 처음에는 1번 사용자였는데, by() 함수를 호출함에 따라 $user1 이 더이상 1번 사용자가 아니라 thruthesky@gmail.com 으로 변경이 된다.
     *      $user1 = user(1);
     *      $user1->by('thruthesky@gmail.com');
     *      isTrue($user1->email == 'thruthesky@gmail.com');
     *
     *  by() 함수를 호출 할 때, $this->idx 가 설정되지 않아도 되며, 설정되어져 있어도 무시된다.
     *  주어진 조건에 레코드를 찾지 못하면 에러가 설정된다.
     *
     * @param array $conds
     * @param string $conj
     * @return self
     *
     * @example
     *  $user = user()->find([EMAIL => $uid]); // Find user by email
     */
    public function findOne(array $conds, string $conj = 'AND'): self {

        $arr = self::search(conds: $conds, conj: $conj, limit: 1); // 현재 객체의 search() 만 호출. 자식 클래스의 search() 는 호출하지 않음.

        if ( ! $arr ) return $this->error(e()->entity_not_found);
        $idx = $arr[0][IDX];

        return $this->read($idx);
    }


    /**
     * entity 를 찾아서 현재 객체 배열을 리턴한다.
     *
     * search() 와 다른 점은 search() 는 레코드를 배열로 리턴하는데, find() 는 객체 배열로 리턴한다.
     *
     * @param array $conds
     * @param string $conj
     * @param string $order
     * @param string $by
     * @param int $limit - 기본적으로 100 개만 리턴.
     * @return self[]
     */
    public function find(array $conds, string $conj = 'AND', string $order='idx', string $by='DESC', int $limit=100): array {
        $rows = self::search( conds: $conds, conj: $conj, order: $order, by: $by, limit: $limit); // 현재 객체의 search() 만 호출. 자식 클래스의 search() 는 호출하지 않음.
        $rets = [];
        foreach( $rows as $row ) {
            $rets[] = clone $this->read($row[IDX]);
        }
        return $rets;
    }
    

    /**
     * Returns true if the entity is belong to the login user.
     *
     * @attention The entity(entity) idx must be set and the record must have `userIdx` field or false will be returned.
     *   So, login()->isMine() will not work since user record has no `userIdx` field.
     *
     * @usage Use this method to check if the post or comment, file are belong to the login user.
     *
     * @return bool
     */
    public function isMine(): bool {
        if ( notLoggedIn() ) return false;
        if ( ! $this->idx ) return false;

        if ( $this->userIdx == null ) return false;

        return $this->userIdx == login()->idx;
    }



    /**
     * 현재 Taxonomy 를 검색해서 idx 를 배열로 리턴한다.
     *
     * - $where 에 필요한 조건식을 다 만들어 넣는다.
     * - 만약, meta 데이터를 포함한 전체 값이 다 필요하다면, 이 함수를 통해서 'idx' 만 추출한 다음, user(idx)->get() 와 같이 한다.
     * - 이 함수는 객체 배열이 아닌, 결과를 가지고 있는 레코드들의 idx 만 리턴한다.
     * - 원한다면 select: 'name' 또는 select: '*' 와 같이 특정 레코드 또는 전체 레코드를 배열로 리턴 할 수 있다.
     * - 하나의 레코드 또는 하나의 필드를 가져오고자 할 때 사용 할 수 있다.
     *
     *
     * @param string $select
     * @param string $where
     * @param array $params
     * @param string $order
     * @param string $by
     * @param int $page
     * @param int $limit
     * @param array $conds - 키/값 조건문.
     * @param string $conj - $conds 의 키/값을 연결할 조건식. 기본 AND.
     * @param bool $object
     *  If this is set to true, then it will return entities of the result records. And $select will be ignored since,
     *  the returned entity will load all the data into entity.
     *
     *
     *
     * @return array - empty array([]), If there is no record found.
     *  - empty array([]), If there is no record found.
     *
     *
     * @example tests/next.entity.search.test.php 에 많은 예제가 있다.
     *
     * 예제) 로그인 시, 특장 사용자의 비밀번호를 찾아 비교하기 위해서, 비밀번호 가져오기.
     *  $users = $this->search(select: PASSWORD, conds: [EMAIL => $in[EMAIL]]);
     *  if ( !$users ) return $this->error(e()->user_not_found_by_that_email);
     *  $password = $users[0][PASSWORD];
     *
     * 예제)
     *  user()->search();
     *  user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 2, limit: 3, select: 'idx, name');
     *
     * 예제) 사용자 idx 만 추출해서 전체 정보 출력
     *   $users = user()->search(where:  "name LIKE '%a%' AND idx < 100", order: EMAIL, by: 'ASC', page: 1, limit: 3);
     *   foreach( $users as $user) {
     *      d( user( $user[IDX] )->profile() );
     *   }
     *
     * 참고,
     * 예제) 하위 entity 객체에서 search() 를 override 하는 것은 주로, search 의 결과를 객체로 변환하기 위해서이다.
     *      객체로 변환하는 경우, 모든 필드를 다 읽어야하고, 또 클라이언트로 전달하기 위해서는 배열로 변환해야 한다.
     *      그래서, 필요한 경우, entity(...)->search 와 같이 해서 원하는 필드만 가져온다.
     *
     *  entity(POINT_HISTORIES)->search(where: "fromUserIdx=$myIdx OR toUserIdx=$myIdx", limit: 200, select: 'idx,reason');
     *
     * @example Below is a good example on how you can use GROUP BY to count and order.
     * ```
     * $rows = comment()->search(
     *      select: "userIdx, COUNT(*) as noOfComments",
     *      where: "createdAt>? AND parentIdx>? GROUP BY userIdx",
     *      params: [$past7days, 0],
     *      order: "noOfComments",
     *      limit: 5);
     * ```
     * @todo SQL injection
     * @todo $where 에 따옴표 처리.
     *
     *
     */
    public function search(
        string $select='idx',
        string $where='1',
        array $params = [],
        array $conds=[],
        string $conj = 'AND',
        string $order='idx',
        string $by='DESC',
        int $page=1,
        int $limit=10,
        bool $object = false,
    ): array {
        $table = $this->getTable();
        $from = ($page-1) * ($limit ? $limit : 10);

        if ( $conds ) {
            list( $fields, $placeholders, $values ) = db()->parseRecord($conds, 'select', $conj);
            $q = " SELECT $select FROM $table WHERE $placeholders ORDER BY $order $by LIMIT $from, $limit ";
            $rows = db()->rows($q, ...$values);
        } else if ( $where != '1' || $params ) { // prepare statement if $params is set.
            $q = " SELECT $select FROM $table WHERE $where ORDER BY $order $by LIMIT $from,$limit ";
            $rows = db()->rows($q, ...$params);
        }
        else if ( $where == '1' ) {
            $q = " SELECT $select FROM $table WHERE $where ORDER BY $order $by LIMIT $from,$limit ";
            $rows = db()->rows($q);
        }
        else  {
            debug_print_backtrace();
            die("\n\n-------------------- die on Entity::search() => Wrong parameters. is \$params set properly?\n\n");
        }


        /// 현재 entity 레코드를 배열로 리턴받기 원하면,
        if ( $object == false ) return $rows;


        /// 현재 entity 를 객체에 넣어 리턴 받기 원하면,
        /// Note, if the return data of should be entity objects, then it will load all the record and its meta into the entity object.
        /// So, 'select' is ignored.
        $rets = [];
        foreach( ids($rows) as $idx ) {
            $entity = clone $this;
            $rets[] = $entity->read($idx);
        }
        return $rets;

    }

    /**
     * @param string $where
     * @param array $params
     * @param array $conds
     * @param string $conj
     * @return int
     */
    public function count(string $where='1',
                          array $params = [],
                          array $conds =[],
                          string $conj = 'AND'): int {
        $table = $this->getTable();
        $select = "COUNT(*)";

        if ( $conds ) {
            list( $fields, $placeholders, $values ) = db()->parseRecord($conds, 'select', $conj);
            $q = " SELECT $select FROM $table WHERE $placeholders";
            $count = db()->column($q, ...$values);
        } else if ( $where != '1' || $params ) { // prepare statement if $params is set.
            $q = " SELECT $select FROM $table WHERE $where";
            $count = db()->column($q, ...$params);
        }
        else if ( $where == '1' ) {
            $q = " SELECT $select FROM $table WHERE $where";
            $count = db()->column($q);
        }
        else  {
            debug_print_backtrace();
            die("\n-------------------- die() - Execution dead due to: Entity::count() wrong parameters\n");
        }

        return $count;
    }




    /**
     * Returns login user's records in array.
     *
     * Helper class for search().
     * It does very much the same as search(), but returns the login user's record only.
     *
     *
     * @param int $page
     * @param int $limit
     * @param string $order
     * @param string $by
     * @return array
     */
    public function my(int $page=1, string $order='idx', string $by='DESC', int $limit=10 ): array {
        return $this->search(
            where: "userIdx=?", params: [ login()->idx ],
            order: $order,
            by: $by,
            page: $page,
            limit: $limit,
            object: true
        );
    }





    /**
     * 현재 taxonomy 의 테이블 이름을 리턴한다.
     * @return string
     */
    public function getTable(): string {
        return DB_PREFIX . $this->taxonomy;
    }


    /**
     * 입력된 $in 에서 현재 테이블의 레코드 필드인 것만 리턴한다.
     * 예를 들어, 사용자 테이블에 'email', 'password', 'name' 필드가 있는데, $in 이 ['email'=>'..', 'name'=>'..', 'yourColor'=>'blue']
     * 의 값이 들어오면, ['email' => '..', 'password'=>'..'] 가 리턴된다.
     * @param $in
     * @return array
     * - 리턴할 값이 없으면 빈 배열이 리턴된다.
     *
     * 예제)
     * d(entity(USERS)->getRecordFields(['email' => 'email@address.com', 'name' => 'name', 'yourColor' => 'blue']));
     * 결과)
     *  Array ( [email] => email@address.com [name] => name )
     */
    public function getRecordFields($in): array {
        $fields = entity($this->taxonomy)->getTableFieldNames();
        $diffs = array_diff(array_keys($in), $fields);
        return array_filter( $in, fn($v, $k) => !in_array($k, $diffs), ARRAY_FILTER_USE_BOTH );
    }



    /**
     * @return array
     *
     * 예제)
     *  d(entity(USERS)->getTableFieldNames());
     * 결과)
     * Array ( [0] => idx [1] => email [2] => password [3] => name [4] => createdAt [5] => updatedAt )
     *
     * @note 메모리 캐시를 한다.
     *
     * @todo EzSQL 의 col_info 를 사용해서, 다른 DB 도 지원 할 수 있도록 한다.
     */
    private $fields = [];
    public function getTableFieldNames(): array {
        $table = $this->getTable();
        if ( isset($this->fields[$table]) ) return $this->fields[$table];
//        $q = "SELECT column_name FROM information_schema.columns WHERE table_schema = '".DB_NAME."' AND table_name = '$table'";
//        $rows = db()->rows($q);
//        $names = [];
//        foreach($rows as $row) {
//            $names[] = $row['column_name'];
//        }
//        $this->fields[$table] = $names;

        $this->fields[$table] = db()->fieldNames($table);
        return $this->fields[$table];
    }

    /**
     * 입력된 $in 에서 현재 테이블의 레코드 필드가 아닌 것들을 리턴한다.
     *
     * 예를 들어, 사용자 테이블에 'email', 'password', 'name' 필드가 있는데, $in 이 ['email'=>'..', 'name'=>'..', 'yourColor'=>'blue']
     * 의 값이 들어오면, ['yourColor' => 'blue'] 가 리턴된다.
     *
     * @param $in
     * @return array
     * - 모두, 레코드 필드이면, 빈 배열을 리턴한다.
     *
     * 예제)
     * d(entity(USERS)->getMetaFields(['email' => 'email@address.com', 'name' => 'name', 'yourColor' => 'blue']));
     * 결과)
     * Array ( [yourColor] => blue )
     *
     */
    public function getMetaFields($in): array {
        $fields = entity($this->taxonomy)->getTableFieldNames();
        $diffs = array_diff(array_keys($in), $fields);
        return array_filter( $in, fn($v, $k) => in_array($k, $diffs), ARRAY_FILTER_USE_BOTH );
    }


    /**
     * Check if the login user has permission on the entity.
     *
     * If the user has no permission, or for other errors occurs, error will be set to the entity.
     *
     *
     *
     * @return self
     *
     * @note the following errors will be set,
     * `not_logged_in` for not logged in,
     * `idx_is_empty` for idx is empty.
     * `not_your_post` for user does not own the post. and the user is not admin.
     *
     * @example
     * ```
     *   $post = post(in(IDX))->permissionCheck()->update(in()); // update if user has permission.
     *   if ( $post->ok ) { // update was ok with permission check.
     *     $categoryId = $post->categoryId();
     *   }
     * ```
     */
    public function permissionCheck(): self {
        if ( notLoggedIn() ) return $this->error(e()->not_logged_in);
        if ( ! $this->idx ) return $this->error(e()->idx_is_empty);
        if ( $this->isMine() == false && admin() == false ) return $this->error ( e()->not_your_entity );
        return $this;
    }


}


/**
 * Entity 는 taxonomy 가 입력되므로, 항상 객체를 생성해서 리턴한다.
 * @param string $taxonomy
 * @param int $idx
 * @return Entity
 */
function entity(string $taxonomy, int $idx=0): Entity
{
    return new Entity($taxonomy, $idx);
}
