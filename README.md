



### 주요 개발 요소

CenterX 는 Theme 별로 개별 사이트를 만들 수 있는데, 아래의 요소들을 사용한다.

- Vue.js 2.x (IE11 지원, PHP 에서 inline 으로 Vue.js 2 를 사용)
- Bootstrap 4.x (IE11 지원)
- BootstrapVue 2.x (IE11 지원)
- FontAwesome 5.x  
- /etc/css/x.css
- Firebase
  실시간 알림, Push notification 등을 Firebase 를 통해서 한다.
  

만약, Vue.js, Bootstrap, Font Awesome 등을 사용하지 않고, 다른 자바스크립트, CSS, 아이콘 등을 사용하고 싶다면 그렇게 하면 된다. 다만, CenterX 에서
제공하는 기본 위젯들이 Vue.js 와 Bootstrap, Font Awesome 을 기본으로 만들어져 있다. 그래서 이미 만들어진 위젯 기능을 사용하려 한다면, 위의 요소들을
사용해야 한다.


### 세부 개발 요소

- PHP 날짜 시간 관련 라이브러리인 Carbon 을 사용한다. 날짜/시간 관련해서는 이것을 꼭 사용한다.
  참고: `https://github.com/briannesbitt/carbon`

- geoip2
  IP 기반으로 사용자의 위치를 파악하는 기능. 무료 버전 사용. 유료 버전으로 변경을 해도 된다.
  


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

