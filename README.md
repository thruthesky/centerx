# emp

# 해야 할 일

- backend 의 코드를 복사 할 것.
- 기본 코어 말고, plugin 은 관리자 모드에서 설치 과정을 진행하도록 한다. 워드프레스와 동일하게 한다.
  - 이 때, plugins 폴더를 두고, 외부 개발자가 플러그인을 추가 할 수 있도록 한다.
  
- 설치 과정을 backend/model 에서 가져와서 그대로 사용 할 것.

- 훅시스템
  - entity()->create(), update(), delete(), get(), search() 등에서만 훅을 걸면 왠만한 것은 다 된다.

# 설치

- Docker 로 설치를 한다. Docker 설치가 제일 쉽다.
  - 윈도우즈에서 Nginx(Apache)를 쓰지 않고, MariaDB 때신, SQLite 를 쓰고, PHP 만 설치해서, PHP Dev Webserver 만으로 실행을 한다고해도,
    Docker 가 더 쉽다.
    그냥 Docker 설치만 하면 된다.
    
- 먼저, Docker 를 설치한다.

- 적절한 위치에 `git clone https://github.com/thruthesky/emp` 를 한다.

- `cd emp/docker` 를 하고 `docker-compose up` 명령을 하면, 사용 바로 웹서버로 접속 가능하며 개발 가능하다.

## 각종 설정

- `emp` 폴더가 root 폴더가 된다.
- `docker` 폴더에는 Docker 로 운영하기 위한 모든 설정들이 저장되어져 있다.
  - `docker/etc` 폴더에는 nginx.conf 나 php.ini 와 같은 각종 설정 파일이 있으며,
  - `docker/logs` 에는 각종 로그 파일이 저장된다.
  - `docker/mysqldata` 에는 MariaDB 데이터베이스 파일들이 저장되는 폴더이다.
  - `docker/docker-compose.yml` 이 Docker Compose 파일이다.
  
# 폴더구조

- `etc` 폴더는 각종(기타) 파일들이 저장된다.
  - `etc/boot` 는 앱 부팅 과정에 필요한 코드/스크립트가 저장된다.
  - `etc/install` 은 웹 설치에 필요한 코드들이 저장된다.
  - `etc/phpMyAdmin` 은 phpMyAdmin 프로그램이 저장되어져 있다. 실제로 `https://www...com/etc/phpMyAdmin/index.php` 와 같이 접속하면 된다.
  - `etc/sql` 은 DB 에 필요한 SQL 파일이 저장되어져 있다.
  
- `lib` 폴더에는 시스템에 필요한 함수 파일과 클래스 파일이 저장된다.

- `routes` 폴더에는 각종 라우트가 저장된다.

- `storage` 폴더에는 각종 업로드 파일이 저장된다.

- `themes` 폴더에는 웹사이트 테마가 저장된다.

- `vendor` 폴더에는 composer 파일이 저장된다.

- `widgets` 폴더에는 각종 위젯이 저장된다.





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



# API Protocol

- `route` is the route of the api call.
  Ex) `/?route=app.version`
  
- To get app version, access like below
  Ex) `/?route=app.version`

## User Api

- To login, access like below
  Ex) `/?route=user.login&email=...&password=...`
  

- Live reload test. If http input `reload=true` is set, then it will live reload on a browser.
  Ex) /?route=user.login&email=...&password=...&reload=true
  
- To ge user profile
  Ex) /?route=user.profile&sessionId=89-3a321efd6adf2e79673c7279d4189f2a
