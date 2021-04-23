# CenterX

- CenterX 는 웹 및 Restful Api 를 통해서 애플리케이션을 개발할 수 있도록 하는 백엔드 프레임워크이다.

## 특징

- 가장 단순하며 직관적인 플랫폼을 위해서 직접 개발
- 성능 향상을 위해서 최신 PHP (버전 8)를 사용하고 있으며, Nginx(Apache 대체 가능)와 MariaDB(MySQL 대체 가능)를 바탕으로 하는 프레임워크
- Container(Docker) 를 통한 배포
- IE10+ 지원. 대한민국의 데스크톱에서 10% 이상이 IE 를 사용한다. IE 지원은 필수이다. 그래서 Vue.js 2 와 Bootstrap 4 를 기준으로 작업을 한다.


# 문서 안내

- 본 [README](https://github.com/thruthesky/centerx/) 는 CenterX 의 공식 문서로서 처음 시작 부터 모든 정보를 포함한다.
- 소스코드에 대한 설명은 `phpDocument` 을 통해서 문서화를 한다. 본 문서 문서화 참고


# 목표

- 간단하면서도 견고한 프레임워크 개발.
- Headless(Restful Api) 지원이 가장 우선적인 목표.
- PWA 개발을 쉽게 할 수 있는 기능 제공.

# 수정 사항 안내

- 2021년 4월 10일. 0.1.4 버전에서 많은 내용 변경.
  - docker 와 centerx 를 분리 했다.
  - docker 의 nginx 에 접속 도메인 별로, 홈 폴더를 다르게 설정 할 수 있도록 했다.
    - 그로 인해, Host OS 에서 여러 도메인으로 접속을 할 때, 꼭 CenterX 프레임워크가 아니라 다른 성격의 사이트 예) Perl CGI 나 Angular, Vue.js SPA, PWA 등이 가능하게 되었다.
    - 또한 각 홈 폴더에 centerx 를 따로 설치해서, 다른 버전의 centerx 를 운영 할 수 있다.
  
  

# 해야 할 일

- work on next branch

- refactor folder structure.

- develop own mysql connectivity class instead of using ezSQL

- change `point_histories` to `user_activities`.
  `point_histories` handles only for point related activities like point changes among crud, vote, register, login, etc.
  `user_activiies` includes all the actions/works of `point_histories` and it includes all the user activities like
  `search`, `report`, `block user`, `add friend`, `like on user profile`, and other activities evens if that are not related in point increase/decrease.
  And, of course, it the record will have point change information if point changes.

- In `entity()->search()`, `params` is mandatory if `where` is provided.

- rewrite `meta` functions to use `mata.taxonomy`


  

- 필고를 보고, security 체크를 한다. security 패턴 검사를 관리자 페이지에서 입력 할 수 있도록 한다.
  - SELECT SQL 쿼리 word filtering 을 따로 두고, (글 추출 및 각종 해킹 시도. entity.class.php 에서 read, search 등에서 사용. )
  - INSERT/UPDATE 쿼리 word filtering 을 따로 둔다. (글 쓰기, 코멘트 쓰기용 필터링, 욕설 등록 및 기타, entity.class.php 에서 insert 에서 사용.)
  
- SQL 문장에서 쿼리 시간을 제한 할 수 있도록, config.php 에 설정을 한다.



- pass login 재 정리

- `boot_complete` 훅 추가. 이 훅은 `boot.php` 맨 마지막에서 호출 되는 것으로 각종 입력 값이나 각종 보안 관련 훅을 추가 할 수 있도록 한다.
  예를 들면, 특정 라우트나 페이지에서는 특정 HTTP 입력 값만 허용하도록 하고, 다른 값이 들어오면 에러가 나도록 한다. 그리고 각 값의 문자열 길이나, 타입을 검사해서, 잘못된 입력을 가려 낼 수 있도록 한다.
  
- 파일 업로드에서, 퍼미션이 없을 때, empty response 에러가 나온다. 올바른 에러가 표시되도록 할 것.

- 훅시스템
  - entity()->create(), update(), delete(), get(), search() 등에서만 훅을 걸면 왠만한 것은 다 된다.
  
- Friendly URL 에 테마 스크립트 페이지 지정.
  https://domain.com/qna 와 같이 짧은 URL 을 지원 할 것.
  기본적으로 모든 category 는 최 상위 슬래시(/) 다음에 기록 할 수 있도록 한다.
  예) `addPage('abc')` 와 같이 하면 `https://domain.com/abc` 와 같이 접속을 할 수 있고, `themes/../abc.php` 가 로드 될 수 있도록 한다.
  게시판의 경우 기본적으로 지원을 한다. 예) `https://domain.com/qna` 와 같이 접속하면, `/?forum.post.list&categoryId=qna` 와 같도록 한다.
  그리고 이것은 각 테마에서 직접 코딩을 할 수 있도록 한다.

- 배포
  .gitignore 에 기본적으로 widgets 폴더를 빼고, 배포를 원하는 위젯만 -f 로 넣을 것.
  

- 카테고리
  카테고리 및 서브카테고리 변경 기능.

- file upload error handling. https://www.php.net/manual/en/features.file-upload.errors.php
- 파일에 taxonomy 와 entity 추가

- 게시판 별 추천, 비추천 옵션 선택.



- @doc
  meta 에 int, string, double(float) 은 serialize/unserialize 하지 말 것. 그래서 바로 검색이 되도록 한다.


- @doc
  `https://local.itsuda50.com/?route=comment.get&idx=15224` 와 같이 글이나 코멘트를 가져올 때, 글/코멘트 생성시, 작성자에게 추가된 포인트가 `appliedPoint` 로 클라이언트에게 전달된다.

- README 에 최소한의 정보만 두고, 모두 phpDocument 화 한다.
  
- API 보안.
  - CenterX 는 공개 소스이고, 프로토콜이 공개되어져 있으므로 누구든지, API 를 통해서 악의적으로 반복된 DB 액세스를 하여, DOS 공격을 할 수 있다.
  따라서, 허용된 클라이언트만 읽고 쓰도록 허용 할 수 방법을 강구해야한다.
  
  - 첫번째 방법은, API 자체적으로 보안을 하는 것으로,
    읽기는 1분에 100회,
    DB 작업 많이 들어가는 목록이나 검색은 1분에 20회,
    쓰기는 1분에 10회, 10분에 20회, 60분에 30회로 제한한다.
    총 용량은 60분에 글 1M 로 제한, 사진 20M 로 제한.
    이것을 관리자 페이지에서 변경 할 수 있도록 한다.

- @doc 게시판 설정에서, 글 편집 후 이동 옵션에서, 글 읽기 페이지를 선택하면, 글을 작성하고 난 다음에 글 읽기 페이지로 간다.
  글 목록 페이지를 선택하면, 글 쓴 후, 글 목록 페이지로 한다.
  

- @doc `next.***.test.php` 로 테스트 코드를 작성하고 있다.
  - user, category, post, comment 순서로 테스트
  - user()->create()->response() 에서 에러가 있으면 response() 항상 에러 문자열을 리턴한다.
  
- @doc 클라이언트로 전달하는 response() 함수는 에러가 있으면 에러 문자열을 리턴한다.
- @doc 클라이언트로 전달하는 경우가 아니면 `->hasError` 로 에러가 있는지 없는지 검사해야 한다.


- @doc 비밀번호 변경하기

간단하게 아래와 같이 코딩을 해서, 어디서든 실행을 한번 하면 된다.

```php
user()->by('thruthesky@gmail.com')->changePassword('12345a');
```

- @doc entity 는 실제 존재하는 taxonomy 에 대해서만 작업을 한다. 즉, table 이 존재하지 않으면 안된다.

- @doc meta 는 실제 taxonomy 가 존재하지 않아도 된다.

- @done entity 에서 meta 값 업데이트하는 테스트
  
- @done entity 에서 search(), my(), 테스트

- @doc 1개의 값을 리턴 하는 경우, 에러가 있으면 null 또는 빈 배열을 리턴한다.
- @doc 객체를 리턴하는 경우, ->hasError 를 통해 에러가 있는지 없는지 봐야 한다.


- @doc meta 관련 함수를 meta.functions.php 로 떼어 낸다.


- @later etc/configs 폴더에 각종 설정을 넣는다.
  db.config.php
  app.config.php
  와 같이 분리를 한다. 그리고 db.config.php 가 존재하지 않으면 설치가 안된 것으로 한다.
  
- @doc meta 테이블은 그 활용가 간단해서 taxonomy 와 entity 방식으로 사용하지 않는다. 하지만, 사용해도 무방하다. 실제로 테스트 코드에서는 사용을 한다.
- @doc 100% getter/setter 를 사용한다.
  변수 x 가 있다면, 아래와 같이 getter/setter 를 사용한다.
```php
    private int $x;
    public function getX() { ... }
    public function setX() { ... }
```

- @doc 데이터베이스 레코드에 대해서는 magic getter/setter 를 사용한다.

- @doc instantiate 를 할 때, constructor 에서 해당 entity 레코드와 meta 에 대한 모든 값들을 불러와 메모리에 저장한다.
  즉, entity()->get() 에서 더 이상 메모리 캐시를 할 필요 없다.
  이 때, 자식(코멘트) entity 는 로드하지 않는다.

- @doc 각종 entity() 클래스와 게시판에서 get() 함수를 없애고, read() 로 변경한다.

- @doc 글을 클라이언트로 보낼 때에는 post()->create(...)->response() 를 할 수 있도록 한다.
  이 response() 함수에서 코멘트 정보를 다 읽고 파싱한다.

- @later SQLite3 지원. 그러면 그냥 php dev web server 로 SSL 없이, localhost 로 바로 실행가능하리라 생각한다.



# Center X 의 데이터 모델

- Taxonomy 는 데이터 라이브러리(또는 데이터 그룹)이다. 데이터베이스에서 하나의 테이블이 하나의 taxonomy 라고 할 수 있다.

- Entity 는 Taxonomy 의 객체이다. 데이터베이스에서는 하나의 레코드에 대한 자료를 가지고 있으며, 그 레코드에 대해 읽기, 쓰기 및 각종 동적을 한다.




# 데이터 저장

기본적으로 각 테이블에 저장하며, 테이블에 없는 값은 meta 로 저장한다.

이 때, 쓸데 없는 값이 저장되지 않도록 defines 에 정의를 해서 처리를 하지만

악용을 하기 위해 큰 데이터를 저장하려는 경우가 있다. 

이 때에는 입력값에 허용된 값이 아닌 다른 값이 들어오면, 저장을 하지 않던지 에러를 내야한다.

현재는 이 기능이 없으며, 훅을 통해서 처리를 해야 한다.

객체를 리턴하지 않는 bool, string, int 등의 함수는  리턴값은 객체가 기본이다.

다만, API 로 전달하는 경우, 에러가 있으면 문자열, 에러가 없으면 배열로 리턴한다.




# 문서화

- phpDocumentor 에 맞춰서 문서화를 했다. 다만, 기본적으로 문서가 생성되어져 있지않다. 문서화를 하는 방법은 아래와 같이 실행을 하면된다.


```shell
cd etc/phpdoc
./phpDocumentor
```

- 작성된 문서를 보기 위해서는 `http://your-domain.com/etc/phpdoc/index.html` 와 같이 접속을 하면 된다.

- 참고로 phpDocumentor 의 태그는 https://docs.phpdoc.org/3.0/guide/references/phpdoc/tags/index.html 에 나와 있으며 Markdown 을 사용 할 수 있다.

# 설치와 기본 설정

우분투 서버에서 도커로 설치하는 방벙에 대해 설명한다.

코어 개발자들이 개발 작업을 할 때에는 우분투 서버에서 작업을 하는 것이 아니라 윈도우즈, 맥, CentOS 등에서 도커를 설치하고 테스트 했으며 이러한 OS 에서도 문제
없이 잘 동작한다. 또한 도커를 사용하지 않고 직접 Nginx(Apache), PHP, MariaDB(MySQL)을 설치하여 CenterX 를 운영 할 수 있다.

## 설치 요약