- [PHP + SPA](https://docs.google.com/document/d/1WG3caN7_3eXRhPthBgDAgzzkI-OrVir1Bvnrbt-nsR0/edit#heading=h.n7o87sszwfc6) 를 시도해 본다.


- Principle, Only controllers are the ones that deal with model.
  - View can only connect to controller to use models and its functionalities.
    View cannot connect to models directly.
    View can only get data through controllers.
  
- Change folder name form `library/toxonomy` to `model`.
  - `library/taxonomy/user/user.taxonomy.php` -> `model/user/user.model.php`
    - `UserTaxonomy` -> `UserModel`
  - Make all tests pass.

- `route` -> `controller`
  - Controller is a middle man between the client render view and model.
  - The controller only return data in JSON format. That means, you cannot use (or shoud not use) PHP in view(or theme).

  - Add some tests.

- `themes` -> `view`
  - Change 0. View(theme) is loaded from controller not directly from index.php
    - There will be `app.php` which render initial HTML for SPA.
  - Change 1. you can still use PHP in view(theme) but, all the data for the site must come from controller in JSON format.
  - Change 2. Since all data from controllers is in JSON format, the front-end should be SPA.

  - Move `etc/core/theme.php` to `etc/core/view.php`.  
  - Add some tests on `etc/core/view.php`

- @doc Continue using the term `taxonomy` as it is a term for classification data group.
  `files.taxonomy` and `metas.taxonomy` are very fine.
  

- Note, widgets may be used for extra ui design,
  but will be removed in version 3.
  
- Admin page is completely re-written by Vue.js 2
  
- `files` folder will be moved into `/var/files`
- delete `cypress` folder and cypress.json. Test will be done by Vue.js.
- delete `node_modules` and `package.json`, `live-reload.js`, `.prettierrc.json`, `.eslint**`.
  if needed, view is the one who need to set the node environment.
  
- delete `widgets` folder.

- send push notification if somebody likes on my comments or posts.

- Move test file into each controller and model folder.

- add `displayName` on user response.
  
- Do more work on backend. So, different client can do less work.
  For isntance,
    - sending push notification,
    - preparing data like `displayName` which first get from nickname, or name, or email.
  



- Git Repo 변경 및 다음 버전의 명칭
  - CenterX 대신 Matrix 로 변경
    - https://github.com/withcenter/matrix 로 repo 를 이동.
    - Matrix 에는 성장/발하는 모체라는 뜻이 있다.
      뜻: 가로/세로 나열한 행렬 또는 망. (사회 또는 개인이 성정하는, 발달하는) 모체.
    - 각종 표현/접두어/접미어를 'x' 로 한다.
      예: 기본 css 를 etc/css/x.css 로 저장한다.

- 경험치와 포인트를 따로 관리한다.
  - 포인트는 '소셜코인'으로 이름을 변경한다. S-coin 으로 표기.
  - 경험치는 순수히, 글 수, 코멘트 수, 내글의 총 코멘트 수, 추천 수 를 바탕으로 계산한다. 즉, 왠만해서는 감소하지 않는다.
    - 글 쓰기 활동을 하면, 계산해서 캐시를 한다.
    - 만렙 제대로를 두어서, 처음에는 50레벨 까지만, 그 후 부터 10레벨씩 레벨을 푼다.

- 공지사항을 beginAt 과 endAt 을 통해서, 언제 부터 언제까지인지 표시를 할 수 있도록 한다.



- 사용자 프로필을
  taxonomy=user, code=photoUrl 로 변경한다.
  

- html minify

- create search entity.

- entity()->read() 에서 entity 를 한번만 읽고, 메모리에 캐시한 후, 재 사용.
  update 나 delete 에서 $this->dirty = true 를 해 놓고,
  entity()->read() 에서 $this->dirty 가 true 이면 다시 읽는다.
  이렇게하면 login() 함수에서 따로 캐시를 할 필요 없이, 그냥 쓰면 된다.
  login() 함수 뿐만아니라, 많은 경우에서 메모리 캐시를 할 필요가 없다. 이 부분은 성능 개선을 위해서 매우 중요하다.



- 소너브
  countryCode 를 통한 국가별 게시판 관리.
  공유 게시판: discussion, qna, reminder, buyandsell, job, caution, rent_house, rent_car, school, 등 공용게시판. 카페장 메인메뉴 선택 가능.
  비공유게시판: 카테고리 아이디를 도메인과 동일하게 하고, 서브 카테고리를 최대 5개까지만 가능하도록 한다. 그리고 서브카테고리를 선택해서 메인 메뉴에 올릴수 있는데,
  모바일에서는 1개, 100픽셀 넓이(전체 360픽셀 중),
  데스크톱에서는 최대 3개, 200픽셀(전체 1024 픽셀 중).

- update country.test.php

- update external login like kakao, naver

- update test on in-app-purchase.

- update user switch option.



- 다음 버전.
  - 변경 사항이 많지만, 그래도 큰 변화는 아니다. 기존의 개념을 조금 변경하는 정도.
    그래서 repo 를 따로 만들 일이 아니다.
    하나씩 조금씩 변경하면서, 버전을 업데이트 해 나간다.
  - MVC 로 전환
    - Taxonomy 를 Model 로 변환( 폴더명 자체를 변경 )
    - Theme 을 View 로 변경. (폴더명 자체를 변경)
    - API 를 Controller 로 변경. (폴더명 자체를 변경).
      
    - 모든 접속을 Controller 로 한다.
      - index.php 에서 ./controller/control.php 를 실행하고,
        ./controller/post/list.php
        ./controller/post/view.php
        
        등으로 View 에서 쓰기도 하고, Rest API 에서도 그대로 쓰도록 한다.
      - Controller 에서는 아래와 같이 할 수 있도록 한다.
        route.php 를 좀 더 업데이트한다.

  - 프로젝트(최상위) 폴더에 model, view, controller 폴더를 둔다.

  - 모든 함수를 클래스로 변환. functions.php 에 있는 함수를 모두 클래스로 변환.
    - class Utilities {} 와 같이 하고 u()->xxxx() 또는 글로벌 변수 $u->xxx() 로 사용 할 수 있도록 한다.
      $u-> ... 또는 $f->... 와 같이 사용 할 수 있도록 한다.
  - Widget 기능은 그대로 사용하는데, 더 체계화를 한다.
  - 워드프레스의 플러그인 기능 처럼, 관리자페이지에서 추가를 할 수 있도록 한다.
  - 관리자페이지에서 도메인 별로 테마를 선택 하도록 한다.
  - 게시판 그룹 기능. 그룹 단위 목록, 검색 기능.



- @doc
  meta function may try to create child meta even if its taxonomy is meta. It only happens on testing.

- 필고를 보고, security 체크를 한다. security 패턴 검사를 관리자 페이지에서 입력 할 수 있도록 한다.
  - SELECT SQL 쿼리 word filtering 을 따로 두고, (글 추출 및 각종 해킹 시도. entity.class.php 에서 read, search 등에서 사용. )
  - INSERT/UPDATE 쿼리 word filtering 을 따로 둔다. (글 쓰기, 코멘트 쓰기용 필터링, 욕설 등록 및 기타, entity.class.php 에서 insert 에서 사용.)

- SQL 문장에서 쿼리 시간을 제한 할 수 있도록, config.php 에 설정을 한다.

- `boot_complete` 훅 추가. 이 훅은 `boot.php` 맨 마지막에서 호출 되는 것으로 각종 입력 값이나 각종 보안 관련 훅을 추가 할 수 있도록 한다.
  예를 들면, 특정 라우트나 페이지에서는 특정 HTTP 입력 값만 허용하도록 하고, 다른 값이 들어오면 에러가 나도록 한다. 그리고 각 값의 문자열 길이나, 타입을 검사해서, 잘못된 입력을 가려 낼 수 있도록 한다.

- 파일 업로드에서, 퍼미션이 없을 때, empty response 에러가 나온다. 올바른 에러가 표시되도록 할 것.

- 훅시스템
  - entity()->create(), update(), delete(), get(), search() 등에서만 훅을 걸면 왠만한 것은 다 된다.

- 배포
  .gitignore 에 기본적으로 widgets 폴더를 빼고, 배포를 원하는 위젯만 -f 로 넣을 것.


- 카테고리
  카테고리 및 서브카테고리 변경 기능.

- file upload error handling. https://www.php.net/manual/en/features.file-upload.errors.php
- 파일에 taxonomy 와 entity 추가

- 게시판 별 추천, 비추천 옵션 선택.

- 소셜 로그인 시, 프로필 사진 URL 경로가 https:// 이면, http:// 로 변경한다.


- CenterX 2.0
  - 오픈소스가 목표. 워드프레스 처럼 설치를 쉽게하고, 모듈과 테마를 동적으로 추가 할 수 있도록 한다.
  - Change name from CenterX to something else.
  - Support for web installation.
  - Change the system to MVC using mustache template.
  - @later API 보안.
    - CenterX 는 공개 소스이고, 프로토콜이 공개되어져 있으므로 누구든지, API 를 통해서 악의적으로 반복된 DB 액세스를 하여, DOS 공격을 할 수 있다.
      따라서, 허용된 클라이언트만 읽고 쓰도록 허용 할 수 방법을 강구해야한다.

    - 첫번째 방법은, API 자체적으로 보안을 하는 것으로,
      읽기는 1분에 100회,
      DB 작업 많이 들어가는 목록이나 검색은 1분에 20회,
      쓰기는 1분에 10회, 10분에 20회, 60분에 30회로 제한한다.
      총 용량은 60분에 글 1M 로 제한, 사진 20M 로 제한.
      이것을 관리자 페이지에서 변경 할 수 있도록 한다.

  - 그리고 db.config.php 가 존재하지 않으면 설치가 안된 것으로 한다.



- @doc SQLite3 지원할 필요없다. MariaDB(MySQL)이 절대적이고, Docker 를 통해서 쉽게 관리가 가능하다.


- @doc
  `https://local.itsuda50.com/?route=comment.get&idx=15224` 와 같이 글이나 코멘트를 가져올 때, 글/코멘트 생성시, 작성자에게 추가된 포인트가 `appliedPoint` 로 클라이언트에게 전달된다.


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



# Boot flow

- index.php
  - boot.php
    - prelight.php
    - etc/kill-wrong-routes.php
    - library/core/functions.php
    - library/core/theme.php
    - library/core/mysqli.php
    - ... taxonomy files ...
    - library/core/hook.php
    - ROOT_DIR/config.php
    - THEME_DIR/config.php
    - etc/db.php for connection database
    - THEME_DIR/functions.php
    - live_reload()
    - setUserAsLogin(getProfileFromCookieSessionId());
  - routes/index.php for API call.
    - exit
  - theme/theme-name/index.php
    - inject Javascript & styles at the bottom




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


### Creating or Updating an Entity

- Example of creating or updating an entity.

```php
$obj = token()->findOne([TOKEN => '...token...', TOPIC => '..topic...']);
if ( $obj->exists ) {
    $obj->update( [ USER_IDX => login()->idx ] );
} else {
    $obj->create([
        USER_IDX => login()->idx,
        TOKEN => '...token...',
        TOPIC => '..topic...',
    ]);
}
```


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



# 새로운 사이트 만들기

- CenterX 로 새로운 사이트를 만들기 위해서는 아래와 같은 과정을 거치면 된다.


- 도메인을 dating.com 로 가정하고, /etc/hosts 에 IP 를 127.0.0.1 로 등록한다.
  - 참고로 원하는 도메인이 있으면 그걸 쓰면 되고, dating.com 이 없으면 가짜 도메인으로 등록한다.
  - 그리고 가능하면 SSL 도 같이 등록하면 좋다.

- 그리고 테마 폴더 이름을 dating 으로 가정한다.
  - themes/dating/index.php 를 생성한다.

- 먼저 dating.com 도메인을 Nginx 와 연결한다.

Nginx 설정 예제)
```text
# dating project
server {
    server_name  dating.com;
    listen       80;
    root /docker/home/centerx;
    index index.php;
    location / {
        try_files $uri $uri/ /index.php?$args;
    }
    location ~ \.php$ {
        fastcgi_pass   php:9000;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```

