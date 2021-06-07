# CenterX

- CenterX 는 웹사이트 개발 및 Restful Api 를 통해서 Mobile App 의 백엔드로 개발 할 있도록 하는 프레임워크이다.
- CenterX 를 직접 개발한 이유는
  - PHP 버전 8 으로 업데이트 될 때, 새로운 기능을 사용하고 싶었는데, 기존의 프레임워크들이 즉각적인 지원을 하지 않았다.
  - 직관적이며, 간단한 프레임워크를 통해 팀원 및 다른 개발자들이 쉽게 사용 할 수 있도록 하기 위해서이다.
    
## 개발 환경

- 2021년 5월, 대한민국의 데스크톱 컴퓨터에서 IE11 의 점유율이 10%가 넘는다. 그래서 IE11 의 지원은 필수이며 최소한, 앞으로 5년간 필수 지원을 해야 한다.
  참고로, IE10 이하는 거의 사용되지 않아 무시한다.
  - 이러한 이유로, Vue.js 2.x 와 Bootstrap 5.x 를 사용한다.
  
- Native SEO 를 지원하기 위해서 PHP 를 사용한다.
  - SPA 의 경우 SSR 을 통해서 SEO 지원이 가능하다. 예) Angular Universal, React Next.js, Vue Nuxt.js, SvelteKit 등이 SSR 를 지원한다.
  하지만, Native 지원을 하지 못하므로 배포 전에 컴파일 과정을 거쳐야 하며, SSR 을 위한 별도의 서버를 운영해야한다.
  이러한 과정이 번거로우며, 특히 약간의 수정을 해도 컴파일하고 배포해야 하며, 혹시라도 다른 개발자가 이어서 개발을 해 나갈 때 개발 환경 설정이 만만치 않을 수 있다.
  - 즉, SSR 을 하되 컴파일을 하지 않는 것을 중요하게 생각하고 있으며, 그래서 PHP Native SEO 를 한다.
    - PHP 는 HTML 을 그대로 웹 브라우저에 표현을 할 수 있다. (Vue.js 와 같은 자바스크립트를 같이 사용하여 UX 를 높일 수 있다.)


- 개발은 Docker Container 를 통해서 하며, 실제 서버에서도 Docker Container 를 이용해도 무방하다.




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

- pass login 재 정리

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

# 설치와 기본 설정

본 문서에서는 우분투 서버에서 도커를 통해 centerx 설치하는 방벙에 대해 설명한다.

코어 개발자들이 개발 작업을 할 때에는 우분투 서버에서 작업을 하는 것이 아니라 윈도우즈, 맥, CentOS 등 여러 시스템에서 도커를 설치하고 테스트 개발을 한다.
즉, 우분투 뿐만아니라 도커가 실행되는 환경이면 centerx 가 잘 운영된다.
다만, 실제 서비스를 할 때에는 우분투 서버(또는 CentoOS 서버)를 추천한다.
도커를 사용하지 않고 직접 Nginx(Apache), PHP, MariaDB(MySQL)을 설치하여 CenterX 를 운영 할 수 있다.

## 설치 요약