- CenterX 구동을 위한 docker compose 설정을 GitHub 에서 다운로드 또는 clone(또는 fork) 한다.
- `docker-compose up` 과 같이 실행을 하고,
- `home` 폴더 아래에 `git clone https://github.com/thruthesky/centerx` 와 같이 하면 된다. Fork 후 clone 을 해도 좋다.


## 설치 상세 설명


- 먼저 도커를 설치하고 실행한다.\
  [우분투 도커 설치 참고](https://docs.docker.com/engine/install/ubuntu/)
  
- 그리고 CenterX 실행을 위한 도커 compose 설정을 가지고 있는 git 을 클론한다.
  - `git clone https://github.com/thruthesky/docker /docker`
  - `cd /docker`
  
- 그리고 docker-compose.yml 에서 MYSQL_PASSWORD 와 MYSQL_ROOT_PASSWORD 를 적절한 비밀번호로 변경한다. 
  
- 그리고 아래와 같이 docker compose 를 실행한다.
  - `docker-compose up -d`


- Nginx 서버 설정은 `/docker/etc/nginx.conf` 이며, 기본 홈페이지 경로는 `/docker/home/default` 이다.

  
- 그리고 `centerx` git 을 `/docker/home` 폴더에 clone 한다.\
  참고, 도커 compose 설정 파일이나 실행은 루트 계정으로 해도 되지만, centerx 설치와 centerx 관련 작업은 사용자 계정으로 하길 권한다.\
  참고, `docker` repository 의 .gitignore 에 `home` 폴더가 들어가 있다. 따라서 `/docker/home` 폴더 아래에 `centerx` repository 를
  추가해서 작업을 하면 된다. 또한 다른 도메인을 추가하여 홈페이지 개발을 하고 싶다면, `/docker/etc/nginx.conf` 를 수정하고, 홈 경로를
  `/docker/home` 폴더 아래로 하면 된다.\
  `centerx` 를 `/docker/home` 에 설치하는 예제)
  - `cd /docker/home`
  - `cd git clone https://github.com/thruthesky/centerx centerx`
  - `cd centerx`
  - `chmod -R 777 files`

- phpMyAdmin 을 통한 데이터베이스 테이블 설치
  - `/docker/home/default/etc/phpMyAdmin` 에 phpMyAdmin 이 설치되어져 있다.
    `http://0.0.0.0/etc/phpMyAdmin/index.php` 와 같이 접속하면 된다.
    데이터베이스 관리자 아이디는 root 이며, 비밀번호는 위에서 변경 한 것을 입력한다.
  - phpMyAdmin 접속 후, `centerx/etc/install/sql` 폴더에서 최신 sql 파일의 내용을 phpMyAdmin 에 입력하고 쿼리 실행을 한다.
    - 만약, 국가 정보를 원한다면, `wc_countries` 테이블을 삭제하고, `/centerx/etc/install/sql/countries.sql` 



## Host setting

- To work with real domain(for example, `itsuda50.com`), add a fake domain like `local.itsuda50.com` on `hosts` file.
  - So, when you access `www.itsuda50.com` it goes to real domain. And `local.itsuda50.com` goes local host.

```text
127.0.0.1       local.itsuda50.com
```

- Then, get SSL. You may get it from `certbot`.

- Then, set the domain and SSL in `docker/etc/nginx.conf`

- Then, set the domain and theme in `config.php`.
```php
define('DOMAIN_THEMES', [
    'itsuda' => 'itsuda50.com',
    '127.0.0.1' => 'itsuda50.com',
    'localhost' => 'itsuda50.com',
    '169.254.115.59' => 'itsuda50.com', // JaeHo Song's Emulator Access Point to Host OS.
]);
```

- Then, try to access `local.itsuda50.com` and it should open local development site.

- Then, open Emulator and access `http://http://169.254.115.59/` and it should open the site.
  - You should find proper IP address to use from Emulator. If you are using Mac, `ifconfig | grep inet` command may help.

- Now you are ready.


## Nginx 설정

- 기본적으로 Nginx 로 설정되어져 있다. Apache web server 를 사용하려 한다면, 직접 적절한 설정을 해야 한다.

- `etc/nginx.conf` 에 nginx 설정이 있다.
  
- `nginx` 설정에서 루트 경로는 `docker-compose.yml` 의 설정에 따른다.
  각종 경로만 잘 지정하면, `nginx` 설정 방법을 그대로 활용하면 된다.







## 각종 설정

- `centerx` - The project folder.
- `docker` - All docker things are saved.
  - `docker/etc` - Settings for Nginx, PHP and others.
  - `docker/logs` - Log files of Nginx and other logs.
  - `docker/mysqldata` - MariaDB database files are saved in this folder.
  - `docker/docker-compose.yml` - Docker Compose file.
  

## Hot reload

- Node.js version 10.23.0 이상에서 동작한다.
- Host 와 Port 를 config.php 에 적어주면 된다.
  - LIVE_RELAOD_HOST 의 domain 은 현재 개발중인 host 일 필요 없으며, 접속 가능한 host 이면 된다.
    예를 들어, 개발중인 사이트의 도메인은 abc.com 인데, 전혀 상관없는 도메인인 def.com 을 적어도 된다.
  - Port 는 12345 로 그냥 고정한다.
  
- 만약, SSL 로 서비스(개발)하는 경우, `live-reload.js` 에서 SSL 을 LIVE_RELOAD_HOST 에 맞는 것으로 지정해 주어야한다.
  
- 동작 방식
  - 먼저 `node live-reload.js` 와 같이 socket.io 서버를 실행.
  - etc/boot.code.php 에서 live_reload() 함수 호출
  - lib/functions.php::live_reload() 함수에서 live-reload.js 서버로 접속해서, 변경 이벤트가 있으면 reload


# Versioning

- 버전 체계. 년-월-일 로 5자리로 한다. 2021 이 1 이다. 4월 19일 버전이면, 10419 가 된다.


# Component


  
- [EzSQL](https://github.com/ezSQL/ezsql)
  For database connection
  
- Firebase

- [MobileDetect](https://github.com/serbanghita/Mobile-Detect)
  To detect the device is mobile
  


# 폴더구조 (Folder Structure)

- `etc` - For etc files.
  - `etc/boot` - has all boot related code and scripts.
  - `etc/install` - for keeping information about installation.
  - `etc/phpMyAdmin` - phpMyAdmin for managing database. Access `https://www...com/etc/phpMyAdmin/index.php`.
  - `etc/sql` - has SQL schema for installation.
  
- `routes` 폴더에는 각종 라우트가 저장된다.

- `storage` is for all the uploaded files.

- `themes` is theme folder for website.
  
- `vendor` is for compose files.
  
- `widgets` is for widgets.

- `library` folder has the system library scripts.
  -`library/taxonomy` folder has all kinds of taxonomy scripts like `user.taxonomy.php`, `post.taxonomy.php`,
    `comment.taxonomy.php`, `meta.taxonomy.php`, and others.
  
    - post and comment are using same table but their usages are different. So, the taxonomies are divided.
  
  - `library/utility` folder has utility scripts for the system like `library/utility/mysqli.php` that provides database connectivity.
    
  - `library/model/entity.php` is a model class for each taxonomy.
  - `library/model/taxonomy.php` is the taxonomy class that extends entity class and is the parent of all taxonomy classes.
    





# Configuration

- `config.php` on project folder is the default configuration and it is only for configuration. It cannot query to database in `config.php`
  
- The default `config.php` can be overwritten by theme configuration.

## Theme Configuration

- `themes/[theme-name]/[theme-name].config` will be included if exists.
  It will be included even if it is triggered by API call. (Theme is determined by domain in config.php)

- 주의, 테마 폴더가 abc, def 가 있는데, 이것은 도메인과 상관이 없다.
  도메인 def.com 으로 접속해도, abc 테마로 사용할 수 있는데, 이것은 config.php 에서 테마 설정을 다르게 해 주면 된다.

- All the default configuration can be over-written by theme configuration.
  That means, each theme can use different database settings.

- You cannot query to database inside configuration unless you do it in hooks, routes.

# Functions

- After configuration(including theme configuration) has been set, `theme/theme-name/theme-name.functions.php` will be called on every theme even if it's API call.
  You can do whatever you want from here. You can query to database at this time.
  

# Developer Guideline

- Variables and Functions, Methods should in camel case.

- Taxonomy is like a table and Entity is like a record of the table.
  
- Entity class has methods for `create`, `update`, `delete`, `get`, `search` and more.
  
- Child class of Entity will have all the functionality of Entity.
  - For instance, `User` class which extends `Entity` has functionality of
  `$user->create()`, `$user->update()`, `$user->get()`, `$user->search()` and more of `Entity` class.
  - For `User` class to create a user, it may need to encrypt password. So, it but `Entity's create` method has no functionality to encrypt password,
    and that the where `User->register` method comes.
    User class can have its own methods to check if the input from user is right and if email is already exists, then,
    it can encrypt the password and call parent's create method to create an entity(record).

- Meta data is saved through serialize/unserialze.


- user()->profile() 또는 user()->response() 의 결과는 배열이다. 그리고 profile 이라 부르는 데이터는 사용자 정보를 배열로 담은 것을 말한다.
  - 사용자 로그인 정보를 profile 로 글로벌 변수 $__login_user_profile 에 저장한다. 즉, 로그인 한 사용자 정보를 배열로 보관하는 것이다.
  - 클라이언트 엔드에서 API 호출을 하는 경우에도 이 profile 정보를 가져오는 것이다.



## Entity and Taxonomy

- When `idx` is set in entity instance, actions(methods) work on that record of `idx`.
  - For instance, entity is set by `$token = token($in[TOKEN])`, then `$token->delete()` will delete that token.
    But if an instance of entity is created without `idx` like `$token = token()`, then `$token->delete()` will fail.
    There are some actions that works on both with `idx` and without `idx` like `entity()->get()`.
    If `idx` is set, then `$entity->get()` will get the entity.
    If `idx` is not set, you can still use `$entity->get(field, value)` to search and get an entity.
    Some actions work only without `idx` like `$entity->create()`. Even if `idx` is set, it will be ignored with `create()`.

- Mostly taxonomy is a table on the database. But it's not mandatory.
  - Just like what `Config` class does.
    The `Config` class simply defines itself as config taxonomy and its table does not exist.
    So, when `Config` uses the functionality of `Entity`, it cannot do anything that is related with the table.
    It can do such things like `entity->getMtea()`, set, update, delete, addifNotExists that are not related with the taxonomy table.


- 테이블을 새로 만들 때, idx, createdAt, updatedAt 3개의 필드만 있으면 entity 클래스를 통해서 작업을 할 수 있다.
  이 때, 테이블 prefix 를 맞추어서 테이블 이름을 정해야 한다. 예) wc_table_name


## Taxonomy helper classes

Each taxonomy may have its own customised methods.
Here are some recommendations on creating helper methods on each taxonomies.

- `by()` returns an instance of the taxonomy by the input.
- `first()`, and `last()` return instances of the first or last instance of the taxnomies by the input.


## Posts Taxonomy

- The `posts` taxonomy can contain any kind of posts.
  - A diary can be a post.
  - A shopping mall item can be a post.
  - A comment can be a post.
  - And anything that has title, content, and needs to be managed like post, then it can be saved as a post.
  - there is a `type` field and it shows the kind of the post. it can be `diary`, `shopping-mall-item`, `memo`, `comment`, `post`, etc.
  
- The `categoryIdx` is the `wc_categories.idx` indicating that the post belongs to which category.
- The `category` and `subcategory` is child(sub) categories of the category.
  In the the `category` settings page, admin can add categories and subcategories of the category like below.
```text
category1=subcsategory-1,subcategory-2, ...
category2=subscateogry-2-1,subcategory-2-2, ...
```


- `rootIdx` is the post idx of comments.
  For instance, a post.idx is 3. then the `rootIdx` of all the comments(children) of the post is 3.
  For the post itself, it is 0. And if `rootIdx` is 0, it means, a post. Not a comment.
  
- `parentIdx` is to indicate who is the parent.
  It is used to find the children of a post or a comment.
  If a post.idx is 3, then the `parentIdx` of all the immediate(first depth) of children of the post is 3.
  For the post itself, it is 0. And if `parentIdx` is 0, it means, it is a post. Not a children.
  For a comment of another comment, the `parentIdx` of the comment will be the `idx` of the parent.
  For instance,
    - The post A's idx is 3, 
      And the child of A is B. B has post.idx might be 10, and parentIdx must be 4, and rootIdx = 3.
      Then, the child of B is C. B's post.idx might be 20, and parentIdx must be 10, and rootIdx = 3.

- If a comment has same value of `rootIdx` and `parentIdx`, then it's the first depth(immediate) child comment of the post.

- `code` 필드는 posts 테이블 레코드에 특정 코드를 저장해서, 해당 글을 추출할 때 사용한다.
  예를 들면, 어떤 글에 특정 code 를 저장하고 URL 로 /?p=forum.post.view&code=abc 와 같이 해서 특정 글을 보거나
  
  또 다른 예로, 특정 청소 기록을 하는 테이블을 만들때, 각 날짜별로 방청소, 화장실 청고, 거실 청소 등 코드를 두어서, 날짜별로 청소를 했는지 안했는지 체크 할 수 있다.
  즉, 별도의 테이블을 만들지 않고, 게시판 테이블로 여러가지 기능을 만들 수 있다.
  `code` 에는 최대 32 글자의 문자열이 저장되는데, 숫자로 저장해도 상관 없다.
  

## Config taxonomy class

- Config taxonomy class is a fake taxonomy class. There is no such taxonomy table as `config`.
  So, it does not do any `CRUD` on the taxonomy. Instead, it deals only with meta data.
  The primary goal of `Cofnig` class is to save config data. 
- By default, all config has `idx` as 0.
- Settings in admin page is also saved as config, but the `idx` is 1.
- To save(or update) multiple config meta, you can use `updateMetas()` method.

```php
config()->updateMetas(0, in());
config()->updateMetas(ADMIN_SETTINGS, in()); // ADMIN_SETTINGS is defined as 1.
```

- To get mutilple meta value,

```php
d( config(3)->getMetas() );
```


# Admin

## How to set admin to manage the site.

- Root admin, who has the full power, can be set to ADMIN_EMAIL constant in `config.php`.
  After setting the email in config.php, you may regsiter(or login) with the email.
  

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

## 게시글 테이블. posts 테이블



- `code` 는 게시글에 부여되는 특별한 코드이고, 그 코드를 바탕으로 글을 추출 할 수 있다.
- `report` 는 신고된 회 수를 저장한다. 신고가 될 때마다 1씩 증가한다.

## 사용자 테이블


- `birthdate` 에는 YYYYMMDD 의 8자리 숫자 값이 들어간다. 만약, 앱으로 부터 년도 4자리 값만 입력을 받는다면, 19730000 와 같이 월/일의 값은 0으로 입력하면 된다.


### 사용자 프로필 사진

- 사용자가 사진을 올릴 때, `file.taxonomy` 에 `photoUrl` 이라고 입력하면, 해당 사진은 그 사용자의 프로필 사진이 된다.
  회원 정보를 클라이언트로 전달 할 때, `photoIdx` 에 그 `file.idx` 가 전달된다.
  사용자 프로필 사진을 삭제할 때, `file.taxonomy = 'photoUrl' AND file.userIdx='사용자번호'` 조건에 맞는 사진을 삭제 할 수 있다.
  물론 `file.idx=photoIdx` 인 것을 삭제해도 된다.
  
- `photoUrl` 은 meta 값을 저장되는 것이다. 이것은 users 테이블에 존재하지 않으며, meta 값으로 저장되지 않을 수도 있다.
  즉, 사용자 마다 이 값이 있을 수 있고 없을 수도 있다. 예를 들어 카카오톡 로그인을 하는 경우, 사용자 사진이 있으면 이 값에 그 URL 이 저장된다.
  따라서, 클라이언트에서 적절히 옵션 처리를 해서 사용하면 된다.

## 친구 관리 테이블

- 테이블 이름: friends
- 친구 목록은 n:n 관계이다. 그래서 별도의 테이블이 존재해야한다.
- myIdx 는 나의 회원 번호
- otherIdx 는 내 친구로 등록된 (다른 사용자의) 회원 번호.
- block 은 친구 신고를 하거나, 차단하는 경우, 'Y' 의 값을 가진다. 'N' 의 값을 가지지 않으며, 기본적으로는 빈(문자열) 값이다.



# Widget System

- A widget is a reusable code block like login, latest post list, and more.

- Widgets are saved under `widgets` folder. The folder names right under `widgets` folder are the widget types.

- Each widget must have a php script file that has same name of its folder name.
  For instance, if folder name is `widgets/abc`, then script name must be `widgets/abc/abc.php`.
  
- Each widget can declare some information as comment annotation like below.

```php
/**
 * @name Abc
 * @desc Description of Abc
 * @type ...
 */
```

- If `@type` is set to `admin`, then it will be used in admin page only. So, the widget will not appear in widget selection.

- For forum widget settings in admin page, widget name ends with `-default` will be used if there is no selected widget.

- And even for the categories(forums) that has no widget settings, the widgets ending with `-default` will be used.



# Debugging

- debug log file is saved under `var/log/debug.log`.

- You can enable debugging by calling `enableDebugging()` and disable debugging by calling `disableDebugging()`.



# Post Crud

- To view or link to post list page, use `/?p=forum.post.list&categoryId=...` format.
- To view or link to create or update page,
  - use `/?p=forum.post.edit&categoryId=...` for creation
  - use `/?p=forum.post.edit&idx=...` for update.
  
- After filling up on post create/update form, send the form to `/?p=forum.post.edit.submit` and it will redirect to the list page.


# Firebase

## Javascript

- Firebase 설정은 config.php 에서 한다. 필요한 Firebase product 를 추가하면 된다.
- Firestore 사용은 아래와 같이 하면 된다.

```html
<script>
    later(function() {
        const db = firebase.firestore();
        console.log(db);
        db.collection('notifications').doc('settings').set({time: (new Date).getTime()});
    })
</script>
<?php
    includeFirebase();
?>
```


# API Protocol

- API Protocol examples are written in `/etc/rest-client/rest-client.http`

- `route` is the route of the api call.
  Ex) `/?route=app.version`
  