- 그리고 config.php 에서 dating.com 으로 접속하면 dating 테마를 사용하도록 한다.








# User

## User login and registration tag

- There is a special tag(HTTP params) for user login and register
  - When user just logged in, `mode=loggedIn` is attached as HTTP params.
  - When user has just registered, `mode=registered` is attached as HTTP params.

- These may be used for extra code like `push token updating`.
  
- One might do `push token updating` with Ajax login or register.
  But, there might be cases that Ajax will not work such as `login with Kakaotalk, Naver, Apple, Google, or Pass mobile login`

# 데이터베이스

- 새로운 readme.md 파일 참고


# Friendly URL


- Friendly URL 에 테마 스크립트 페이지 지정.
  https://domain.com/qna 와 같이 짧은 URL 을 지원 할 것.
  기본적으로 모든 category 는 최 상위 슬래시(/) 다음에 기록 할 수 있도록 한다.
  예) `addPage('abc')` 와 같이 하면 `https://domain.com/abc` 와 같이 접속을 할 수 있고, `themes/../abc.php` 가 로드 될 수 있도록 한다.
  게시판의 경우 기본적으로 지원을 한다. 예) `https://domain.com/qna` 와 같이 접속하면, `/?forum.post.list&categoryId=qna` 와 같도록 한다.
  그리고 이것은 각 테마에서 직접 코딩을 할 수 있도록 한다.

- The url for post view can be like `/?p=forum.post.view&postIdx=15778` where you can get `post.idx=123`.


# 회원 가입

* 아래의 코드에서 `p` 가 `user.register.submit` 인데, 이 뜻은 FORM 을 전송하면, FORM 의 값들을 `theme/theme-name/user/register.submit.php` 로 전송하겠다는 뜻이다.
  만약, `theme/theme-name/user/register.submit.php` 이 존재하지 않으면, `theme/default/user/register.submit.php` 가 실행이 된다.

```html
어서오세요, <?=login()->nicknameOrName?>
<hr>
<form>
    <input type="hidden" name="p" value="user.register.submit">
    <input type="email" name="email" value=""">
    <input type="text" name="password" value=""">
    <button type="submit">회원가입</button>
</form>
```

* 아래의 코드는 회원 가입 FORM 에서 email 과 password 를 입력 받아, 회원 가입을 한 후, 쿠키에 회원 로그인 정보를 저장한 다음, 홈으로 이동한다.
  참고로, 회원 가입 FORM 에 더 많은 값을 입력해도, register.submit.php 에서는 자동으로 저장된다.

```php
$user = user()->register(in());
if ( $user->hasError ) jsAlert($user->getError());
else {
    setLoginCookies($user->profile());
    jsGo('/');
}
```


## 회원 가입을 Javascript 로 XHR 호출을 통해서 하는 경우,

* 아래의 예제는 Vue.js 에서 FORM 전송을 받아 회원 가입 하는 것으로, 특히 주의 해야 할 것은 cookie 저장 domain 이다.
  이 domain 이 PHP 와 일치해야지 서로 호환이 된다.

```html
<script>
  mixins.push({
    data: {
      form: {
        email: '',
        password: '',
      }
    },
    methods: {
      onSubmitRegisterForm: function() {
        request('user.register', this.form, function(user) {
          Cookies.set('sessionId', user.sessionId, {
            expires: 365,
            path: '/',
            domain: '<?=COOKIE_DOMAIN?>'
          });
        }, alert);

      }
    }
  })
</script>
```

# Cookies

## Cookies between PHP and Javascript

- PHP and Javascript can share data. So, if the app sets sessionId with Javascript, then user is logged in PHP, also.

```javascript
setAppCookie('sessionId', '3330-9622d005fbba90d96ea1a967e142a5ce');
```

- One important thing to know is that, cookies must use same path and domain. So, you must use `setAppCookie()` and
  `removeAppCookie()` on both of PHP and Javascript to share (and delete) the cookie data.


# Sharing Code between PHP and Javascript

## Same functions that exist both on PHP and Javascript.

- `loggedIn()`
- `notLoggedIn()`
- `setAppCookie()`
- `removeAppCookie()`


## Similiar functions

- `login()->idx` in PHP is equal to `loginIdx()` in Javascript


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

## Widget samples

- visit `/?widget.samples` to see what kinds of widgets are available.

## 재 사용가능한 위젯 샘플, Making Re usable widgets

- 위젯을 만들어 놓고, 재 사용을 하지 못하는 경우가 많다.
  비슷한 위젯은 css style 디자인만 변경하거나 약간의 옵션 수정으로 재 사용하는 것이 중요한다,
  그렇게 하기 위해서, /?widget.samples 에 재 사용 가능한 위젯을 표시하도록 했다.