- 먼저 도커를 설치하고 실행한다.\
  [우분투 도커 설치 참고](https://docs.docker.com/engine/install/ubuntu/)


- 도커는 compose 를 통해서 실행하는데, 그 설정이 github 에 있다. 아래와 같이 Docker compose 설정을 GitHub 에서 다운로드 또는 clone(또는 fork)
  한다.
  그리고 루트 계정으로 `/docker` 에 설치를 한다.

  - `git clone https://github.com/thruthesky/docker /docker`

- 그리고 docker-compose.yml 에서 MYSQL_PASSWORD 와 MYSQL_ROOT_PASSWORD 를 적절한 비밀번호로 변경한다.
  - `cd /docker`
  - `vi docker-compose.yml`

- Nginx 서버 설정은 `/docker/etc/nginx/nginx.conf` 이며, 기본 홈페이지 경로는 `/docker/home/default` 이다.

- 그리고 아래와 같이 docker compose 를 실행한다.
  - `docker-compose up -d`

- 그리고 `centerx` 를 `/docker/home` 폴더 아래에 fork 후 clone 한다.
  참고, 도커 실행을 위한 docker-compose 설정은 루트 계정으로 `/docker` 폴더에 하지만, centerx 설치와 centerx 관련 작업은 사용자 계정으로 하는 것이
  좋다.
  참고로,
  - `/docker` repo 의 .gitignore 에 `home` 폴더가 들어가 있어서
  - `/docker/home` 폴더 아래에 `centerx` repo 를 추가해도,
  - `/docker` repo 에 추가되지 않는다.

- 루트로 사용자 계정을 만든다.
  - `# useradd -m -d /docker/home/centerx centerx` 와 같이 하면 사용자 계정 `centerx` 의 홈 폴더가 `/docker/home/centerx` 가 된다.
  - `# su - centerx`
    - `$ git init`
    - `$ git remote add origin https://github.com/thruthesky/centerx`
    - `$ git fetch`
    - `$ git checkout main`
    - `$ chmod -R 777 files`
    - `$ chmod -R 777 var/logs`

- phpMyAdmin 을 통한 데이터베이스 테이블 설치
  웹 브라우저로 phpMyAdmin 에 접속을 해서 SQL 스키마를 DB 에 넣는다.
  - `/docker/home/default/etc/phpMyAdmin` 에 phpMyAdmin 이 설치되어져 있다.
    접속은 IP 주소를 이용하여, `http://1.2.3.4/etc/phpMyAdmin/index.php` 와 같이 접속하면 된다.
    데이터베이스 관리자 아이디는 root 이며, 비밀번호는 위에서 변경 한 것을 입력한다.
    참고로 기본 비밀번호는 Wc~Cx7 인데 꼭 변경해서 사용하기 바란다.

  - phpMyAdmin 접속 후, `centerx/etc/install/sql` 폴더에서 최신 sql 파일의 내용을 phpMyAdmin 에 입력하고 쿼리 실행을 한다.
    - 만약, 국가 정보를 원한다면, `wc_countries` 테이블을 삭제하고, `/centerx/etc/install/sql/countries.sql`

  - 참고, phpMyAdmin 에서 root 와 사용자 계정 password 를 변경 할 수 있으며, 변경한 비밀번호를 `etc/keys/db.config.php` 파일에 저장하면 된다.

- node modules 들을 설치한다.
  참고로 개발을 위해서만 npm install 을 하면 된다. 배포 서버에서는 할 필요 없다.
  - `npm i`

- `keys` 폴더에 각종 키를 설정한다.
  - Firebase 접속을 위한 Admin SDK Account Key 를 설정.

- `config.php` 에 각종 api key 를 설정한다.
  - Firebase 접속을 위한 Web access key 를 설정.
  - 카카오 로그인 설정.
  - 네이버 로그인 설정.
  - 날씨 Api 설정
  - 환율 Api 설정
    등 원하는 것만 설정하면 된다.

- 만약, 다른 도메인으로 다른 홈페이지를 추가 개발을 하고 싶다면, `/docker/etc/nginx.conf` 를 수정하여, 홈 경로를 `/docker/home` 폴더 아래로 하면 된다.




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


## Live reload

아래의 live reload 항목 참고


# Versioning

- 버전 체계. Semver 로 한다.
- 브레이킹체인지/메이저.마이너.패치




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







# Admin

## How to set admin to manage the site.

- Root admin, who has the full power, can be set to ADMIN_EMAIL constant in `config.php`.
  After setting the email in config.php, you may regsiter(or login) with the email.


```php
config()->set('admin', 'thruthesky@gmail.com');
d(config()->get('admin'));
```

## Admin Settings

### Custom Settings

Admin can set custom settings that apply to the web/app, but it needs extra work to do.
For instance, `Site name` setting is a setting that is supported by the system.
But when admin adds custom settings, that is not supported.
You may add `loginOnWeb` option to tell the web to show login option to user, but the system does not support it. So,
the developer must work on it.

Another setting that may often be used is app download setting. Admin may put `androidLatestVersion` in custom setting
with the latest android version, but the developer must code on the android app.



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

# 쪽지 기능, Message Functionality

- 쪽지 기능은 게시판과 매우 흡사하다. 그래서 게시판 테이블과 대부분의 게시판 기능을 사용한다. 단, post-edit-default 위젯을 상속하기에는 좀 복잡해서 직접
  위젯을 만들어 쓴다.
  - 참고, 글 쓰기: message-edit-default.php
  - 참고, 글 읽기: message-view-default.php
  - 참고, 글 목록: message-list-default.php


- 게시판 category.id 는 어떤 것이라도 상관없지만, 규칙을 두고, 각종 링크에서 공용으로 사용하기 위해서 MESSAGE_CATEGORY 에 게시판 카테고리를 정의한다.
  기본적으로 'message' 게시판을 사용한다.
  즉, 쪽지 목록 메뉴 링크를 걸 때, `<a href="<?=postListUrl(MESSAGE_CATEGORY)?>">쪽지</a>` 로 하면 된다.
  만약, 다른 게시판으로 하려면, MESSAGE_CATEGORY 를 다른 값으로 변경하면 된다.

- 주의 할 것은 게시판 목록, 읽기, 쓰기 위젯 등을 쪽지 위젯으로 설정을 해야 한다.
  기본적으로 post-list/message-list-default, post-view/message-view-default, post-edit/message-edit-default 가 존재한다.

  
- 글 목록, 페이지내에션, 검색 등에서 비슷하게 사용된다.
  다만, 외부에서 검색이 되지 않도록 100% 보장하기 위해서, title 과 content 필드 대신에 privateTitle, privateContent 에 기록을 한다.
  이 때, private 에 Y 의 값을 기록해야 한다.
  
- 글을 저장 할때, private = Y 옵션을 서버로 전송하면, 서버에서는 자동으로 title 과 content 값을 privateTitle 과 privateContent 에 기록한다.
- 단, 글을 읽을 때에는 private = Y 이면, privateTitle 과 privateContent 를 직접 화면에 표시해야 한다.

- otherUserIdx 에 받는 사람 정보가 들어간다.

- readAt 에 글을 읽은 시간이 들어간다.


## 쪽지 기능 사운드 알림

- 새로운 쪽지가 있으면, 소리를 낸다.
- 사용자가 on/off 할 수 있다.
- sound-on-off.php 위젯으로 사용이 가능한데, 중복으로 사용되어도 소리 파일은 중복으로 출력하지 않는다.
  sound-on-off.php 내부적으로 `new-message-sound-on-off` 컴포넌트를 사용하는데, 이 컴포넌트에서 사운드 on/off 를 한다.


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




# API Protocol

- API Protocol examples are written in `/etc/rest-client/rest-client.http`

- `route` is the route of the api call.
  Ex) `/?route=app.version`