- To get app version, access like below
  Ex) `/?route=app.version`
  
- To live reload on web browser, add `/?reload=true`. But you must remove it when you don't need live reload.
  

## Response

- `login()` 함수는 매번 호출 될 때마다 새로운 객체를 생성하므로, 필요하다면 `$login = login()` 와 같이 객체를 저장해서 재 사용해야한다.
  그래서 아래와 같이 하면, 업데이트된 값이 제대로 전달되지 않는다.
  
```php
login()->updateData('rank', 2); // 이 객체와
return login()->response(); // 이 객체는 서로 달라서, rank 값이 클라이언트로 전달되지 않는다.
```

- 단, 아래와 같이 할 수는 있다.

``php
return login()->updateData('rank', 2)->response();
``

## Adding Custom Api Route

- There are two ways of handling route.
- First, you can create a route class under `routes` folder and add method.
  For instance, if `/?route=app.version` is accessed, create `routes/app.route.php` and define `AppRoute` class, then add `version` method in it.
  
- Second, simple define a function of anywhere.
  For instance, if `/?route=app.version` is accessed, add a function to `addRoute()` function like below.
```php
addRoute('app.version', function($in) {
    return ['version' => 'app version 12345 !!!'];
});
```  

- For defining routes to a specific theme, create `[theme-name].route.php` and define routes there, and include it in `[theme-name].config.php`.

- For core routes, it is defined in `routes` folder.

- If there are two route handlers for the same route, that comes from route class in `routes` folder and the other comes from `addRoute()`,
  Then, the function that is added to `addRoute()` will be used. This means, you can overwrite the routes in `routes` folder.

- See `themes/itsuda/itsuda.route.php` for more examples.

## App Api

- To get app version,

```
https://local.itsuda50.com/index.php?route=app.version
```

- To get app settings,

```
https://local.itsuda50.com/index.php?route=app.settings
```



## User Api

- To login, access like below
  Ex) `/?route=user.login&email=...&password=...`
  
- To register,

```text
https://local.itsuda50.com/?route=user.register&reload=true&email=user3@test.com&password=12345a
```

- To login
```text
https://local.itsuda50.com/?route=user.login&reload=true&email=user3@test.com&password=12345a
```


- To ge user profile
```text
https://local.itsuda50.com/?route=user.profile&reload=true&sessionId=3-50bb905fb31f8035f2cef8a2f273af74
```



## Category Api

- To create category, pass `id, title, description` into `category.create` route.

```text
https://local.itsuda50.com/?route=category.create&reload=true&id=appl3e&title=Apple%20category&description=I%20like%20Apple&noOfPosts=5
```

- To get category, you can pass `category.idx` or `category.id` as `idx` or `id` param.
```text
https://local.itsuda50.com/?route=category.get&reload=true&idx=1
https://local.itsuda50.com/?route=category.get&reload=true&idx=apple
https://local.itsuda50.com/?route=category.get&reload=true&id=apple
```

- To update category, pass idx on `idx` or id on `id` to `category.update`

```text
https://local.itsuda50.com/?route=category.update&reload=true&idx=1&title=t&description=d
https://local.itsuda50.com/?route=category.update&reload=true&id=apple&title=t&description=d
```

- To delete a category, pass idx on `idx` to `category.delete`. For deletion, only `idx` is accepted.
```text
https://local.itsuda50.com/?route=category.delete&reload=true&idx=1
```

## Post Api

- To create a post,
  - Required fields are: `sessionId`, `category`.
  - `title`, `content`, and other properties are optoinal.
  - Since `Entity` class supports adding any meta data, you can add any data in `&key=value` format.
  
```text
https://local.itsuda50.com/?route=post.create&sessionId=5592-52f7119495484c1d56cf8629e9664001&categoryId=banana&title=yo&content=there&a=apple&b=banana&c=cherry
```

- To update a post, add `sessionId` with `idx` and other `key/value` pair fields to update.
````text
https://local.itsuda50.com/?route=post.update&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&category=apple&title=updated-by-no.%204&content=content&a=apple&b=banana&idx=19
````


- To get a post, just give `posts.idx`. `sessionId` may not be needed.
```text
https://local.itsuda50.com/?route=post.get&reload=true&idx=19
```

- To delete a post,
```text
https://local.itsuda50.com/?route=post.delete&sessionId=5-9b41c88bcd239de7ca6467d1975a44ca&idx=18
```


- To list posts of a category.
  - Most of the search options goes in value string of `where` param. You can put any SQL conditions on `where`.
```text
https://local.itsuda50.com/?route=post.search&reload=true&where=(categoryId=<apple> or categoryId=<banana>) and title like '%t%'&page=1&limit=3&order=idx&by=ASC
```


## Comment Api


- To create a comment,
  - Required fields are: `sessionId`, `rootIdx`, `parentIdx`.
    - `rootIdx` is the post.idx and `parentIdx` is the parent idx. parent idx can be a post.idx or comment.idx.
  - `content`, and other properties are optoinal.
  - Since `Entity` class supports adding any meta data, you can add any data in `&key=value` format.

```text
https://local.itsuda50.com/?route=comment.create&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&content=A&rootIdx=159&parentIdx=159
```

- To update a comment, add `sessionId` with `idx` and other `key/value` pair fields to update.
````text
https://local.itsuda50.com/?route=comment.update&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&content=B-A-Updated&idx=162
````


- To get a comment, just give `posts.idx`. `sessionId` may not be needed.
```text
https://local.itsuda50.com/?route=comment.get&idx=163
```

- To delete a comment,
```text
https://local.itsuda50.com/?route=comment.delete&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&idx=162
```



## Files and File Api

- To create a file, there are two steps.
  - First, upload file
  - Second, add the file idx(es) to the taxonomy entity `files` field.
  
  - To upload file, call `file.upload` route with sessionId and `userfile` with file data.
    
  - Add files to post, comment, any other taxonomies.
```text
/?files=123,456,other=vars-to-save-to-the-taxonomies.
```