- 재 사용가능한 위젯을 만들기 위해서는

  - @size 태그에 icon, narrow 또는 wide 라고 표시해 놓고, 어디에 쓰면 좋을지 적절히 선택 할 수 있도록 한다.
    참고로, RWD 에 대항해서 위젯을 만들어야 한다.

    narrow 는 너비가 260px 이하의 비교적 좁은 사이즈
    wide 는 너비가 600px 이상의 넓은 사이즈를 말한다.
    /?widget.sample 에서 보여 줄 때, narrow 는 max-width: 260px 너비로 보여주고, wide 는 max-width: 600px 너비로 보여준다.

  - @dependency 에 종속되는 3rd party 라이브러리 지정
    Bootstrap 과 같은 외부 CSS 나 Javascript 를 사용해서는 안된다.
    만약, 사용한다면, @dependency bootstrap 4.6.x vue.js 2.x 와 같이 표시를 해야 한다.

  - @options 태그에 필요한 옵션 정보를 표시한다.

  - 모든 위젯은 옵션이 없이 호출되는 것을 대비해서, 임시 데이터 및 사진을 보여 줄 수 있도록 한다.
    이러한 임시 데이터는 위젯 폴더 내부에 보관해야 한다.

## 위젯 상속

- 위젯 상속이라기 보다는 기존에 존재하는 위젯을 변경하여 재 활용하기 위한 것이다.

- 예를 들어, 필고에서 처럼, 게시판 글 쓰기 위젯이 존재하는데, 그 위젯의 머리, 꼬리, 글자 등을 변경하여 회원 장터, 갤러리, 쪽지 등의 글 쓰기 페이지로 동일하게 사용하는 것이다.

- centerx 에서는 언어화 기능( `$translationCache` 에 바로 수정 )과 `hook` 기능을 통해서 한다.

예) post-edit-default.php 에서 입력 양식이 대충 아래와 같다. 이 때, 상단 제목이나 언어화를 아래의 예제와 같이 변경 할 수 있다.

```html
<form action="/" method="POST">
    <input type="hidden" name="p" value="forum.post.edit.submit">
    ...

    <?=hook()->run('post-edit-title') ?? "<h6>Category: {$category->id}</h6>" ?>
    <input placeholder="<?= ln('input_title') ?>" name="<?= TITLE ?>" value="<?= $post->v(TITLE) ?>">
```

예)
```html
translate('input_title', [
    'en' => 'Input message title.',
    'ko' => '쪽지 제목을 입력하세요.',
]);
translate('input_content', [
    'en' => 'Input message content.',
    'ko' => '쪽지 내용을 입력하세요.',
]);

hook()->add('post-edit-title', function() {
    return '쪽지 전송';
});
include widget('post-edit/post-edit-default');
```

# Debugging

- debug log file is saved under `var/log/debug.log`.

- You can enable debugging by calling `enableDebugging()` and disable debugging by calling `disableDebugging()`.



# Post Crud

- To view or link to post list page, use `/?p=forum.post.list&categoryId=...` format.
- To view or link to create or update page,
  - use `/?p=forum.post.edit&categoryId=...` for creation
  - use `/?p=forum.post.edit&idx=...` for update.

- After filling up on post create/update form, send the form to `/?p=forum.post.edit.submit` and it will redirect to the list page.



## 글 작성, Post Edit



### 글 작성 위젯 옵션

- 글 작성 위젯 옵션에는 PHP INI 형식의 데이터를 입력하면 된다. 그리고 각 위젯에서 적절히 활용하면 된다.

#### 글 작성 위젯 옵션 활용 - 이벤트 게시판 등

Post Edit Widget 중에서 코드 별 사진 업로드(post-edit-upload-by-code.php)가 있다.

이 위젯은, 글의 제목과 내용을 업로드 할 수 있으며, 첨부 파일/사진을 코드 별로 업로드 할 수 있다. 즉, 임의의 사진을 무한정 업로드 할 수 없고, 정해진 코드 몇
개에만 업로드 가능하다.

글 읽기는 적절한 위젯을 만들어 사용하면 된다.

예를 들어, 이벤트 게시판을 작성한다고 가정 할 때,

이벤트 배너를 목록에 보여주고, 이벤트 내용을 사진으로 보여주고자 할 때,

사진 2개만 입력 받을 수 있다.

이 때, 아래와 같이 입력을 하면 된다.

```ini
[upload-by-code]
banner[label]=배너 사진
banner[tip]=목록에 나타나는 이벤트 배너(광고) 사진을 업로드 해 주세요.
content[label]=내용 사진
content[tip]=배너 사진을 클릭 했을 때 나타나는 내용 사진을 업로드 해 주세요.
```

위와 같이 하면, 목록에서 배너 사진을 보여주고, 내용에 내용 사진을 보여주면 된다.

첨부 파일의 코드에 'banner' 또는 'content' 가 들어간다.

만약, 이벤트가 종료되었다면, 배너 사진에 문구를 종료됨으로 수정하고, 내용에도 종료되었다는 표시를 하면 된다.




# Firebase


- If you want to use Firebase, set `FIREBASE_SDK_ADMIN_KEY` with json string with `Firebase SDK Admin Key`.
  For example,
  
```php
define('FIREBASE_SDK_ADMIN_KEY', <<<EOJ
{
    apiKey: "AIzaSyDWiVaWIIrAsEP-eHq6bFBY09HLyHHQW2U",
    authDomain: "sonub-version-2020.firebaseapp.com",
    databaseURL: "https://sonub-version-2020.firebaseio.com",
    projectId: "sonub-version-2020",
    storageBucket: "sonub-version-2020.appspot.com",
    messagingSenderId: "446424199137",
    appId: "1:446424199137:web:f421c562ba0a35ac89aca0",
    measurementId: "G-F86L9641ZQ"
}
EOJ);
```

- Then, it will define `FIREBASE_BOOT_SCRIPTS` with
  - complete firebase javascript sdk,
  - and the code of **initializing the firebase app**,
  - and the code of push notification
    - installing service worker for push notification,
    - accquiring permissions from user,
    - saving tokens to backend,
    - registering token to topic,
    - handling background push notification,
  

