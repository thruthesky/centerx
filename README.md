# emp

# 해야 할 일

- backend 의 코드를 복사 할 것.
- 기본 코어 말고, plugin 은 관리자 모드에서 설치 과정을 진행하도록 한다. 워드프레스와 동일하게 한다.
  - 이 때, plugins 폴더를 두고, 외부 개발자가 플러그인을 추가 할 수 있도록 한다.
  
- 설치 과정을 backend/model 에서 가져와서 그대로 사용 할 것.

# 설정

- 기본 설정은 root/config.php 에 저장되며, 각 테마에서 설정을 덮어 쓸 수 있다.

## 테마별 설정

- 각 테마별로 설정을 할 수 있다.
- 설정은 root/config.php 의 모든 설정을 덮어 쓸 수 있다. 이 말은 DB 접속 자체를 다른 서버로 할 수 있다는 뜻이다.
  이와 같이 모든 설정을 테마별로 다 변경 할 수 있다.

# 개발자 팁

- 데이터 관리를 Taxonomy(데이터 그룹, 테이블), Entity(레코드) 형태로
  - 데이터를 관리하는데 있어, entity()->create(), entity()->update(), entity()->get() 함수가 사실상 거의 전부이다.
  - User 클래스가 Entity 클래스를 상속하므로, user()->create(), user()->update(), user()->get() 을 사용 할 수 있다.
    - 이 처럼 모든 Taxonomy 클래스가 Entity 객체의 것을 그대로 사용 가능하다.
    - 다만, user()->register() 와 같이 wrapping 해서, 비밀번호 암호화 등의 작업을 한다.
  
- meta 값은 serialize 와 unserilize 가 된다. 즉, 배열을 집어 넣어도 된다.

## 관리자 지정하기

```php
config()->set('admin', 'thruthesky@gmail.com');
d(config()->get('admin'));
```

# 데이터베이스

- 모든 테이블에는 idx, createdAt, updatedAt 이 존재한다.(존재 해야 한다.)
- 레코드가 사용자의 소유를 나타낼 때에는 추가적으로 userIdx 가 존재해야 한다.



## EzSQL 을 통한 DB 관리

- WordPress 에서 사용하는 것과 동일한 것이다.
  
- 조건을 배열로 하지 않고, db()->where(eq(), eq()) 와 같이 한다.

- eq() 와 같은 글로벌 함수는 따로 import 해야 한다.
  
- 예제)
```php
  db()->debugOn(); // 디버깅 시작
  $re = db()->update($this->getTable(), ['field' => 'value'], db()->where( eq(IDX, $this->idx) ));
  db()->debug(); // SQL 출력
```

- 예제)
```php
$result = db()->select('wc_users', 'idx', eq('idx', 77));
d($result);
```