- To delete a file,
```text
/?route=file.delete&sessionId=...&idx=123
```


- You can upload a file/image and save the idx (of uploaded file) in a different meta field of the taxonomy.
  - You have to delete the taxonomy meta field after delte the file.


- 파일을 업로드 할 때, 기존의 파일을 삭제해야하는 경우가 있다.
  예를 들어, 하나의 글에 하나의 사진만 올릴 수 있도록 하는 경우, 사용자가 사진을 변경하면 기존의 사진은 자동으로 삭제가 되어야한다.
  이 때, file upload 를 할 때,
  deletePreviousUpload: Y
  taxonomy:
  entity:
  에 값이 들어오면, 백엔드에서 삭제를 한다.
  Flutter Firelamp api.controller.dart 의 takeUploadFile() 과 uploadFile() 함수를 참고.


## Point Api

- 글(또는 코멘트)을 쓸 때, 얼마의 포인트를 획득했는지, 포인트 값을 알고 싶다면, 아래와 같이 호출한다.
  - `idx` 는 글 또는 코멘트 번호이다.
  - @todo 로그인한 사용자 자신의 레코드이어야 값을 가져올 수 있도록 수정해야 한다.
  
```
https://local.itsuda50.com/?route=point.postCreate&idx=15130
```


### phpThumb Displaying images

- It uses `phpThumb` for reading images and thumbnail generating.

- By default, images are saved under `files/uploads` folder and the images can be directly displayed using image url.
  But it cannot display images with `file.idx`.
  
- `phpThumb` does thumbnail generating and control expiration of image. And it even handles the `Last-Modified(Etag)`.
  Chrome and other browsers do memory-cache.
  Flutter can use a package to cache locally if file name is not modified.
  So, caching wouldn't be a big matter but it handles caching machanism.

- It can use image path or `file.idx`. `phpThumb` also supports remote image by specifying image url.
  It would be worthy to make a handy helper function to create this thumbnail generating url on each client.

```html
<img src="http://local.itsuda50.com/etc/phpThumb/phpThumb.php?src=67&wl=300&h=300&zc=1&f=jpeg&q=95">
<img src="http://local.itsuda50.com/etc/phpThumb/phpThumb.php?src=/root/files/uploads/learn-24052061920-10.jpg&wl=300&h=300&zc=1&f=jpeg&q=95">
```

- You can get the original image by putting `&orignal=Y`.
  - When you get the original image,
    - It does not resize the image by giving width and height.
    - It does not cache.
  - Good benefit of getting original image is that, you want to get the original image, but you don't know the page of the image. Then, you can get it with file.idx.
```html
<img src="http://local.itsuda50.com/etc/phpThumb/phpThumb.php?src=67&original=Y">
```

# Meta

You can search meta table directly by using `meta()`.

When you are saving extra data into user taxonomy, the extra data, which does not exists as users table record, goes into meta table.
You can search directly by `code` as the name of the data. Or with the combination of taxonomy.

If it's user extra data, then the taxonomy is `users`. If it's post(or comment) extra data, then the taxonomy is `posts`.


```php
$meta = meta()->get('code', 'topic_qna');
$metas = meta()->search("taxonomy='users' AND code='topic_qna' AND data='Y'", select: 'entity', limit: 10000);
```

The above code is identical as below
```php
$meta = entity(METAS)->get('code', 'topic_qna');
$metas = entity(METAS)->search("taxonomy='users' AND code='topic_qna' AND data='Y'", select: 'entity', limit: 10000);
```




# Firebase

- Firebase admin key may be kept in each theme folder if you develop many themes at one time.

# Vote

- 추천 기능은 게시글 뿐만아니라, 사용자 프로필에도 할 수 있도록 vote_histories table 에 taxonomy 와 entity 를 추가해 놓았다.

# Translation

- 언어화 기능이다. 사이트나 앱에 표시되는 글을 영어, 한국어 등으로 번역해서 표현 할 수 있다.
- 플러터에서는 Getx 의 `.tr` 기능과 연계해서 사용하면 된다.

- Translation 을 언어화가 아닌 다른 용도로 사용이 가능한데, 
  예를 들면, "앱 메뉴"에 "버전 표시"를 할지 말지 관리자 페이지에서 on/off 를 설정 해야하는 경우가 있는데,
  이 기능을 하기 위해서는 매번 관리자 페이지(HTML 웹사이트)를 수정해서, 기능 추가/저장을 해야하는데, 번거롭게 매번 이렇게 하지 말고,
  Translation 에 "showVersionOnDrawer" 를 추가하면, on 이 되고, 삭제하면 off 가 되는 것이다. 즉, 관리자 페이지 기능을 수정 할 필요가 없는 것이다.
  이 처럼, Translation 을 여러가지로 활용 할 수 있다. 다만, 너무 복잡하게 사용하지 않도록 주의한다.
  또한, "showVersionOnDrawer" 언어 코드에 대한 값을 "Y" 또는 "N" 정도로 간단하게 설정한다.
  그래서, en: Y, ko: N 와 같이 해서, 영어에서는 보여주고, 한국어에서는 안보여 줄 수도 있다.
  클라이언트에서 값을 확인 할 때에는 '플러터 예제 코드' `if ('showLoginOnDrawer'.t == 'Y')` 와 같이 값이 Y 또는 N 인지 비교를 해야 한다.
  그리고 더 짧게 쓰려면 `if ('loginOnDrawer'.on)` 와 같이 할 수도 있다.
  참고: https://github.com/thruthesky/dalgona/blob/main/lib/services/globals.dart#L52
  

- @see the phpdoc


# Settings

- Setting update goes pretty much the same as Translation.






# 테마 Theme

## 테마 폴더 구조

- 모든 페이지를 로드할 때, 각 테마의 index.php 가 호출된다. 즉, 테마의 index.php 에서 각 페이지에 맞는 PHP 스크립트를 로드해야한다.
  - 참고: theme/default/index.php 를 보면, `include theme()->page()` 와 같이 호출하는데, 이렇게 하면 각 페이지 별 PHP 스크립트를 로드한다.
  
- `pages/` 폴더는 시스템적으로 고정된 것이 아니지만, 테마 디자인을 할 때, 개발자가 추가하는 페이자의 경우, `pages` 폴더 아래에 넣을 것을 권한다.
  - 예를 들어 `/?user.login` 과 같이 하면, `theme/theme-name/user/login.php` 가 로드되는데, user, post 와 같이 범용적인 것은 각각의 폴더에 저장하고
    기타 페이지의 경우, `/?pages.menu` 와 같이 해서, `theme/theme-name/pages/menu.php` 와 같이 `pages` 폴더에 스크립트를 저장하고 로드되도록 한다.
    
- `parts/` 폴더는 시스템적으로 정해진 것으로 특정 부분의 스크립트가 존재하면 사용된다. 존재하지 않으면 사용되지 않는다.
  - 예를 들어, 각 게시판의 상단에 포함될(보여질) 스크립트인 `pages/post-list-top.php` 이 존재하면, 이 PHP 스크립트가 게시판 상단에 보여진다. 만약, 이
    스크립트가 존재하지 않으면 보여지지 않는 것이다.
    이것은 훅으로 사용 할 수도 있지만, 보다 편리하게 하기 위해서 `parts` 방식으로 사용한다.

## 테마 페이지 로딩. Loading theme page.

- Theme page is loaded by the path of HTTP `p` variable.
  - For instance, `/index.php?p=user.login` will open `/theme/theme-name/user/login.php`.
  You may open a page without `p=`. For instance, `/index.php?user.login` will do the same of `/index.php?p=user.login`.

- 테마 페이지는 URL 변수 `p=...` 에 따라 각 `theme/theme-name` 에 있는 페이지를 연다.
  이 때 만약 해당 페이지가 없으면 `theme/default` 에 있는 페이지를 연다.
  
- 테마 페이지를 열 때, 각 테마의 `theme/**/index.php` 가 먼저 로드된다.
  그리고 각 테마의 index.php 에서 `include theme()->page()` 와 같이 호출해서 테마 페이지를 로드해야한다.
  즉, 각 테마 페이지에서 적절한 디자인을 추가하거나 기본적인 HTML head 등을 화면에 출력 할 수 있다.
  
- URL 변수 `p=abc.submit` 과 같이 `.submit` 으로 끝나면, index.php 에 의해서 각 테마의 index.php 를 호출하지 않고, 바로 테마 페이지를 연다.
  즉, 테마 디자인을 생략하고(화면에 출력하지 않고), 곧 바로 테마 스크립트만 실행하는 것이다.

## 인라인 스타일 태그와 자바스크립트 태그를 하단으로 이동

- 바디 태그 사이(`<body>...</body>`)에 들어가는 인라인 스타일(`<style>...</style>`)이나 자바스크립트(`<script>...</script>`) 그리고 태그는
  모두 HTML 페이지의 하단 (`</body>` 바로 직전)으로 이동한다. HTML 로딩 방식에서 웹브라우저가 랜더링 성능을 높이기 우해 선호하는 방식이며, 이에 따라 검색
  엔진(구글 등)에서 높은 점수를 주어 검색이 더 잘되게 된다. 또는 Vue.js 2 에서 인라인 `<style>` 태그와 `<script>` 태그를 지원하지 않는다.
  - 단, `<head>...</head>` 사이에 있는 `<script>` 나 `<style>` 태그는 하단으로 이동하지 않는다.
  
- `index.php` 에서 인라인 `<style>` 태그나 `<script>` 태그를 모두 추출하여 하단으로 이동한다. 하지만, `<script src='...'></script>` 와 같이
  외부 링크를 거는 경우 `js()` 함수를 통해서 호출해야 한다.
  

## 외부 Javascript 를 포함하기

- 범용적이며 자주 사용되는 Javascript 는 etc/js 폴더에 저장을 한다.
  그리고 테마에 포함 할 때에는 `js()` 함수로 하면 된다.
  - `js()` 함수는 동일한 src 파일을 중복으로 포함해도 한번만 포함하도록 해 준다.
  - 또한 차후에 여러가지 기능이 포함 될 수 있다.
  - 직접 `<script src=...></script>` 와 같이 해 되지만,
  여러가지 전 처리 기능을 하지 못할 수 있다.

- `js()` 함수에는 두번째 파라메타에 priority 를 기입 할 수 있다. priority 는 최대 10 부터 0 까지이며, 주의 할 점은 인라인 자바스크립트가 priority 1
  다음, 0 이전에 삽입된다.
  - 예를 들면, vue.js 는 bootstrap-vue.js 보다 먼저 포함되어야 하고, 각종 인라인 스크립트는 vue.js 다음에 그리고, app.js 전에 포함되어야 한다.
  - priority 옵션을 통해서, 이러한 점을 잘 활용하면 된다.

```html
<?php js(HOME_URL . 'etc/js/helper.js', 7)?>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js', 9)?>
<?php js(HOME_URL . 'themes/sonub/js/bootstrap-vue-2.21.2.min.js', 10)?>
<?php js(HOME_URL . 'etc/js/helper.js', 10)?>
<?php js(HOME_URL . 'etc/js/helper.js', 10)?>
<?php js(HOME_URL . 'etc/js/helper.js', 10)?>
<?php js(HOME_URL . 'etc/js/helper.js', 10)?>
<?php js(HOME_URL . 'etc/js/app.js', 0)?>
```


# Vue.js 2 사용