- Then, in the `index.php` (of the root) will insert the `FIREBASE_BOOT_SCRIPTS` at the bottom of the HTML on all page.

- Note that `/etc/js/firebase/firebase.js` is loaded along with `FIREBASE_BOOT_SCRIPTS` to do the firebase push notification routine.

- Note, the firebase app will be initialized at the bottom of the HTML. Meaning, you cannot use it in the middle of the page.
- Note, you can access all the firebase service with the global `firebase` namespace.
  For instance, you can do `messaging = firebase.messaging();` only after the initialization.
  Or in the middle of the page, `later(function() { messaging = firebase.messaging(); })`
  @see https://firebase.google.com/docs/reference/js/firebase

## Firebase Javascript

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




# 이미지 썸네일

- 이미지 썸네일을 위한 여러 라이브러리들이 많이 있지만, 아주 깔끔한 것이 없다. 믿었던 phpThumb 마저 알 수 없는 문제로 이미지 출력이 올바로 안된다.
- 그래서 직접 만들어서 사용한다.


예제) PHP 에서 생성해서 출력

```php
$file = files()->getBy(); // 최근 파일 선택
$th = thumbnailUrl($file->idx, 80, 80); // 썸네일 URL 을 가져온다.
echo "<img src='$th'><br>"; // 썸네일 이미지 출력
echo "<img src='{$file->url}'><br>"; // 원본 이미지 출력
```

예제) img 태그나 Flutter 등에서 바로 출력하기

```html
<img src="https://main.philov.com/etc/thumbnail.php?idx=293&w=140&h=140">
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


- meta 에 int, string, double(float) 은 serialize/unserialize 하지 않는다.
  즉, SQL 쿼리를 할 때, 메타 값으로 비교 할 수 있다.


# 파일 업로드

- test 파일에 HTTP FORM POST 값 전송이 아닌 CLI 로 파일을 업로드하고, 글에 추가하는 예제 코드가 있다.
- 파일 테이블 참고





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

## 자바스크립트에서 언어화

- Inline Javascript 를 사용하는 경우, 그냥 PHP 코드로 `<?=ln('list')?>` 와 같이 사용을 하면 된다.
  Vue.js component 를 사용 할 때, component property 에 `<?=ln('...')?>` 와 같이 넘겨주면 된다.
  
- 만약, PHP 로 넘겨 주기를 원하지 않을 때, 또는 자바스크립트로 `translatoin.get` 라우트로 특정 텍스를 가져오면 된다.
  참고, translation api


## In-page Translation

- When admin wants to translate text on the page,
  - Admin can click 'translate' button on the menu,
  - Then, the app will display edit button on each text(or highlight the text to be clicked) to translate the text.
  - Then, Admin can move over the text,
    - then pop-up appears,
    - admin can input texts based on supported languages.
    - when save, the value on the input boxes will be saved as translated.
  - Admin can change his language on the pop-up.

- See `widgets/login/login.php` and `library/core/language.php`.

- 아래와 같이 하면, 관리자가 홈페이지에서 바로 번역이 가능하다.

```html
<?=ln('name')?>
```

# 자바스크립트 - common.js

- common.js 에는 cookie, axios, 그 외 꼭 필요한 공용 함수들을 모아 놓았다.

- 회원 정보 관련 함수 `sessionId()`, `loggedIn()`, `notLoggedIn()`, `loginIdx()` 등이 있으며,

- 쿠키 관련 `setAppCookie()`, `removeAppCookie()` 가 있다.

- HTML FORM 을 serializing 하는 `serializeJSON()` 가 있으며,

- 백엔드로 ajax 호출을 하는 `request()` 가 있고,

- 파일을 업로드하는 `fileUpload()` 함수가 있다.

- 파일을 업로드해 했을 때, `wc_posts.files` 속성에 파일 번호를 콤마로 구분해서 넣어야 하는데, `addByComma()` 와 `deleteByComma()` 가 있다.

- 그리고 FCM 에서 message token 을 서버로 저장하기 위한 `saveToken()` 가 있다.


# Change language

- Make the language selection box like below.

```html
<form class="m-0 p-0" action="/">
    <input type="hidden" name="p" value="user.language.submit">
    <label class="m-0 p-2">
        <select name="language" onchange="submit()">
            <option value="">언어선택</option>
            <option value="ko">한국어</option>
            <option value="en">English</option>
        </select>
    </label>
</form>
```

- And `themes/default/user/language.submit.php` will save the user's choice into cookie.




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

## app.js

- `app.js` 는 Vue.js instance 를 생성하고 관리하는 자바스크립트이다. 기본적으로 `/etc/js/app.js` 에 있는 것을 사용해도 되고, 복잡한 로직이
  필요하다면, `/etc/js/app.js` 의 것을 각 theme folder 로 복사해서 사용하면 된다.
  참고로, 웹 사이트에서 사용되는 모든 로직을 이 `app.js` 에 넣어도 되고, 필요한 Vue component 도 같이 넣어도 되고, 따로 분리해서 사용해도 된다.

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
<?php js(HOME_URL . 'etc/js/common.js', 7)?>
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js', 9)?>
<?php js(HOME_URL . 'themes/sonub/js/bootstrap-vue-2.21.2.min.js', 10)?>
<?php js(HOME_URL . 'etc/js/common.js', 10)?>
<?php js(HOME_URL . 'etc/js/common.js', 10)?>
<?php js(HOME_URL . 'etc/js/common.js', 10)?>
<?php js(HOME_URL . 'etc/js/common.js', 10)?>
<?php js(HOME_URL . 'etc/js/app.js', 0)?>
```

# HTTP 입력 값 조정

웹 브라우저가 서버로 `/?a.b.c` 와 같이 접속하면 **테마에서** 특정 페이지를 로드 할 때, `theme()->pageName()` 과 `theme()->file()` 의
조합으로 어떤 페이지를 로드할 지 결정을 한다.