- To get app version, access like below
  Ex) `/?route=app.version`

- To live reload on web browser, add `/?reload=true`. But you must remove it when you don't need live reload.


## Response

- 에러가 있는 경우, response 의 값은 'error_' 로 시작하는 값이다.
  예) `{ request: {email: ..., password: ...}, response: "error_email_exists"}`
- 또는 PHP 나 기타 에러가 있는 경우, 문자열의 값이 리턴 될 수 있다. 리턴 값의 data 에 에러 문자열이 들어갈 수 있다.
  예) `<xmp>Data too long for column 'gender' at row 1</xmp><xmp>INSERT...`
- 성공을 하면, 반드시 리턴되는 연관 배열의 'response' 에 값이 'error_' 가 아닌 값이 들어가 있다.
  예) `{ request: {email: ..., password: ...}, response: { idx: ... }`

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
  이 때, file upload 를 할 때, 두 가지 방법으로 할 수 있다.
  하나는 아래와 같이 taxonomy 와 entity 로 값을 삭제할 수 있으며,
  {
  deletePreviousUpload: Y
  taxonomy:
  entity:
  }

  또는 아래와 같이 하나는 code 만으로 기존 파일을 삭제 할 수 있다.
  이 때, code 만으로 기존 파일을 삭제하는 경우는 해당 파일이 로그인을 한 사용자의 파일이어야 한다.

  {
  deletePreviousUpload: Y
  code:
  }

  본 항목의 사용자 사진 참고
  Flutter Firelamp api.controller.dart 의 takeUploadFile() 과 uploadFile() 함수를 참고.


- To get a file
  Use `file.get` route
  Ex) https://main.philov.com/?route=file.get&taxonomy=posts&code=web&entity=14944
  
- To get all files of a post
  Use `file.byPostIdx` route

- To get a file of code of a post
  Use `file.byPostCode` route.

## Point Api

- 글(또는 코멘트)을 쓸 때, 얼마의 포인트를 획득했는지, 포인트 값을 알고 싶다면, 아래와 같이 호출한다.
  - `idx` 는 글 또는 코멘트 번호이다.
  - @todo 로그인한 사용자 자신의 레코드이어야 값을 가져올 수 있도록 수정해야 한다.