- Vue.js 3 를 사용하다가 Vue.js 2 로 변경을 하였다.
  - 이유는 Internet Explorer 지원때문인데, Vue.js 3 는 IE 를 지원하지 않아 꼭 필요한 부분(Create, Update, Delete)만 Vue.js 3 를 사용하고
    글을 보여주는 부분은 Vue.js 3 를 사용하지 않으려고 했는데, 올바른 구조를 만들기가 생각보다 쉽지 않았다.
  - 대한민국에서 IE 를 포기할 수는 없다. [2020년 9월 데스크톱에서 10.33% (참고: 나무위키)](https://namu.wiki/w/Internet%20Explorer?from=%EC%9D%B8%ED%84%B0%EB%84%B7%20%EC%9D%B5%EC%8A%A4%ED%94%8C%EB%A1%9C%EB%9F%AC#s-4) 의 점유율을 기록하고 있다.
    점유율이 10%가 넘는 다면, 지원하는 것이 선택 사항이 아니라 필수인 것이다.

- Vue.js 2 사용 예제
  - 아래의 예제에서 `mixins` 과 `later` 함수의 사용법을 잘 설명해 주고 있다.
  - `mixins` 는 배열이라서 얼마든지 개별 테마 페이지에서 Vue.js 2 mixin 을 추가 할 수 있다.
```html
<!doctype html>
<html lang="en">
<head>
  <title>...</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link href="/etc/fontawesome-pro-5/css/all.css" rel="stylesheet">
  <style>
    <?php include theme()->css('index') ?>
  </style>
  <script>
    const mixins = []; // Vue.js 2 의 mixin 들을 담을 변수
    function later(fn) { window.addEventListener('load', fn); }
  </script>
</head>
<body>
<script>
  mixins.push({
    data: function() {
      return {
        name: 'sonub'
      }
    }
  })
  later(function(){
    console.log(app.name);
  });
</script>
<section id="app">
  <?php if ( str_contains(theme()->page(), '/admin/') ) include theme()->page(); else { ?>
  <?php
        include theme()->file('header');
  ?>
  <div class="container-xl">
    <div class="row">
      <div class="d-none d-md-block col-3"><?php include theme()->file('left'); ?></div>
      <div class="col p-0 m-0"><?php include theme()->page(); ?></div>
      <div class="d-none d-lg-block col-3"><?php include theme()->file('right'); ?></div>
    </div>
  </div>
  <?php
        include theme()->file('footer');
  ?>
  <?php } ?>
</section>
<?php js(HOME_URL . 'etc/js/helper.js')?>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js')?>
<?php js(HOME_URL . 'etc/js/app.js')?>
</body>
</html>
```

- To add mixins, you can do the following.
```html
<script>
    mixins.push({
        created: function () {
            console.log('postList attribute binding created!');
        },
    });
</script>
```

- You may use `later()` helper function by adding it in head tag.

# Bootstrap 4 사용

- IE 지원을 위해서 Bootstrap 4 를 사용한다. (Bootstrap 5는 IE 지원하지 않음.) Bootstrap 4 는 IE 버전 10 이상을 지원한다.


# Bootstrap Vue 2.x 사용

- Bootstrap 4 와 Vue 2 를 합쳐서 놓은 것이 Bootstrap Vue 2.x 이다. 이렇게 하면 jQuery 없이, Bootstrap 의 자바스크립트 기능을 사용 할 수 있다.
- 유용한 Bootstrap 기능 중 몇 다음과 같다.
  - Dialog, Calendar, Date Picker, Time picker, Overlay, Popover, Sidebar, Spinner, Tab, Toast, Tooltip,
  - FORM file(drag & UI), FORM input contextual state,
  - Scroll spy, 
  
예제) 아래와 같이 polyfill.min.js 를 포함해야 IE10+ 이상이 지원된다.

```html
<!-- Load polyfills to support older browsers before loading Vue and Bootstrap Vue -->
<script src="//polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver" crossorigin="anonymous"></script>
<?php js(HOME_URL . 'etc/js/vue-2.6.12-min.js', 2)?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1)?>
```

# Admin page design

- It is recommended to write admin code as a widget.
  And in admin page, there should be only button menus that load the widgets.

- Admin page might look like below. It simply loads widgets depending on which button it was pressed.

```html
<h1>Admin Page</h1>
<a href="/?p=admin.index&w=user/admin-user-list">User</a>
<a href="/?p=admin.index&w=category/admin-category-list">Category</a>
<a href="/?p=admin.index&w=category/admin-post-list">Posts</a>
<a href="/?p=admin.user.list">Mall</a>
<?php
include widget(in('w') ?? 'user/admin-user-list');
?>
```

- Recommended admin page(widget) layout. You can pass child widget path over `cw` to include a child widget inside.
```html
<div class="container">
    <div class="row">
      <div class="col-3">
        <h3>title</h3>
        ... left side menu...
      </div>
      <div class="col-9">
        ... content ...
        <?php
          include widget( in('cw', 'shopping-mall/admin-shopping-mall-list') );
        ?>
      </div>
    </div>
</div>
```

- If you don't simply need to refer a script inside the widget folder, use `s` instead.
```php
<?php
include in('s', 'list') . '.php';
?>

```


- When you submit the form, the may code like below.
  - Below are the category create sample.
  - When the form is submitted, it reloads(redirect to the current page) and create the category.

```html
<?php
if ( modeCreate() ) {
    $re = category()->create([ID=>in('id')]);
}
?>
<form>
  <input type="hidden" name="p" value="admin.index">
  <input type="hidden" name="w" value="category/admin-category-list">
  <input type="hidden" name="mode" value="create">
  <input type="text" name='id' placeholder="카테고리 아이디 입력">
  <button type="submit">Create</button>
</form>
```


# FORM

- FORM 은 가능한 post method 로 전송한다.
  
- 글 작성과 같은 데이터 생성 페이지는 `<input type="hidden" name="p" value="forum.comment.edit.submit">` 처럼 `p` 값의 끝을 `.sumit` 으로 한다.
  그러면, 테마를 실행하지 않고, 바로 그 스크립트를 실행한다. 즉, 화면에 번쩍임이 사라지게 된다.
  
- 글/코멘트 쓰기에서 FORM hidden 으로 `<input type="hidden" name="returnTo" value="post">` 와 같이 하면, 글/코멘트 작성 후 글(루트 글)로 돌아온다.


# 글 쓰기

- 글 쓰기 기본 FORM 을 보고 새로운 디자인을 만들 수 있으며, 글 쓰기 FORM 이 데이터를 전송 할 때, 기본적으로 사용되는 `themes/default/post.edit.submit.php` 스크립트를 사용하면 된다.
  물론 필요에 따라 적절히 수정을 할 수 있다.
  참고로 수정을 할 때에는 다른 파일 이름으로 복사해서 사용 할 것을 권한다.



# Vue.js 3

- Below is the basic sculpture of using Vue.js 3 is. Every page should include the Vue javascript and mount.

```html
<section id="app">
  <input type="number" @keyup="onPriceChange" v-model="post.price">
</section>
<script src="<?=ROOT_URL?>/etc/js/vue.3.0.7.global.prod.min.js"></script>
<script>
    const app = Vue.createApp({
        data() {
            return {
                post: {
                    price: 1
                }
            }
        },
        created() {
            console.log('created');
        }
    }).mount("#app");
</script>
```



# Hook System

* 훅을 실행하고 싶은 곳에서 `hook()->run('name', 'vars')` 와 같이 하면 된다.
* 훅 함수들은 `hook()->add(function() {})` 와 같이 정의하면 된다.

예제) widgets/setting/admin-setting/admin-setting.php
```html
<?=hook()->run('admin-setting', $ms)?>
```

예제) themes/itsuda/itsuda.hooks.php
```php
hook()->add('admin-setting', function($settings) {
$account_info = $settings['account_info'] ?? '';
echo <<<EOH
<h2>쇼핑몰 입금 통장 번호</h2>
<input type="text" class="form-control mb-2" name='account_info' value="$account_info" placeholder="예금주 은행 계좌번호">
<div class="hint">
  쇼핑몰에 표시 될 무통장 입금 정보를 입력해주세요. 예) 주식회사 위드플랜잇 국민은행 XXXX-XXXX-XXXX
</div>
EOH;
```


* Hook 함수는 각 테마 별로 config.php 에서 정의하면 되고, hook 코드가 커지면 `[theme-name].hooks.php` 로 따로 모으면 된다.
* 동일한 hook 이름에 여러개 훅을 지정 할 수 있다.
* 훅 함수에는 변수를 얼마든지 마음데로 지정 할 수 있으며 모두 reference 로 전달된다.
* `posts_before_create` 훅 함수가 에러 문자열을 리턴하면 다른 훅은 모두 실행이 안되고, 글/코멘트 생성이 중지된다.

* 모든 훅 함수는 값을 리턴하거나 파라메타로 받은 레퍼런스 변수를 수정하는 것이 원칙이다.
  * 가능한, 어떤 값을 화면으로 출력하지 않도록 해야하지만,
  * 글 쓰기에서 권한이 없는 경우, 미리 체크를 해야하지만, 그렇지 못한 경우 훅에서 검사해서
    Javascript 로 goBack() 하고 exit 할 수 있다.
    이 처럼 꼭 필요한 경우에는 직접 HTML 출력을 한다.

* 훅의 목적은 가능한 기본 코드를 재 사용하되, 원하는 기능 또는 UI/UX 로 적용하기 위한 것이다.
  * 예를 들면, 게시판 목록의 기본 widget 을 사용하되, 사용자 화면에 보이거나, 알림 등의 재 활용 할 수 있도록 하는 것이다.



## Entity hooks

* entity CRUD 에 대해서, 훅을 발생시킨다.

* 예를 들어, `posts_before_create` 이나 `posts_after_create` 훅은 posts enitty 생성 직전과 직후에 발생한다.
  글/코멘트가 posts entity 이며, 쇼핑몰이나 기타 여러가지 기능을 posts entity 로 사용 할 수 있다.
  이러한 모든 것들에 대해서 생성을 하고자 할 때, hook 을 통해서 원하는 작업을 할 수 있다. 만약, 작업이 올바르지 않으면 에러를 내서, entity 생성을 못하게 할 수도 있다.

### Entity Create 훅

- 대표적인 것으로 `posts_before_create` 와 `posts_after_create` 가 있다.
  `posts_before_create` 훅 함수로 전달되는 값은 생성 직전의 record 와 전에 입력 값이다.
  `posts_after_create` 훅 함수로 전달되는 값은 생선된 entity 값과 전에 입력 값이다.
  

```php
hook()->add('posts_before_create', function($record, $in) {
    debug_log("-------------- 1st hook of posts_before_create ");
    if ( !isset($record[ROOT_IDX]) || empty($record[ROOT_IDX]) ) { // 글 작성
        debug_log("글작성;", $record);
    }
    else if ( isset($record[ROOT_IDX]) && $record[ROOT_IDX] ) { // 코멘트 작성
        if ( $record[ROOT_IDX] == $record[PARENT_IDX] ) { // 첫번째 depth 코멘트. 즉, 글의 첫번째 자식 글. 자손의 글이 아님.
            debug_log("첫번째 depth 코멘트 작성;", $record);
        } else { // 첫번째 depth 가 아닌 코멘트. 단계가 2단계 이하인 코멘트. 즉, 코멘트의 코멘트.
            debug_log("코멘트의 코멘트 작성;", $record);
        }
    }
    return 'error_reject_on_create'; // 에러를 리턴하면, 글 쓰기 중지.
});

hook()->add('posts_before_create', function($record, $in) {
    debug_log("-------------- 두번째 훅: hook of posts_before_create", $in);
});
```




## 훅 목록과 설명

### 전체 훅 목록

* html_head

* html_title

* site_name - HTML 에 사이트 이름을 출력 할 때

* `favicon` - 파비콘을 변경 할 수 있는 훅

예제) 훅에서 값을 리턴하면 그 값을 경로로 사용. 아니면, favicon.ico 를 사용.

```html
<link rel="shortcut icon" href="<?= ($_ = run_hook('favicon')) ? $_ : 'favicon.ico'?>">
```

* posts_before_search
  글 가져오는 옵션을 변경 할 수 있는 훅. 예) 국가별 카테고리에서, 카테고리 지정이 없으면, 국가 카테고리로 기본 지정한다.

* posts_after_search
  
* forum_list_header_top - 게시판 목록 최 상단에 표시
* forum_list_header_bottom - 게시판 목록의 헤더의 맨 아래 부분에 표시.

* forum_category - 포럼의 전체 영역(카테고리 목록이나 글 쓰기 등)에서 해당 게시판의 category 정보를 변경 할 수 있다.
  이를 통해 cat_name 등을 변경 하여 게시판 이름을 다르게 출력 할 수 있다.