하지만, 웹 브라우저의 접속 경로가 `/?a.b.submit&a=apple&b=banana` 와 같이 `.submit` 으로 들어오면 테마 자체가 로드되지 않아야 한다.
즉, 그 경로의 판단을 테마가 로드되기 전에 해야 한다.

그래서, boot.php 에서 HTTP 입력 값 조정을 한다.

## .submit 을 p 변수로 변환

주의, [PHP 공식 문서: Dot 이 Underscore 로 변경](https://www.php.net/variables.external)됨에 따라
`/?a.b.submit` 이 PHP 로 전달될 때, HTTP 변수로 인식되어 PHP 의 $_REQUEST 에 `$_REQUEST['a_b_submit']` 로 저장되고 값은 없으므로 빈 값이
저장된다.

즉, `/?a.b.submit&a=apple&b=banana` 와 같이 접속하면  아래와 같이 $_REQUEST 에 저장되는 것이다.

```text
Array
(
    [a_b_submit] => 
    [a] => apple
    [b] => banana
)
```

이 점을 활용하여, $_REQUEST 의 key 중에 _submit 으로 끝나는 것이 있으면, 테마를 표시하지 않고, 오직, PHP 를 통해 값을 저장하는 것으로 인식하여,
index.php 에서 테마를 로드하지 않고, PHP 스크립트에서만 처리를 한다.

이러한 작업은 `adjust_http_input()` 에서 하며 (이 뿐만 아니라 여러가지 다른 작업이 있을 수 있다.), 그 결과로

`/?a.b.submit&a=apple&b=banana` 와 같이 접속을 하면 아래와 같이 `.submit` 의 값이 `p` 변수에 저장된다.

```text
Array
(
    [a] => apple
    [b] => banana
    [p] => a.b.submit
)
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
<?php js(HOME_URL . 'etc/js/common.js')?>
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js')?>
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
<?php js(HOME_URL . 'etc/js/vue.2.6.12.min.js', 2)?>
<?php js(HOME_URL . 'etc/js/bootstrap-vue-2.21.2.min.js', 1)?>
```

# 아이콘, SVG

- 3rd party dependency 를 최대한 줄기이기 위해서, 직접 SVG 를 포함해서 사용한다.
  - 요약 문서 참고: [SVG 아이콘 사용법](https://docs.google.com/document/d/1VgfgtExjiaFXrc-Sl15WOiL1cPlsWDRGdq9CTpaqiIg/edit#heading=h.a4ruqalgejpr)
  



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

- `return_url`
  글/코멘트 쓰기에서 FORM hidden 으로 `<input type="hidden" name="return_url" value="view">` 와 같이 하면, 글/코멘트 작성 후 글(루트 글) 읽기 페이지로 돌아온다.
  `return_url` 에는 `view`, `list` 그리고 `edit` 중에 하나를 쓸 수 있으며, 이 외에는 직접 값을 입력 할 수 있다.
  `view` 는 글 읽기 페이지로 이동한다.

예제) 먼저 훅을 추가하고
```html
<?php
hook()->add(HOOK_POST_EDIT_RETURN_URL, function() {
    return 'list';
});
?>
```

예제) 아래와 같이 쓰면 된다.
```html
<form action="/" method="POST" <?=hook()->run(HOOK_POST_EDIT_FORM_ATTR)?>>
    <?php
    echo hiddens(
        p: 'forum.post.edit.submit',
        return_url: hook()->run(HOOK_POST_EDIT_RETURN_URL) ?? 'view',
        kvs: $hidden_data,
    );
    ?>
```

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





# 파이어베이스

## Firestore 퍼미션

```txt
    /// Notifications
    match /notifications/{docId} {
      allow read: if true;
      allow write: if true;
    }
```


# Markdown

```php
<?php
$md = file_get_contents(theme()->folder . 'README.md');
include_once ROOT_DIR . 'etc/markdown/markdown.php';
echo Markdown::render ($md);
?>
```

# Unit Testing

- @see new readme file

# 사진업로드, 파일업로드

- 사진/파일 업로드, 특히, 코멘트에서 사진/파일 업로드가 쉽지 않다. 그래서 재 사용 가능한 코드를 만들어 활용한다.
- 파일 업로드를 할 때, Vue 를 사용 할 수 있고, 그냥 Vanilla Javascript 를 사용 할 수 있다.


## Vue.js 2 로 만든 가장 좋은 코드 (중요)

### 글 작성시 사진 업로드 - post-edit-form-file 믹스인

- 글 작성/수정 시, 사진/파일 업로드/삭제를 쉽게 해 놓은 mixin 이다.
- 모든 글 또는 wc_posts 테이블을 사용하는 글에 사용가능하다.
- 예제는 post-edit-default.php 를 참고한다.

### 코멘트 컴포넌트 - comment-form 컴포넌트

- SEO 를 위해서 코멘트를 보여 줄 때에는 PHP 로 표시하지만, 새 코멘트 작성, 수정 등을 할 때에는 컴포넌트로 처리하면 된다.
- 예제는 post-view-default.php 를 보면 된다.


### 사진을 업로드하는 - upload-image 컴포넌트

- taxonomy, entity, code 로 업로드를 하면 이미 존재하는 동일한 taxonomy, entity, code 의 값이 있으면, 기존의 파일을 삭제한다.
  즉, 하나의 사진만 유지하고자 할 때 사용 할 수 있다.
  
  
- 예제 코드) 스타일을 통해서 디자인 변경이 가능하다.

```html
<upload-image taxonomy="<?=cafe()->taxonomy?>" entity="<?=cafe()->idx?>" code="logo"></upload-image>
<style>
  .uploaded-image img {
    width: 100%;
  }
  .upload-button {
    margin-top: .5em;
  }
</style>
<?php js('/etc/js/vue-js-components/upload-image.js')?>
```
  
### 글에 코드 별로 사진을 업로드 - upload-by-code 컴포넌트

- 예를 들어, 쇼핑몰 글을 등록 할 때, 각 종 위젯이나 목록에 보여 줄 사진을 따로 업로드하고, 설명 사진을 따로 업로드하고, 본문 사진을 따로 관리하고 싶을 때 사용한다.
- 실전 코드는 `widget/shopping-mal/admin-shopping-mall/edit.php` 에 있으며, 아래와 같이 사용 가능하다.