```
https://local.itsuda50.com/?route=point.postCreate&idx=15130
```


## Translation api

### 언어 코드 하나에 대한 번역된 글 가져오기

- `translation.get` 라우트에 `code` 값만 주면, 백엔드에서 사용자의 언어를 자동으로 찾아서 해당 코드의 번역 글을 리턴한다.
  리턴 속성
  ln: 사용자 언어 예) en, ko
  code: 요청한 코드
  text: 결과 문자열

- 특정 코드의 언어 번역 코드를 가져오려면, Javascript 로 아래와 같이 하면 된다.
```javascript
request('translation.get', {'code': 'list'}, console.log, alert);
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



# Currency Conversion

- centerx support currency api from https://free.currencyconverterapi.com/
- define free version currency api in config.php
```php
define('CURRCONV_API_KEY', 'bd6ed497a84496be7ee9');
```

# Weather

- the system support weather api from https://openweathermap.org/
- define open weather map api key in config.php
```php
define('OPENWEATHERMAP_API_KEY', '7cb555e44cdaac586538369ac275a33b');
```

- @see widget/openweathermap for example.



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



# Hook System

* 훅을 실행하고 싶은 곳에서 `hook()->run('name', 'vars')` 와 같이 하면 된다.
* 훅 함수들은 `hook()->add(function() {})` 와 같이 정의하면 된다.
* 훅에서 주의 할 점은,
  * 입력 파라메타와 리턴 값이 자유롭다는 것이다.
    * 입력 파라메타는 기본적으로 pass by reference 를 지원해서, 입력 파라메타의 값을 변경하여 상위 함수로 전달 할 수 있다.
    * 또한 리턴 값으로 전달 할 수도 있다. 즉, 상위 함수에서 리턴 값을 받아서 사용 할 수도 있다.
    * HOOK_POST_LIST_COUNTRY_CODE 예제 참고

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


* Hook 함수는 각 테마 별로 theme-name.functions.php 에서 정의하면 되고, hook 코드가 커지면 `[theme-name].hooks.php` 로 따로 모으면 된다.
* 동일한 hook 이름에 여러개 훅을 지정 할 수 있다.


* `posts_before_create` 훅 함수가 에러 문자열을 리턴하면 다른 훅은 모두 실행이 안되고, 글/코멘트 생성이 중지된다.

* 모든 훅 함수는 값을 리턴하거나 파라메타로 받은 레퍼런스 변수를 수정하는 것이 원칙이다.
  * 가능한, 어떤 값을 화면으로 출력하지 않도록 해야하지만,
  * 글 쓰기에서 권한이 없는 경우, 미리 체크를 해야하지만, 그렇지 못한 경우 훅에서 검사해서
    Javascript 로 goBack() 하고 exit 할 수 있다.
    이 처럼 꼭 필요한 경우에는 직접 HTML 출력을 한다.

* 훅의 목적은 가능한 기본 코드를 재 사용하되, 원하는 기능 또는 UI/UX 로 적용하기 위한 것이다.
  * 예를 들면, 게시판 목록의 기본 widget 을 사용하되, 사용자 화면에 보이거나, 알림 등의 재 활용 할 수 있도록 하는 것이다.


## 페이지나 위젯에서 Hook 을 실행 할 때, 리턴하는 값이 있으면 그 값을 사용하고 아니면, 기본 값을 사용


* 아래와 같이 실행 할 수 있다. 훅의 결과가 있으면 그 결과를 사용하고, 없으면 기본 HTML 을 사용하는 것이다.

예제 1) 기본적으로 `hook()->run()` 이 리턴하는 값이 없으면 null 이 리턴된다. 즉, 훅 함수가 없으면 null 이 리턴되는 것이다.

```html
<?=hook()->run('display-category-name') ?? "<h6>No category name</h6>" ?>
```

예제 2) 아래 처럼 풀어서 할 수 있다.
```html
<?php if ( $_ = hook()->run('post-meta-3rd-line', $post) ) echo $_; else { ?>
    No. <?= $post->idx ?>
<?php } ?>
```



## 훅에서 widget 을 포함하기

- 그냥 아래와 같이 훅에서 위젯을 출력해 버려도 된다.

```php
hook()->add(HOOK_POST_LIST_TOP, function() {
    include widget('banner/post-list-top');
});
```


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


* HOOK_POST_LIST_COUNTRY_CODE
  게시글을 추출 할 때(글 목록 또는 최근 글 가져오기), 강제로 특정 국가의 글만 목록하게 할 수 있다.
  이 훅은 글 목록이나, 공지사항 목록 등에서 사용 된다.
  
  입력 값: 기존 국가 코드.
  리턴 값: 새로운 국가 코드.
  
예제) hook `add` 에서 만약, countryCode 를 변경 할 필요가 없으면 그냥 리턴한다. 그리고 `run` 에서 사용을 한다.
```php
hook()->add(HOOK_POST_LIST_COUNTRY_CODE, function(&$countryCode) {
    if ( in(CATEGORY_ID) != MESSAGE_CATEGORY ) $countryCode = cafe()->countryCode;
    return $countryCode;
});