* `widgets/posts/latest option` - 최근 글 위젯에서 글을 가져오기 전에 옵션을 수정 할 수 있는 훅
  `widgets/**/**` 에 기본적으로 모든 위젯의 훅이 들어있도록 한다.


* `widget/config.category_name categories`
  다이나믹 위젯 설정에서 카테고리를 재 지정 할 수 있다.
  전달되는 변수는 get_categories() 의 결과인데,
  변경을 하려면 배열에 category term object 를 넣어주거나
  [stdClass(slug ='', cat_name=>'')] 과 같이 slug 와 cat_name 을 가지는 stdClass 를 넣어줘도 된다.

  특히, 교민 포털 카테고리에서는 게시판 카테고리가 존재하지 않을 수도 있으므로, stdClass 로 만들어 넣어줘야한다.

* `widget/config.category_name default_option`
  카테고리 선택에서, 선택된 값이 없을 경우, 기본적으로 보여 줄 옵션이다. 보통은 빈 값에, "카테고리 선택" 을 표시하면 된다.
  하지만, 카페에서는 카테고리 선택이 되지 않은 경우, 국가별 카테고리로 검색을 제한해야 한다.


### 게시판 설정 훅


### 훅으로 HTML TITLE 변경하기

* 먼저 아래와 같이 HTML 페이지의 제목에서, `html_title` 훅을 통해서, 리턴 값이 있으면 그 리턴 문자열을 HTML TITLE 로 사용하게 한다.

````html
<TITLE><?= ($_ = hook()->run('html_title'))? $_ : ($settings['site_name'] ?? '') ?></TITLE>
````

* 그리고 `theme.functions.php` 아래와 같이 적절한 값을 리턴하면 된다.

````php
hook()->add('html_title', function() {
    if ( is_in_cafe() ) {
        $co = cafe_option();
        return $co['name'];
    }
});
````

### 훅으로 CSS 지정하기

* CSS 를 훅으로 지정해야하는 이유 중 하나는,
  * 페이지 스크립트에 `<style>` 을 추가하면 맨 HTML 에서 맨 밑에 추가되어 body background 를 지정하는 경우,
    먼저 추가된 css 의 body background 가 보이기 때문에 화면이 번쩍인다.
    그래서 아래와 같이 css 을 head 에 추가해서, 먼저 적용이 되도록 할 수 있다.

```php
<?php
add_hook('html_head', function() {
    return <<<EOS
<style>
    body {
        background-color: #5c705f !important;
        color: white !important;
    }
    header {
        margin-top: 1em;
        border-radius: 25px;
        background-color: white;
        color: black;
    }
    header a {
        display: inline-block;
        padding: 1em;
    }
    footer {
        margin-top: 1em;
        padding: 1em;
        border-radius: 25px;
        background-color: white;
        color: black;
    }
    .l-sidebar {
        margin-right: 1em;
        padding: 1em;
        border-radius: 25px;
        background-color: white;
        color: black;
    }
    .l-body-middle {
        border-radius: 25px;
        min-height: 1024px;
        background-color: white;
        color: black;
    }
</style>
EOS;

});
```


# 포인트 시스템

- 포인트를 적용하는 곳(회원 가입, 로그인, 글 쓰기/삭제, 코멘트 쓰기/삭제, 추천, 비추천 등)에서는 포인트의 변화가 없어도(포인트 증감이 없어도) 기록을 남긴다.
  
- 이 기록을 바탕으로 추천/글쓰기/코멘트쓰기 시간/수 제한, 일/수 제한을 한다.
  
- 일/수 제한은 해당일(오늘) 0시 0분 0초 부터 현재 시간까지 해당 글/코멘트/추천 들이 얼마나 발생했는지 확인하고 제한한다.
  예를 들어, 현재 시간이 14시 14분 14초 라면, 오늘 0시 0분 0초 부터 지금 현재 14시 14분 14초 까지 시간을 제한하는 것이다.

  즉, 하루에 10개를 제한 한다면, 0시 0분 0초 부터, 23시, 59분 59초 까지 10개를 썼는지 검사를 하는 것이다.
  만약, 23시 59분에 10개를 쓰고, 그 다음을 0시 0분에 또 10개를 쓸 수 있다. 즉, 20개를 연달아 쓸 수 있다.

- 게시판에는 Ymd 필드에 글 쓴 날짜의 YYYYMMDD 형식의 날자 값이 저장된다. 이 값은 글 쓰기에서 제한이 되지 않는다.

## 포인트 시스템 활용도

- 예를 들어, 방명록 또는 출석부에 글 쓰는 경우, 200 포인트씩 증가하는데, 하루에 한번만 충전하게 하고 싶다면,
  attendance 게시판에, 일/수 제한으로 1을 하고, 글 쓰기 포인트에 200 으로 입력하면 된다.

- 예를 들어, 그림 짝 맞추기 게임을 성공하는 경우, 100 포인트 씩 하루에 5번까지만 포인트 충전이 되게하고 싶다면,
  game 게시판에 글 쓰기 포인트 100 포인트를 입력하고, 일/수에 5를 입력한다.
  그리고 게임에서 짝 맞추기 성공하면, 게시판에 글을 하나 쓰면 되는 것이다.
  그리고 게임은 계속 할 수 있어도, 포인트는 5번만 증가한다.


활동에 따른 포인트 보너스 지정

보너스 포인트의 경우, 관리자 페이지에서 포인트 설정이 가능하다.

예를 들어, 가입 인사를 쓰는 경우 30 포인트씩, 하루 최대 10번을 주려고 한다면,
가입 인사 게시판에 글 쓰기 포인트에 30을 주고, 일/수 제한에 10을 준다.
이렇게하면 하루 최대 10번, 포인트 보너스를 얻을 수 있다.
11번 이상 글을 쓸 수 있지만, 포인트는 10번만 적용된다.


또 다른 예로, 출석부 게시판을 만들고 하루에 한번만 글 쓰게 하고, 글 쓸 때 마다 포인트를 50씩 주고 싶다면,

출석부 게시판에 글 쓰기 포인트를 50을 입력하고,
일/수 제한에 1을 입력하고,
글/코멘트에 제한을 선택하면,

하루에 한번만 글을 쓸 수 있고, 글을 쓸 때마다 포인트 50씩 증가한다.


이 처럼, 글을 쓰면, 다양하게 보너스 포인트 회원들에게 줄 수 있다.

일/수 제한 외에 시간/수 제한이 있다. 시간/수 제한은 몇 시간에 몇 회로 제한하기 위한 것이다.

일/수와 시간/수 제한을 동시에 쓸 수 있는데,

예를 들어 하루에 10번으로 제한한다면, 밤 11시 59분에, 10번하고, 새벽 0시 1분에 10번하는 등 연속으로 20번을 할 수가 있는 것이다.
하지만, 시간/수를 제한해서, 한 시간에 3 번으로 제한 한다면,

하루 10번을 할 수 있지만, 1시간에 최대 3번 밖에 하지 못한다. 즉, 10번을 모두 하려면 최소 4시간이 걸리는 것이다.



글을 삭제하고 다시 작성한다고 해서, 포인트가 계속 충전되는 것은 아니다.
예를 들어, 출석부 게시판에 하루에 1번만 글을 쓸 수 있고, 포인트가 충전되었는데,
출석부 게시판에 글 쓰고, 포인트를 중복으로 얻기 위해서, 글을 삭제하고, 다시 써도 포인트는 중복으로 충전되지 않는다.


추천 보너스

글 쓰기, 코멘트 쓰기 등은 각 게시판 별로 보너스 포인트를 지정 할 수 있지만, 추천 보너스의 경우, 게시판 별로 보너스 포인트를 선택 지정 할 수 없으며, 전체 게시판에 적용된다.

예를 들어, 추천 포인트를 5 로 하면, 모든 게시판의 글에 추천을 하면 포인트가 추가된다.

추천 보너스 역시 일/수, 시간/수 제한을 할 수 있다.






게임 포인트

틀린 그림 찾기

게임을 하면, 그 기록이 게시판에 기록된다.

틀린 그림 찾기는 틀린 그림을 찾으면, ‘find_wrong_picture’ 게시판에 기록된다.
(주의: wrong_picture 는 게임 사진을 등록하는 게시판)
즉, 게임에서 정답을 맞춘 경우, 기록을 하는 것이다.

이 때, 포인트를 주기 위해서 find_wrong_picture 게시판의 글 쓰기 10점 또는 20점 등으로 기록을 하면 된다.
그리고 하루에 제한하고자 하는 회수를 일/수 제한에 10번 도는 20번 으로 제한을 하면 된다. 원한다면 시간/수 제한을 할 수도 있다.

게임은 무제한으로 플레이 가능하나, 포인트 충전은 일/수 제한 한 것 만큼만 된다. 그 이상은 포인트 충전 안된다.


그림 짝 맞추기

틀린 그림 찾기와 동일한 방식으로 포인트를 지정하면 된다.

단, 그림 짝 맞추기는 3개의 게시판으로 나뉘어져 있다.

card_flip0 은 어려운(상) 게임
card_flip1 은 중간(중) 게임
card_flip2 는 쉬운(하) 게임이다

게임을 맞추면, 각 게시판에 글이 기록되고, 포인트가 해당 사용자에게 추가된다.
그래서 어려운 게임에 포인트를 조금 더 주고, 중간 게임에 약간 덜 주고, 쉬운 게임에 더 덜주면 된다.
예) card_flip0 글쓰기에 30포인트, card_flip1 글 쓰기에 20포인트, card_flip2 글 쓰기에 10 포인트.

그리고 일/수 제한 5번으로 하면, 게임은 계속 플레이 가능하지만, 포인트는 각 게임마다 총 5번 가능하다. 3개의 게임이 있으므로 최대 15번 포인트 획득이 가능한 것이다.










# 파이어베이스

## Firestore 퍼미션

```txt
    /// Notifications
    match /notifications/{docId} {
      allow read: if true;
      allow write: if true;
    }
```

# 데이터베이스 테이블

## posts

- `relationIdx` 는 현재 글이 어느 것(또는 다른 taxonomy 의 entity)과 연결되어져 있는지 표시 할 때 사용한다.
  예를 들면, 쇼핑몰에서 상품 A 에 대한 문의를 남기는데, 문의는 inquiry 게시판에 모두 기록된다.
  참고, 일반적인 문의는 채팅방 형식이 될 수 있다. 1:1 문의는 채팅방이 적당하나, 공개를 할 수 없다. 즉, 공개 문의를 할 수 없다.
  참고, 쇼핑몰 상품 A 에 대한 후기는 코멘트로 남긴다.
  참고, 문의가 상품 별로 공개 문의 또는 사용자 선택에 의해서 비밀 문의로 되어져야 한다면, 별도의 게시판에 문의를 작성해야한다.
  이 때, 문의 게시판에 작성된 문의가 어느 상품의 것과 연관되어져 있는지, relationIdx 로 표시 할 수 있다.
  이처럼 여러가지 방식으로 활용 할 수 있다.
  
- `private` 은 현재 글이 비밀글인지 아닌지를 'Y/N'으로 표시한다.
  주의: `private` 일 때에는 글 제목과 내용을 `private_title` 과 `private_content` 로 저장한다. 그래서 검색에서 완전 배제를 한다.
  
- 'Y' 는 찬성(또는 like) 수
- 'N' 은 반대(또는 dislke) 수

- `Ymd` 는 글을 쓴 시점의 날짜(YYYYMMDD)의 값이 자동으로 들어간다.



## files

- taxonomy, entity 는 예를 들어, posts taxonomy 의 어떤 글 번호에 연결이 되었는지 또는 users taxonomy 의 어떤 사용자와 연결이 되었는지 나타낸다.
- code 는 파일의 코드 값으로 예를 들어, taxonomy=users AND entity=사용자번호 AND code=profilePhoto 와 같이 업로드된 파일의 특성을 나타낼 때 사용 할 수 있다.




# Markdown

```php
<?php
$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render ($md);
?>
```

# Unit Testing

- 2021년 3월 기준, PHPUnit 이 PHP8 을 완벽히 지원하지 않는 것인지, 실행이 잘 안된다. 하지만, 에러가 나는 부분이 EzSQL 인 것을 감안하면, EzSQL 에 문제가 있지 싶다.
  - 그래서, 테스트 로직을 직접 작성했다.
  