```html
<upload-by-code post-idx="<?=$post->idx?>" code="primaryPhoto" label="대표 사진" tip="상품 페이지 맨 위에 나오는 사진"></upload-by-code>
```

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
        <input type="hidden" name="return_url" value="view">
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
        <input type="hidden" name="return_url" value="view">
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



# 카페

- 새로운 readme 참고


# PWA


## Service worker

The goal of service worker registration is NOT to do the service worker cache, but to do app banner installation.

- How to install service worker

```html
<script>
    // Check that service workers are supported
    if ('serviceWorker' in navigator) {
        // Use the window load event to keep the page load performant
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/themes/sonub/js/service-worker.js.php', {
                scope: '/'
            });
        });
    }
</script>
```

- Service worker script
```html
<?php
header('Service-Worker-Allowed: /');
header('Content-Type: application/javascript');
?>
console.log('hi, this is service worker');
```

## start_url



# Geo IP, GeoLite2

- `get_current_country()` 함수로 현재 국가 와 도시 정보까지 가져올 수 있으며, 각 종 국가 코드(두자리, 세자리, 환율 코드, 심볼 등)를 가져올 수 있다.
  - 참고로, 매 접속 마다, 이 함수가 실행 될 수 있으며, performance 에 영향을 줄 수 있다.
  - 가장 좋은 방법은 SPA 또는 Javascript 를 통해서, 처음 접속시 한번만 실행하는 것이다.
  - 또는 동일한 IP 로 접속하면 캐시를 해서 쓰는 것이다.



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






# 언어화, Translation, 번역

- `etc/translations.php` 에서 PHP 단에서 기본적으로 번역을 해서 제공 할 수 있다. 이렇게 하면 관리자 페이지의 언어화 설정에서 추가되지 않은 언어를
  기본 값으로 지정 할 수 있다.
  `etc/translations.php` 에 지정된 동일한 코드를 관리자 설정에서 지정하면 관리자 설정에서 지정된 값이 사용된다.

- 프로그램적으로 강제 변경을 하기 위해서는 `$translationCache` 변수에 지정을 하면 된다.
  - `etc/translations.php` 에는 `$translations` 변수가 있지만 이 값들은 관리자 설정에 의해서 덮어 쓰여질 수 있다.
  - 하지만, `translation.taxonomy.php` 에 있는 `$translationCache` 변수는 관리자 설정에 덮어 쓰여지지 않는다.
    그래서 이 변수에 값을 지정하면, 그 이후 사용되는 언어 코드에 대해서 강제로 값을 지정 할 수 있다.

  - 즉, 우선 순위는
    - `$translationCache` 이 가장 우선이고, 그 다음
    - 관리자 페이지에서 설정하는 DB 설정 값, 그 다음
    - `$translations` 이다.

## 테마별 언어화

- 테마에서만 쓰이는 언어인 경우, `theme.defines.php` 에 아래와 같이 아래와 같이 추가를 하면 된다.

```php
global $translations;
$translations = array_merge($translations, [
    'cafe_admin' => [
        'en' => 'Cafe Admin',
        'ko' => '카페 관리자'
    ]
]);
```

# Vue.js 2 Mixins

- 파일 업로드, 게시글 쓰기 등에서 공용으로 사용되는 mixin 을 작성해서 재 활용한다.

- mixins 폴더는 `etc/js/vue-js-mixins` 에 있다.

## 글 및 posts taxonomy 관련 레코드 작성(수정)시 첨부 파일

- 첨부 파일 등록, 수정, 삭제를 할 때, 매번 Javascript 를 따로 작성할 필요 없이, 공용 mixin 을 쓰면 된다.
  참고 widgets/post-edit/post-edit-default/post-edit-default.php 위젯 참고


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


# Default Javascript

- Javascript codes that are used by the system will be automatically included at the bottom for all themes.
  - cookie domain
  - firebase initialization
  - and more.
  You can see it by viewing the source code.


# 글을 관련 로직, 최근 글 가져오는 로직 등

- 글(또는 최근 글)을 가져오는 경우, 카테고리에 구분 없이 글을 가져오는 경우가 있다.
  이 경우 message 게시판에서는 글을 가져오지 않거나 글이 private 인 것은 가져오지 않아야 한다.
  어차피 private 인 경우에는 글 제목, 내용이 안보이겠지만, 사진이 보일 수 있다.
  그래서 주의 해야 한다.


# 위젯

## 글 목록 위젯

### post-list-top.php

- You can include a php script before post list header widget by putting a script named `[xxx].top.php` where `[xxx]` is
  the folder name.
  For instance, you can put `post-list-all-in-one.top.php` under `widgets/post-list/post-list-all-in-one` folder, and
  `post-list-all-in-one.top.php` will be included before 'post list header' widget.
  Remember, it is simply included as a php script not as a widget.
  With this script, you can do something to apply the whole post list widget. For instance, you can hook post list
  header widget.
  
- Important to note that all hooks and javascript mixins should be defined in `[xxx].hooks-mixins.php` that is included
  by `[xxx].top.php` to avoid confusions.


### 글 목록 상단 위젯

- 쪽지 게시판 등에서는 게시판 상단 목록이 필요 없을 수 있다. 이 때에는 empty widget 을 선택하면 된다.

- 글 목록 위젯에서 All in one 의 경우, 목록 위젯에서 글 목록, 읽기, 쓰기를 모두 다 한다. 즉, 글 읽기, 쓰기 위젯을 따로 설정 안해도 되며, 해도 적용이 안된다.

## 글 쓰기 위젯

### 글 쓰기 위젯에 들어가는 요소

- FORM 에 `HOOK_POST_EDIT_FORM_ATTR` 훅을 실행한다.
  이것은 자식 위젯(상속해서 쓰는 위젯)에서 FORM 동작 방식을 변경해서, 활용하기 위한 것이다. 예를 들면 post-edit-ajax.php 가 post-edit-default.php
  를 상속해서, 글 쓰기만 ajax 로 한다.
  