// 국가 코드 훅. @see README `HOOK_POST_LIST_COUNTRY_CODE` 참고
if ( $countryCode = hook()->run(HOOK_POST_LIST_COUNTRY_CODE, $in['countryCode']) ) {
    $where .= " AND countryCode=?";
    $params[] = $countryCode;
}
```

* HOOK_POST_EDIT_FORM_ATTR
  글 수정을 할 때에 HTML FORM 태그에 추가 할 속성을 리턴 할 수 있다.
  예를 들면 아래와 같이 hook 이 호출된다.
  
예) post-edit-default.php 위젯에서 아래와 같이 hook 을 실행한다.
```html
<form action="/" method="POST" <?=hook()->run(HOOK_POST_EDIT_FORM_ATTR)?>> ... </form>
```

예제) post-edit-ajax.php 에서 아래와 같이 hook 을 사용하여, 전송 버튼을 클릭하면 다음 페이지로 넘어가지 않고, Ajax 로 글을 작성한다.
```php
<?php
/**
 * @name Ajax post edit widget
 */

hook()->add(HOOK_POST_EDIT_FORM_ATTR, function() { return "@submit.prevent='onPostEditAjaxSubmit'"; });
include widget('post-edit/post-edit-default');
?>
<script>
    mixins.push({
        methods: {
            onPostEditAjaxSubmit: function() {
                console.log('ajax forum submit!');
            }
        }
    })
</script>
```

- HOOK_POST_EDIT_RETURN_URL - you can edit return url of the post edit form.

- HOOK_POST_LIST_ROW - 글 목록에서, 각 글의 사이에 출력한다.
  `$rowNo` 는 0 부터 시작하며 총 글 수 만 큼, 각 라인 사이에 원하는 내용을 출력 할 수 있다.
  `$rowNo` 가 0 이면, 첫 글 위에 출력하고, 맨 끝인지는 아래와 같이 할 수 있다.

```php
hook()->add(HOOK_POST_LIST_ROW, function(int $rowNo, array $posts) {
    if ( $rowNo == 3 ) {
        include widget('advertisement/banner', ['type' => AD_POST_LIST_SQUARE]);
        echo "<hr>";
    }
    if ( count($posts) == $rowNo ) {
        // This is the last line.
    }
});
```


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
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php"
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic."
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php controller"
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic.db."
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic.entity.search"
chokidar '**/*.php' -c "docker exec www_docker_php php /docker/home/centerx/tests/test.php basic.user_a"
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

# 원하지 않는 접속 차단

- etc/kill-wrong-routes.php 에서 한다.

# 캐시

- 캐시가 특정 시간보다 오래되었는지 또는 시간 경과했는지는 `cache('code')->olderThan(100)` 와 같이 하면 된다. 초단위이다.

- 캐시를 사용하는 예(로직)는 다음과 같다.

- 참고로, 캐시 데이터를 저장할 때, 배열 등이 있으면 searialize 를 해서 넣어야 한다.

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




# Forum & Post & Comment

## Post list parameters

- 게시판 목록에서 검색에 사용되는

- `categoryId` 는 글 카테고리. 카테고리 번호를 숫자로 입력해도 된다.

- `subcategory` is the subcategory.

- `countryCode`
  국가별 글 목록을 할 때 사용한다.
  국가 코드의 경우, hook 을 통해서 수정 할 수 있다.
  예를 들어, 특정 theme 에서는 무조건 특정 국가의 글만 목록하고자 할 때, 사용 할 수 있다. 예를 들면 소너브에서 도메인/카페 별로 특정 국가의 글만 목록하고자 할 때 사용한다.


- `nsub` 사용법.
  - 사용자가 전체 카테고리에서 글 생성할 때, 'abc' 카테고리를 선택한다면, 그 글은 'abc' 카테고리 글이다.
    '전체카테고리'와 'abc' 카테고리 중 어떤 카테고리를 보여주어야 할까?
    정답은 전체 카테고리이다.
    글 쓰기 FORM 을 열 때, HTTP PARAM 으로 subcategory 값이 전달되지 않은 경우, nsub=all 로 전송을 한다.

  - 사용자가 전체 카테고리 목록에서, 특정 글을 수정 할 때, 그 글의 카테고리가 'abc' 라면, 글 작성 후, 전체 카테고리를 보여줘야 할까? 'abc' 카테고리만
    보여줘야 할까?
    정답은 전체 카테고리이다.
    글 쓰기 FORM 을 열 때, HTTP PARAM 으로 subcategory 값이 전달되지 않은 경우, nsub=all 로 전송을 한다.

  - 사용자가 'abc' 카테고리에서 글을 생성하면, 'abc' 카테고리를 보여줘야 한다.

  - 사용자가 'abc' 카테고리에서 글을 하나 수정할 때, 그 글의 카테고리를 'def' 로 바꾸면, 'abc' 와 'def' 중 어떤 카테고리를 보여줘야 할까?
    정답은 def 카테고리이다.

  - 요약을 하면, `nsub` 는 글 생성, 수정, 삭제를 할 때, 그 직전의 페이지 목록이 서브카테고리가 아닌 경우, FORM 전송 후 전체 카테고리로 보여주기 위한 것이다.


- `searchKey` 검색어
  - searchKey 에 값이 들어오면, `(title LIKE '%searchKey%' OR content LIKE '%searchKey%')` 있으면 그 것을 검색한다.

- userIdx 는 사용자 번호
  - 그 사용자가 쓴 글을 검색한다.
    예) `https://local.itsuda50.com/?p=forum.post.list&categoryId=qna&userIdx=2&searchKey=hello`