- 아래와 같이 실행하면, `tests/*.test.php` PHP 스크립트(파일)을 실행한다.
  - php container 이름과 centerx 설치 폴더를 잘 지정하면 된다.

```shell
chokidar '**/*.php' -c "docker exec [php_container_name] php [centerx_folder_name]/tests/test.php"
```

- 원한다면, 아래와 같이 테스트 파일의 일부 문자열을 포함하는 파일만 실행 할 수 있다.
  - 테스트 파일 이름에 "app" 또는 "user" 라는 문자열이 있으면 실행한다.
  
```shell
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic."
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic.entity.search"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php app"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php user"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php point"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php shopping-mall"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php getter"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php purchase.android"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php next"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php next.entity.search"
chokidar '**/*.php' -c "docker exec docker_php php /root/tests/test.php friend"
```



# User Activity

- Most of user actions are recorded in the `point_histories`.
  The actions are user register, login, post create, delete, like, dislike, and more.
  
  - When an entity of `posts` is created, taxonomy is `posts`, and the entity is the idx of the record, and categoryIdx is the category.idx.
    An entity of `posts` may be a post, a comment, or any record in `posts` table.
    
  - `fromUserIdx` is the user who trigger the action.
  - `toUserIdx` is the user who takes the benefit.
  - If the values of `fromUserIdx` and `toUserIdx` are same, then, `fromUserIdx` may be 0. Like user register, login, post create, delete, comment create, delete.
  - Note that, when a user like or dislike on his own post or comment, there will be no point history.
  
- For like and dislike, the history is saved under `post_vote_histories` but that has no information about who liked who.




# 사진업로드

- 파일 업로드를 할 때, Vue 를 사용 할 수 있고, 그냥 Vanilla Javascript 를 사용 할 수 있다.

## Vue.js 를 사용한 예제

- 아래는 글 작성(생성, 수정)을 하는 기본 예제이다. Vue.js 버전 3 를 통해서 파일을 업로드한다.

```html
<?php
$post = post(in(IDX, 0));
if ( in(CATEGORY_ID) ) {
    $category = category( in(CATEGORY_ID) );
} else if (in(IDX)) {
    $category = category( $post->v(CATEGORY_IDX) );
} else {
    jsBack('잘못된 접속입니다.');
}
?>
<div id="post-edit-default" class="p-5">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="files" v-model="files">
        <input type="hidden" name="<?=CATEGORY_ID?>" value="<?=$category->v(ID)?>">
        <input type="hidden" name="<?=IDX?>" value="<?=$post->idx?>">
        <div>
            title:
            <input type="text" name="<?=TITLE?>" value="<?=$post->v(TITLE)?>">
        </div>
        <div>
            content:
            <input type="text" name="<?=CONTENT?>" value="<?=$post->v(CONTENT)?>">
        </div>
        <div>
            <input name="<?=USERFILE?>" type="file" @change="onFileChange($event)" />
        </div>
        <div class="container photos">
            <div class="row">
                <div class="col-3 col-sm-2 photo" v-for="file in uploadedFiles" :key="file['idx']">
                    <div clas="position-relative">
                        <img class="w-100" :src="file['url']">
                        <div class="position-absolute top left font-weight-bold" @click="onFileDelete(file['idx'])">[X]</div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>


<script>
  alert('fix to vu2;');
    const postEditDefault = Vue.createApp({
        data() {
            return {
                percent: 0,
                files: '<?=$post->v('files')?>',
                uploadedFiles: <?=json_encode($post->files(), true)?>,
            }
        },
        created () {
            console.log('created() for post-edit-default');
        },
        methods: {
            onFileChange(event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                fileUpload(
                    file,
                    {
                        sessionId: '<?=login()->sessionId?>',
                    },
                    function (res) {
                        console.log("success: res.path: ", res, res.path);
                        postEditDefault.files = addByComma(postEditDefault.files, res.idx);
                        postEditDefault.uploadedFiles.push(res);
                    },
                    alert,
                    function (p) {
                        console.log("pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
            onFileDelete(idx) {
                const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
                if ( re === false ) return;
                axios.post('/index.php', {
                    sessionId: '<?=login()->sessionId?>',
                    route: 'file.delete',
                    idx: idx,
                })
                    .then(function (res) {
                        checkCallback(res, function(res) {
                            console.log('delete success: ', res);
                            postEditDefault.uploadedFiles = postEditDefault.uploadedFiles.filter(function(v, i, ar) {
                                return v.idx !== res.idx;
                            });
                            postEditDefault.files = deleteByComma(postEditDefault.files, res.idx);
                        }, alert);
                    })
                    .catch(alert);
            }
        }
    }).mount("#post-edit-default");
</script>
```

## Vue.js 2 로 하나의 글에 코드 별 여러 사진(파일) 업로드 & 컴포넌트로 작성

- 아래의 코드는 게시글을 작성 할 때, 코드 별로 사진을 업로드하는 예제이다.
  
- 쇼핑몰과 같이 이미지를 특별한 용도 별로 업로드하고자 할 때 유용하게 사용 할 수 있다.

- 아래의 코드에서 `photo-upload` 는 아주 유용한 코드여서, `app.js` 에 `upload-by-code` 로 추가되어져 있다.
  따라서, 그냥 `mixins.push({ })` 에서 `files` 변수만 reactivity 하게 하면 된다.
  그리고, 이런 방식은 `widgets/post-edit/post-edit-upload-by-code.php` 에서 멋지게 사용된다.

```html
<?php
$post = post(in(IDX, 0));

if ( in(CATEGORY_ID) ) {
    $category = category( in(CATEGORY_ID) );
} else if (in(IDX)) {
    $category = category( $post->v(CATEGORY_IDX) );
} else {
    jsBack('잘못된 접속입니다.');
}
?>
<style>
    .size-80 { width: 80px; height: 80px; }
</style>
<div id="itsuda-event-edit" class="p-5">
    <form action="/" method="POST">
        <input type="hidden" name="p" value="forum.post.edit.submit">
        <input type="hidden" name="returnTo" value="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000" />
        <input type="hidden" name="<?=CATEGORY_ID?>" value="<?=$category->v(ID)?>">
        <input type="hidden" name="<?=IDX?>" value="<?=$post->idx?>">
        <input type="hidden" name="files" v-model="files">

        <div class="form-group">
            <small id="" class="form-text text-muted">이벤트 제목을 적어주세요.</small>
            <label for="">제목</label>
            <div>
                <input class="w-100" type="text" name="title" value="<?=$post->title?>">
            </div>
        </div>

        <div class="form-group">
            <small id="" class="form-text text-muted">이벤트 내용을 적어주세요.</small>
            <small class="form-text text-muted">이벤트 날짜, 담청자 목록 등을 적을 수 있습니다.</small>
            <label for="">내용</label>
            <div>
                <textarea class="w-100" rows="10" type="text" name="content"><?=$post->content?></textarea>
            </div>
        </div>
        <hr>
        <photo-upload post-idx="<?=$post->idx?>" code="banner" label="배너 사진" tip="배너 사진을 등록해 주세요. 너비 4, 높이 1 비율로 업로드해 주세요."></photo-upload>
        <photo-upload post-idx="<?=$post->idx?>" code="content" label="내용 사진" tip="내용 사진을 업로드 해 주세요."></photo-upload>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<script>
    Vue.component('photo-upload', {
        props: ['postIdx', 'code', 'label', 'tip'],
        data: function() {
            return {
                percent: 0,
                file: {},
            }
        },
        created: function() {
            console.log('created for', this.postIdx, this.code);
            if ( this.postIdx ) {
                const self = this;
                request('file.byPostCode', {idx: this.postIdx, code: this.code}, function(res) {
                    console.log('byPostCode: ', res);
                    self.file = Object.assign({}, self.file, res);
                }, alert);
            }
        },
        template: '' +
            '<section class="form-group">' +
            '   <small class="form-text text-muted">{{tip}}</small>' +
            '   <label>{{label}}</label>' +
            '   <img class="mb-2 w-100" :src="file.url">' +
            '   <div>' +
            '       <input type="file" @change="onFileChange($event, \'banner\')">' +
            '   </div>' +
            '</section>',

        methods: {
            onFileChange: function (event) {
                if (event.target.files.length === 0) {
                    console.log("User cancelled upload");
                    return;
                }
                const file = event.target.files[0];
                const self = this;

                // 이전에 업로드된 사진이 있는가?
                if ( this.file.idx ) {
                    // 그렇다면, 이전 업로드된 파일이 쓰레기로 남지 않도록 삭제한다.
                    console.log('going to delete');
                    request('file.delete', {idx: self.file.idx}, function(res) {
                        console.log('deleted: res: ', res);
                        self.$parent.$data.files = deleteByComma(self.$parent.$data.files, res.idx);
                    }, alert);
                }

                // 새로운 사진을 업로드한다.
                fileUpload(
                    file,
                    {
                        code: self.code
                    },
                    function (res) {
                        console.log("success: res.path: ", res, res.path);
                        self.$parent.$data.files = addByComma(self.$parent.$data.files, res.idx);
                        self.file = res;
                    },
                    alert,
                    function (p) {
                        console.log("("+self.code+")pregoress: ", p);
                        this.percent = p;
                    }
                );
            },
        },
    });

    mixins.push({
        data: {
            files: '<?=$post->v('files')?>',
        },
    });
</script>
```



## Vue.js 3 로 특정 코드로 이미지를 업로드하고 관리하는 방법

- 아래의 예제는 PHP 와 연동하여, 특정 코드에 사진을 업로드하고, 관리자 설정에 file.idx 를 저장한다. 그래서 나중에 재 활용 할 수 있도록 한다.

```html
<?php
$file = files()->getByCode(in('code'));
?>
<section id="admin-upload-image">
  <form>
    <div class="position-relative overflow-hidden">
      <button class="btn btn-primary" type="submit">사진 업로드</button>
      <input class="position-absolute left top fs-lg opacity-0" type="file" @change="onFileChange($event)">
    </div>
  </form>
  <div v-if="percent">업로드 퍼센티지: {{ percent }} %</div>
  <hr>
  <div class="" v-if="src">
    <img class="w-100" :src="src">
  </div>
</section>

<script>
  alert('fix to vu2;');
  const adminUploadImage = Vue.createApp({
    data() {
      return {
        percent: 0,
        src: "<?=$file->url?>"
      }
    },
    mounted() { console.log("admin-upload-image 마운트 완료!"); },
    methods: {
      onFileChange(event) {
        if (event.target.files.length === 0) {
          console.log("User cancelled upload");
          return;
        }
        const file = event.target.files[0];
        fileUpload( // 파일 업로드 함수로 파일 업로드
                file,
                {
                  sessionId: '<?=login()->sessionId?>',
                  code: '<?=in('code')?>',
                  deletePreviousUpload: 'Y'
                },
                function (res) {
                  console.log("파일 업로드 성공: res.path: ", res, res.path);
                  adminUploadImage.src = res.url;
                  adminUploadImage.percent = 0;
                  axios({ // 파일 업로드 후, file.idx 를 관리자 설정에 추가.
                    method: 'post',
                    url: '/index.php',
                    data: {
                      route: 'app.setConfig',
                      code: '<?=in('code')?>',
                      data: res.idx
                    }
                  })
                          .then(function(res) { console.log('app.setConfig success:', res); })
                          .catch(function(e) { conslole.log('app.setConfig error: ', e); })
                },
                alert, // 에러가 있으면 화면에 출력.
                function (p) { // 업로드 프로그레스바 표시 함수.
                  console.log("업로드 퍼센티지: ", p);
                  adminUploadImage.percent = p;
                }
        );
      },
    }
  }).mount("#admin-upload-image");
</script>
```

## 바닐라 자바스크립트를 사용하여, 코드 별 파일 업로드 예제

- 다음은 바닐라 자바스크립트를 사용한 예제이다. 특징적으로는 코드별로 사진을 업로드한다.
  즉, 게시판처럼 그냥 하나의 글에 여러 사진을 올리는 것이 아니라, 쇼핑몰의 대표사진, 설명사진, 위젯 사진 등으로 나누어 업로드하고 활용하는 것이다.
  