- Vue.js 에 `loading` 속성 추가
  이 것은 상속한 위젯에서 ajax 로 글을 쓸 때, 백엔드로 연결 중에 전송 표시를 하기 위해서이다. 

```html
<div v-if="!loading">
  <button class="btn btn-warning mr-3" type="button" onclick="history.go(-1)"><?=ln('cancel')?></button>
  <button class="btn btn-success" type="submit"><?=ln('submit')?></button>
</div>
<div class="d-none" :class="{'d-block': loading }">
  전송중입니다.
</div>
<script>
    mixins.push({
        data: {
            loading: false,
            files: '<?= $post->v('files') ?>',
            percent: 0,
            uploadedFiles: <?= json_encode($post->files(true), true) ?>,
        }
    });
</script>
```

## 코멘트 위젯

- 코멘트 쓰기는 Vue.js 컴포넌트로 한다. (참고. 글/코멘트 내용 출력은 SEO 를 위해서 PHP 로 해야한다.)
- 아래의 예제에서, `text-photo` 값을 지정하지 않으면, 자동으로 카메라 아이콘이 표시된다.

```html
<comment-form root-idx="<?= $post->idx ?>"
              parent-idx='<?= $comment->idx ?>'
              text-photo="<?=ln('photo')?>"
              text-submit="<?=ln('submit')?>"
              text-cancel="<?=ln('cancel')?>"
              v-if="displayCommentForm[<?= $comment->idx ?>] === 'reply'"
></comment-form>
```
### Ajax 로 글 전송 위젯, post-edit-ajax.php

- 글을 저장할 때, PHP 로 다음 페이지로 넘겨서 처리를 하는 것이 아니라, Vue.js 로 입력 값을 점검 한 후, Axios 로 글을 생성한다.

- `post-default-ajax.php` 위젯이 그 예제이며, `post-edit-default.php` 를 상속해서 쓴다.


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



# PhpStorm Settings

- PhpStorm requires 'ext-mysqli' extension in composer.json for better inspection. As soon as adding it to `composer.json` (without installation), it works.

```
"ext-mysqli": "*"
```


# CSS, 공용 CSS


## x.scss, x.css

- x.scss 를 컴파일하여 x.css 로 쓴다. 따라서 x.css 파일을 수정하면 안된다.

- etc/css/x.css 는 공용 CSS 이며, 많은 곳에서 쓰인다. 특히, vue-js-components 나 각종 widget 에서 기본적으로 사용하는 것이다.
  또한 이 것을 커스터마이징하여 다른 색, 모양을 만들어 낼 수 있다.
  

  
## progress bar

- x.css 를 참고한다.


# Error code

- 에러 관련 루틴은 library
- 에러 코드는 문자열이며 처음 시작이 반드시 소문자 'error_' 이어야 한다.
- 에러에 관한 추가 정보는 ' - ' 로 분리하여 추가 할 수 있다.
  예) error_login_first - user did not logged in.


# 문제 해결

## 웹 브라우저로 접속이 매우 느린 경우

live reload 를 위한 socket.io.js 를 로드하는데 이것이 pending 상태로되어져 있는지 확인한다.

socket.io.js 를 로드하지 않던지, 또는 pending 아닌 failed 로 되어야 한다. 그렇지 않고 pending 상태이면, 웹 브라우저에서 매우 느리게 접속 될 수 있다.


## GET socket.io.js net::ERR_EMPTY_RESPONSE

Live reload 코드가 실행되는데, socket.io.js 를 로드하지 못해서 발생한 에러.

config.php 에서 LIVE_RELOAD_HOST 에 빈 문자열 값을 주어, live reload 를 turn off 할 수 있다.


## error_entity_not_found on CountryTaxonomy

Be sure you have the countries table records into the wc_countries table.



## Firebase - Invalid service account

- When you use firebase admin sdk, you must put the proper firebase admin sdk.
  
- One thing to note is that, On test mode, the `Firebase Admin Sdk Json Key` must be put in the root `config.php`
  Not in the theme `config.php`.

- Error message examples

```text
Next Kreait\Firebase\Exception\InvalidArgumentException: Invalid service account: /docker/home/centerx/etc/keys/xxx-firebase-admin-sdk.json can not be read: SplFileObject::__construct(/docker/home/centerx/etc/keys/xxx-firebase-admin-sdk.json): ...
```

```text
PHP Warning:  openssl_sign(): Supplied key param cannot be coerced into a private key in /docker/home/centerx/vendor/firebase/php-jwt/src/JWT.php on line 209
Warning: openssl_sign(): Supplied key param cannot be coerced into a private key in /docker/home/centerx/vendor/firebase/php-jwt/src/JWT.php on line 209

d(): Array
(
[topic1621427903] => OpenSSL unable to sign data
)
```

## 대 용량 사진/파일 업로드

- 에러 로그에 file size 또는 content-length exceeds 에러가 나면, 서버에서 설정한 용량 보다 큰 파일을 업로드해서 그렇다.
  아래와 같이 해결한다.

에러 메시지)
NOTICE: PHP message: PHP Warning:  POST Content-Length of 81320805 bytes exceeds the limit of 67108864 bytes in Unknown on line 0


해결책)
```text

php.ini)
upload_max_filesize = 1000M;
post_max_size = 1000M;


nginx.conf)
client_max_body_size    500M;
```


# 광고 기능

- 새로운 readme.md 참고


# 팁, 트릭

- 검색 후, 목록에서 글 보기 위해서 글 클릭하면, 새창을 띄워서 글 보여주기.
  - HOOK_POST_LIST_TITLE_ATTR 훅을 사용해서, searchKey 에 값이 있으면, target=_blank 를 출력하면 된다.


# Known Issues

## 404 error on push token renew

- This error is only displayed on developer console and this happens when the app tries to delete previously generated
  token. Which means, for the very first time, there is no 'previously generated token', so no token to delete and no
  error. It happens when the app renews the token.

  - see https://docs.google.com/document/d/1Hr7rMaiZiTcuk7SsTAGzYGQZuSIwiNx7OIJq_div-RY/edit#heading=h.op2ktluqo2x2