- categoryId 는 글 카테고리 아이디(또는 번호)

- subcategory 는 검색을 할 서브 카테고리이다.



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



# Post list

- For listing posts under a category, it requires `category.idx`. Whether the client is using SQL or prepared params,
  `category.idx` must be used, instead of `category.id`.
  - Client app should load the forum configuration at startup and cache for the next boot. So, they can use `category.idx`.


# CSS, 공용 CSS


## x.scss, x.css

- x.scss 를 컴파일하여 x.css 로 쓴다. 따라서 x.css 파일을 수정하면 안된다.

- etc/css/x.css 는 공용 CSS 이며, 많은 곳에서 쓰인다. 특히, vue-js-components 나 각종 widget 에서 기본적으로 사용하는 것이다.
  또한 이 것을 커스터마이징하여 다른 색, 모양을 만들어 낼 수 있다.
  

  
## progress bar

- x.css 를 참고한다.



# Live Reload


- live reload works on Node.js version 10.23.0 and above.


- To use live reload, set `LIVE_RELOAD` to true and adjust the following settings.

## Live reload with http (without SSL)

- To use live reload on localhost without SSL.
  - set `http://localhost` to `LIVE_RELOAD_HOST`
  - set `12345` to `LIVE_RELOAD_PORT`.
  - add the working local domain to `LOCAL_HOSTS`.
  - run `node live-reload.js`.


## Live reload with https (with SSL)

- To use live reload with SSL,
  - place `tmp/ssl/live-reload/private.key` and `tmp/ssl/live-reload/cert-ca-bundle.crt` for SSL certificates.
  - set the host(domain) with scheme to `LIVE_RELOAD_HOST`.
    ex) `https://sonub.com`
    Not that, the certificates(and private key) must be for the domain.
  - set '12345' to `LIVE_RELOAD_PORT`
  - add the working local domain to `LOCAL_HOSTS`.
  - run `node live-reload.js https`
 
## Stop live reload for a run-time.

- If you want to stop live reload only for a script (or a page), define `STOP_LIVE_RELOAD` like below.
  
```html
<?php
header("Content-Type: application/javascript");
header("Cache-Control: max-age=604800, public");
const STOP_LIVE_RELOAD = true;
require_once '../../../boot.php';
?>
alert('Hi');
```

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