- 주의 할 점은, 새로운 사진을 업로드 할 때, 이전 사진이 삭제되도록, 먼저 삭제 버튼을 두어, 삭제하도록 한다.

```html
<script>
    function onFileChange(event, id) {
        const file = event.target.files[0];
        fileUpload(
            file,
            {
                sessionId: '<?=login()->sessionId?>',
            },
            function (res) {
                console.log("success: res.path: ", res, res.path);
                const $input = document.getElementById(id);
                $input.value = res.idx;
                const $img = document.getElementById(id + 'Src');
                $img.src = res.url;
            },
            alert,
            function (p) {
                console.log("pregoress: ", p);
            }
        );
    }

    function onClickFileDelete(idx, id) {
        const re = confirm('Are you sure you want to delete file no. ' + idx + '?');
        if ( re === false ) return;
        axios.post('/index.php', {
            sessionId: '<?=login()->sessionId?>',
            route: 'file.delete',
            idx: idx,
        })
            .then(function (res) {
                const $input = document.getElementById(id);
                $input.value = '';
                const $img = document.getElementById(id + 'Src');
                $img.src = '';
            })
            .catch(alert);
    }
</script>
```

## Vue.js 3 로 코드 별 파일을 업로드하고, 기존에 업로드된 파일을 삭제하는 코드

- widget/post-edit/itsuda-brain 을 참고한다.


## Vue.js 2 로 서버와 통신하는 예제

- 아래의 코드는 Vue.js 3 에서 사용해도 된다.

```javascript
function request(route, params, success, error) {
  if ( ! params ) params = {};
  // If user has logged in, attach session id.
  if ( Cookies.get('sessionId') ) params['sessionId'] = Cookies.get('sessionId');
  params['route'] = route;
  axios.post('/index.php', params).then(function(res) {
    if (typeof res.data.response === 'string' ) error(res.data.response);
    else success(res.data.response);
  }).catch(error);
}
request('app.version', {}, console.log, console.error);
request('user.profile', {}, console.log, console.error);
```



## Vue.js 2 로 게시글 읽기 페이지에서 코멘트와 사진을 생성하고 수정, 삭제하는 예제

- Vue.js 3 가 IE11 을 지원하지 않는다. 대한민국에서는 IE 를 뺄 수 없다. Vue.js 2 에서는 IE9 부터 지원한다. 그래서 Vue.js 3 로 작업을 하다가, Vue.js 2 로 바꾸었다.
- [vue2 브랜치 post-view-default](https://github.com/thruthesky/centerx/blob/vue2/widgets/post-view/post-view-default/post-view-default.php)참고

# 원하지 않는 접속 차단

- etc/kill-wrong-routes.php 에서 한다.

# 캐시

- 캐시가 특정 시간보다 오래되었는지 또는 시간 경과했는지는 `cache('code')->olderThan(100)` 와 같이 하면 된다. 초단위이다.

- 캐시를 사용하는 예(로직)는 다음과 같다.

```php
$currency = cache('PHP_KRW'); // 캐시 객체
if ( $currency->olderThan(10) ) { // 10 초 보다 오래 되었으면,
    // renew() 함수를 실행해서, 캐시 갱신 작업 중이라고 알린다.
    // 내부적으로 createdAt 을 현재 stamp 로 변경하는데, 이렇게하면, 다른 프로세서가 중복으로 갱신 작업하지 않는다. 하지만 또한 다른 프로세서는 이전 캐시를 그대로 쓸 수 있다.
    $currency->renew();
    
    
    /// 여기서 원격에서 캐시를 가져온다.
    /// 
    
    /// 그리고 아래와 같이 업데잍를 한다. 그러면 다시 한번 createdAt 을 현재 stamp 로 저장한다. 모든 프로세서가 새로운 캐시 값을 쓸 수 있다.
    $currency->set(23.39 + time());
}
$phpKwr = $currency->data;
echo "현재 환율: $phpKwr";
```


# 카테고리 테이블

- userIdx 는 게시판 관리자이다. 카페인 경우, 카페 주인이 된다.
- domain 은 게시판의 도메인이다. 홈페이지 도메인일 수도 있고, 그냥 그룹일 수도 있다. 카페의 경우, 카페 도메인이 된다.
- countryCode 는 국가 코드이다. 해당 게시판(또는 카페가) 어느 국가에 속해 있는지 표시를 하는 것이다.



# 카페

* 게시판 1개를 카페로 해서, 최소한의 기능만으로 카페 또는 전세계 교민 카페를 만든다.
  * 카페 당 게시판 1개가 할당된다.
  * id 에는 카페 전체 도메인. 2차 도메인 전체.
  * domain 에는 root domain 만 저장된다.
  * 카페의 countryCode 에 해당 국가의 countryCode 가 저장된다.
  * 그리고 모든 국가별로 자유게시판, 질문게시판을 공통 사용 가능하도록, 각 게시글에 countryCode 를 카페의 countryCode 로 같이 쓴다.
  * 서브 카테고리를 최대 10개까지 사용가능하도록 하며, 컴퓨터 메인 메뉴에는 필고처럼 노란색 메뉴로 총 300 px 너비만큼만 보여준다. 메뉴명을 짧게하면 많이 보여 줄 수 있다.
  * 카페를 삭제하는 경우,
    - 글은 그대로 남는다.
    - 동일한 도메인으로 카페를 재 생성 할 수 있다.
    - 카페를 삭제하면, 카테고리에 도메인이 존재하지 않는데, 화면에 에러 알림창이나 redirect 를 하지 않고, 그 페이지에서, 존재하지 않는 카페라고 작은 메시지만 표시를 한다.
* IE 와 SEO(검색 로봇)을 위해서, 초간단 디자인 웹을 보여주고, 모던 브라우저가 접속하면, 플러터로 부팅한다.
* 플러터 앱에서 거의 모든 것을 다 한다.
* 단,  PC 버전 보기 옵션을 두어서, 서브도메인으로 테마를 다르게 해서 PC 버전으로 볼 수 있도록 한다. 그래서 글 쓰기 등을 편하게 할 수 있도록 한다.
* 본인인증을 하면, 커뮤니티 글 쓰기 가능. 카카오, 네이버로 접속하면, 장터 게시판에만 글 등록할 수 있도록만 한다.
- 카페 도메인별 PWA 설정을 할 수 있도록 한다.


# 국가 정보

국가 정보를 wc_countries 테이블 에 저장 해 놓았으며, etc/sql/countries.sql 에 SQL 로 dump 해 놓았다.

테이블에 들어가 있는 정보는 아래와 같다.

- `CountryNameKR` 한글 국가 이름. 예) 아프가니스탄, 대한민국
  
- `CountryNameEN` 영문 국가 이름. 예) Japan, South Korea
  
- `CountryNameOriginal` 해당 국가 언어의 표기 이름. 예) 日本, الاردن , 한국

- `2digitCode` 국가별 2자리 코드. 예) JP, KR
  
- `3digitCode` 국가별 3자리 코드. 예) JPN, KOR

- `currencyCode` 통화 코드. 예) JPY, KRW

- `currencyKoreanName` 한글 통화 이름(명칭). 예) 엔, 원, 유로, 달러, 페소

- `currencySymbol` 통화 심볼. 예) ¥, €, ₩, HK$

- `ISONumericCode` 국가별 ISO 코드

- `latitude`, `longitude` 국가별 중심의 GEO Location. 국가별 수도가 특정 도시가 아닌, 국가의 토지 면적에서 중심이 되는 부분의 위/경도 값이다.
  이 값을 활용 예)
  사용자의 국가 정보를 알고 있으면 그 국가의 중심부의 lat, lon 을 구해서, 해당 국가의 날씨 정보를 추출 할 수 있다. 비록 그 위치가 특정 도시가 아닌, 나라 면적의 중심이지만 적어도 그 국가의 날씨 정보를 알 수 있다.
  
  

## 국가 정보 코딩 예제

- `lib/country.class.php` 와 `lib/data.php` 를 참고한다.


# Geo IP

- `get_current_country()` 함수로 현재 국가 정보 데이터를 가져 올 수 있는데, 매 접속 마다, 이 함수가 실행 될 수 있으며, performance 에 영향을 줄 수 있다.
  - 가장 좋은 방법은 SPA 를 통해서, 처음 접속시 한번만 실행하는 것이다.
  

# 플러터로 새로운 앱을 개발 할 때 해야하는 것

- 구글 계정 준비(또는 생성)

- 파이어베이스에서 프로젝트 생성
- 파이어베이스) 안드로이드 앱 추가
- 플러터) google-sercvies.json 파일을 다운로드하여 android/app 폴더에 저장
- 플러터) 5개의 파일에 앱 패키지 ID 를 변경
- 플러터) Keystore 생성 후, build.gradle 에 keystore.properties 연결
- 파이어베이스) Authentication 에 Email/password 가입 추가
- CenterX) Service Account 를 다운로드해서 Centerx 에 연결
- 파이어베이스) Firestore 생성 및 퍼미션 지정
- 플레이 + GCP + CenterX) In app purchase 서버 사이드 verification 을 위해서
  - 플레이에서 API Access 클릭,
  - GCP link 링크 선택,
  - GCP 에서 service account 키 생성
  - 플레이에 GCP 링크
  - GCP service account 를 centerx 에 연결
    - CenterX 의 android package name 과 service account path 지정


# 퍼미션 검사


- 퍼미션 검사는 lib/*.class.php 의 update(), delete() 에서 하지 않고,
  `post(1)->permissionCheck()->markDelete()->getError()` 와 같이 별도의 permissionCheck() 함수를 만들어서 사용 할 수 있도록 한다.
  - `permissionCheck()` 함수는 entity 클래스에 들어가 있어서, 모든 taxonomy 에서 사용가능하다.




# Forum & Post & Comment

## Post list parameters

- `subcategory` is the subcategory.
- `lsub` is the subcategory for listing only for that subcategory.
  - When a user creates a post under a category, you can pass `lsub` through the edit page and view page.
    - After edit or view, the user may return post list page. And the app can show the subcategory that he selected before.
  
- The reason why we need the two `subcategory` parameters is that when post is edited,
  it needs `subcategory` as input even though the user does not want list for that subcategory.
  And when the app redirects the user to the list, the app does not know to list the whole category list or only that subcategory.
  

# 관리자 페이지

## 게시판 관리

### 글 생성 위젯 옵션

글 생성 위젯 옵션에는 PHP INI 방식으로 내용을 입력 할 수 있다. `2차원 배열` 까지 정보를 입력 할 수 있다.

특히, 사진을 코드별로 업로드하는 위젯에서 `[upload-by-code]` 를 php.ini 방식의 입력을 통해서 여러개 사진을 업로드 할 수 있다.

# Vue.js 2 component

## upload-by-code

- Example of the usage of `upload-by-code`
- It needs `files` as hidden tag binded with `files` string.

```html

<input type="hidden" name="files" v-model="files">

<upload-by-code post-idx="<?=$post->idx?>" code="primaryPhoto" label="대표 사진" tip="상품 페이지 맨 위에 나오는 사진"></upload-by-code>
<upload-by-code post-idx="<?=$post->idx?>" code="widgetPhoto" label="위젯 사진" tip="각종 위젯에 표시"></upload-by-code>
<upload-by-code post-idx="<?=$post->idx?>" code="detailPhoto" label="설명 사진" tip="상품을 정보/설명/컨텐츠를 보여주는 사진"></upload-by-code>

<script>
    mixins.push({
        data: {
            files: '<?=$post->v('files')?>',
        },
    });
</script>
```

# 위젯

## 글 쓰기 위젯

### post-edit-upload-by-code

- 관리자 페이지의 위젯 옵션에서 아래와 같이 입력하면, 여러 가지 사진을 코드 별로 업로드 할 수 있다.

```ini
[upload-by-code]
banner[label]=배너
banner[tip]=배너입니다.
primary[label]=대표사진
primary[tip]=대표사진입니다.
content[label]=내용사진
content[tip]=내용사진입니다.
```
