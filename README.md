# CenterXgit stat

- 위세너에서 개발한 LEMP 기반 백엔드.
- 특징
  - 최신 PHP 버전(버전 8) 을 활용한 코드
  - OOP 를 활용한 간단하면서 견고한 디자인
  

# 목표

- Nuxt.js 로 SEO 와 PWA 를 하고,
- Flutter 로 앱을 만들기 위해서 개발한 백엔드이다.

- 관리자 페이지만 PHP 와 인라인 Vue.js 3 로 작업을 하면 되며,
  PHP 로 작성하는 웹은 실험용 또는 테스트용으로만 한다.
  이 경우, 사진 등록에서 복잡하게 Vue.js 로 업로드된 사진을 바로 보여줄 필요 없이 대충 업로드만 되면 된다.
  
- 즉, 웹은 PHP 로 하지 않는다. PWA 로 하며 특히, 복잡한 기능(예: 사용자가 직접 위젯 옵션으로 디자인을 하는 그런 것)은 PWA 로만 하게 한다.

# 해야 할 일

- Generate thumbnails on the fly. 썸네일으 사진 업로드 할 때 하지 말고, files/thumbnails 폴더에 저장한다.
  - /etc/image/thumbnail.php?source=...&width=..&height=.. 와 같이하는데, target 은 source 는 파일 경로 URL 이나, file.idx 일 수 있다.
  
- docker 에서 php 설정, short_open_tag On 이 동작하지 않음.

- pass login
  
- 쇼핑몰 옵션 페이지를 만들고, 배송비와 배송비 무료 제한 금액을 지정한다. mall.options 라우터도 수정한다.
  
- backend 의 코드를 복사 할 것.
- 기본 코어 말고, plugin 은 관리자 모드에서 설치 과정을 진행하도록 한다. 워드프레스와 동일하게 한다.
  - 이 때, plugins 폴더를 두고, 외부 개발자가 플러그인을 추가 할 수 있도록 한다.
  
- 설치 과정을 backend/model 에서 가져와서 그대로 사용 할 것.

- 파일 업로드에서, 퍼미션이 없을 때, empty response 에러가 나온다. 올바른 에러가 표시되도록 할 것.


- 훅시스템
  - entity()->create(), update(), delete(), get(), search() 등에서만 훅을 걸면 왠만한 것은 다 된다.
  
- subcategories of the category.
- SQL injection block on `where` in search function.
- Wordpress style, Friendly URL. There might be no title, so, posts may have url of numbers only.
  - `this-is-title.`, `this-is-title-2`.

- posts 테이블에 countryCode 필드를 두어서, 교민 카페 만들 때, 국가별 검색 가능하도록.
  - name, password, email, gender, address1, address2, zipcode, 등 기타 필드 다 생성.
- phpunit 을 host os 에서 실행 할 수 있도록 할 것. https://hub.docker.com/r/phpunit/phpunit/ 에 host os 에서 실행하는 방법 설명.
  
- https://domain.com/qna 와 같이 짧은 URL 을 지원 할 것.
  기본적으로 모든 category 는 최 상위 슬래시(/) 다음에 기록 할 수 있도록 한다.

- .gitignore 에 기본적으로 widgets 폴더를 빼고, 원하는 위젯만 -f 로 넣을 것.
  
- git 에서 추가된 특정 폴더나 파일을 빼는 방법을 배울 것.

- @todo when categoryIdx of post changes, categoryIdx of children must be changes.

- meta 에 int, string, double(float) 은 serialize/unserialize 하지 말 것. 그래서 바로 검색이 되도록 한다.

- file upload error handling. https://www.php.net/manual/en/features.file-upload.errors.php
- 파일에 taxonomy 와 entity 추가


- search(): where 에 SQL Inject 검사를 하도록 한다.
  drop, select, replace, insert, update 와 같은 단어를 넣지 못한다.
  하지만, in 은 그 자체로 조건식에 들어가야하므로, 가능하다.
  
- search() 함수의 where: 에 메타 검색을 같이 지원한다.
  where: "a='apple' or (b='banana' and meta.c='cherry') or meta.d=1"
  SQL query 에 `meta.` 이라는 것이 들어가면 무조건 meta 검색으로 인식한다. 따라서 검색 조건에 `meta.` 라는 단어가 들어가면 안된다.

## next branch 에서 해야 할 것

- README 에 최소한의 정보만 두고, 모두 phpDocument 화 한다.
  
- next 를 main 에 merge 또는 이동 계획
  - 먼저, next 브랜치로 작업이 잘 되는지, 확인을 한다.
    - 플러터와 CenterX 모두 main branch 는 놔 두고,
    - 플러터에서도 next 브랜치를 만들고, CenterX next branch 로 바로 접속 하도록 한다.
  - 작업이 잘 되면, main 을 0.2 로 백업하고, next 를 main 으로 바꾼다.
    - 먼저, 그동안 변경된 사항을, https://github.com/thruthesky/centerx/commits/main 에서 확인해서, 변경된 내용을 적용한다.
    - branch 이름 변경하기 참고: https://docs.google.com/document/d/1OV1FYLwBBloQU_H8wUkZLnzCLtFdVLiRtXPZXNa5Bkw/edit#heading=h.fbs4ukt4a7lj

- @done User test,
  
- @done Category test,
  
- @done Post test
  
- @done Comment test

- @done VoteHistory entity test

- @done Entity hook test

- @done Point test

- @done entity::get() 함수 삭제
- @done my() 함수 삭제. login() 으로 대체
- @done isSucess() 함수 삭제. 테스트에서 별 소용 없는 함수.
- @done entity 밑에 안쓰는 함수 삭제.

- comment-edit-default 작업 중. 모든 코멘트 쓰기/수정/삭제/ 파일 업로드에 기본적으로 적용한다.


- 관리자 페이지 작업.
  - 관리자만 관리자 페이지를 사용 할 수 있도록 한다.
  - p() 함수를 두어서 &p=current.page 를 리턴하게 하고
    w() 함수를 두어서 &w=widget.name 을 리턴하게 하고,
    wc() 함수를 두어서 &wc=child.widget.name 을 리턴하게 한다.
    widget_html_form_hidden_tags('mode', ['idx' => ...])
    와 같이 함수를 두어서 widget html form hidden tags 를 한번에 호출한다.
    p, w, wc, mode 는 기본적으로 들어가고, 그외 Hidden 값을 입력을 받을 수 있도록 한다.
    그래서 관리자 페이지 링크를 좀 더 통일성있게 사용한다.
    
  - 카테고리 페이지 업데이트
  - 게시글 페이지 업데이트
  - 세팅 페이지 업데이트
  - 언어화 페이지 업데이트
  - 상품 등록 페이지에서, File 업로드 테스트

- 플러터에서 next 브랜치 테스트

- next 브랜치를 main 으로 변경


- @doc `next.***.test.php` 로 테스트 코드를 작성하고 있다.
  - user, category, post, comment 순서로 테스트
  - user()->create()->response() 에서 에러가 있으면 response() 항상 에러 문자열을 리턴한다.
  
- @doc 클라이언트로 전달하는 response() 함수는 에러가 있으면 에러 문자열을 리턴한다.
- @doc 클라이언트로 전달하는 경우가 아니면 `->hasError` 로 에러가 있는지 없는지 검사해야 한다.



- @later meta 에 동일한 키를 여러개 입력 할 수 없지만, 배열이나 기타 여러 값을 저장하면, serialized 되어 저장된다.
  이점을 활용해서,
  기본 meta 함수명 addMeta(), getMeta(), updateMeta(), deleteMeta() 에,
  addMetaDataSet(...) 을 하면, Type SET 형식으로 배열인데, 고유한 값을 유지하는 배열에 값을 추가하는 함수를 만든다.
  deleteMetaDataSet(...) 을 하면 삭제를 한다.
  addMetaDataAssoc($key, $value) 를 하면, 메타 데이터의 값이 연관 배열인데, 연관 배열의 값을 추가하다록 한다.
  deleteMetaDataAssoc($key) 와 같이 하면 삭제를 한다.

  getMeta() 에서 taxonomy 와 entity 까지만 입력하면, 배열로 해당 entity 에 속만 메타가 모두 리턴된다.




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


# Primary Conception

- It does not use `__get()`, `__set()` magic methods to avoid ambiguety. Instead, use
  - `post(1)->get()` to get whole record.
  - `post(1)->value(...)` to get a field value. Or `post(1)->v(...)` for short.


- @next 회원 인증은 Route 에서 해야한다. 그외 입력값 검사는 각 함수에서 한다.

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

# Installation

- Install docker.
  - And, run docker.
  
- `git clone https://github.com/thruthesky/centerx`

- `cd centerx/docker`, then run `docker-compose up`.

- Give permission on `files` folder.


## Host setting

- To work with real domain(for example, `itsuda50.com`), add a fake domain like `local.itsuda50.com` on `hosts` file to develop with a real(fake) domain.
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
  

# Component


  
- [EzSQL](https://github.com/ezSQL/ezsql)
  For database connection
  
- Firebase

- [MobileDetect](https://github.com/serbanghita/Mobile-Detect)
  To detect the device is mobile
  


# 폴더구조

- `etc` - For etc files.
  - `etc/boot` - has all boot related code and scripts.
  - `etc/install` - for web installation.
  - `etc/phpMyAdmin` - phpMyAdmin for managing database. Access `https://www...com/etc/phpMyAdmin/index.php`.
  - `etc/sql` - has SQL schema for installation.
  
- `lib` has system library files like class files and function files.
  
- `routes` 폴더에는 각종 라우트가 저장된다.

- `storage` is for all the uploaded files.

- `themes` is theme folder for website.
  
- `vendor` is for compose files.
  
- `widgets` is for widgets.





# Configuration

- `config.php` on project folder is the default configuration, and it can be overwritten by theme configuration.
  기본 설정은 root/config.php 에 저장되며, 각 테마에서 설정을 덮어 쓸 수 있다.
  

## Theme Configuration

- `themes/[theme-name]/[theme-name].config` will be included(and run) if it exists.
  It will run even if it is API call. (Just connect to api domain to proper theme.)

- All the default configuration can be over-written by theme configuration.
  That means, each theme can use different database settings.

- You can define hooks, routes, or any code for the theme inside the config.
  If config.php gets bigger, it's a good idea to split it into different php scripts like
  `functions.php`, `hooks.php`, `routes.php`, etc...

  

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




# API Protocol

- API Protocol examples are written in `/etc/rest-client/rest-client.http`

- `route` is the route of the api call.
  Ex) `/?route=app.version`
  
- To get app version, access like below
  Ex) `/?route=app.version`
  
- To live reload on web browser, add `/?reload=true`. But you must remove it when you don't need live reload.
  
## Writing route code

- There are two ways of handling route.
- First, you can create a route class under `routes` folder and add method.
  For instance, if `/?route=app.version` is accessed, create `routes/app.route.php` and define `AppRoute` class, then add `version` method in it.
  
- Second, simple define a function of anywhere.
  For instance, if `/?route=app.version` is accessed, add a function to `routeAdd()` function like below.
```php
routeAdd('app.version', function($in) {
    return ['version' => 'app version 12345 !!!'];
});
```  

- For defining routes to a specific theme, create `[theme-name].route.php` and define routes there, and include it in `[theme-name].config.php`.

- For core routes, it is defined in `routes` folder.

- If there are two route handlers for the same route, that comes from route class in `routes` folder and the other comes from `routeAdd()`,
  Then, the function that is added to `routeAdd()` will be used. This means, you can overwrite the routes in `routes` folder.


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


### Displaying images

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

- @see the phpdoc

# Settings

- Setting update goes pretty much the same as Translation.






# Theme

## 테마 페이지 로딩

- 테마 페이지는 URL 변수 `p=...` 에 따라 각 `theme/theme-name` 에 있는 페이지를 연다.
  이 때 만약 해당 페이지가 없으면 `theme/default` 에 있는 페이지를 연다.
  
- 테마 페이지를 열 때, 각 테마의 `theme/**/index.php` 가 먼저 로드된다.
  그리고 각 테마의 index.php 에서 `include theme()->page()` 와 같이 호출해서 테마 페이지를 로드해야한다.
  즉, 각 테마 페이지에서 적절한 디자인을 추가하거나 기본적인 HTML head 등을 화면에 출력 할 수 있다.
  
- URL 변수 `p=abc.submit` 과 같이 `.submit` 으로 끝나면, index.php 에 의해서 각 테마의 index.php 를 호출하지 않고, 바로 테마 페이지를 연다.
  즉, 테마 디자인을 생략하고(화면에 출력하지 않고), 곧 바로 테마 스크립트만 실행하는 것이다.



## Admin page design

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


## FORM

- FORM 은 가능한 post method 로 전송한다.
  
- 글 작성과 같은 데이터 생성 페이지는 `<input type="hidden" name="p" value="forum.comment.edit.submit">` 처럼 `p` 값의 끝을 `.sumit` 으로 한다.
  그러면, 테마를 실행하지 않고, 바로 그 스크립트를 실행한다. 즉, 화면에 번쩍임이 사라지게 된다.
  
- 글/코멘트 쓰기에서 FORM hidden 으로 `<input type="hidden" name="returnTo" value="post">` 와 같이 하면, 글/코멘트 작성 후 글(루트 글)로 돌아온다.


## 글 쓰기

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

* entity CRUD 에 대해서, 훅을 발생시킨다.

* 예를 들어, `posts_before_create` 이나 `posts_after_create` 훅은 posts enitty 생성 직전과 직후에 발생한다.
  글/코멘트가 posts entity 이며, 쇼핑몰이나 기타 여러가지 기능을 posts entity 로 사용 할 수 있다.
  이러한 모든 것들에 대해서 생성을 하고자 할 때, hook 을 통해서 원하는 작업을 할 수 있다. 만약, 작업이 올바르지 않으면 에러를 내서, entity 생성을 못하게 할 수도 있다.

## Entity Create 훅

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

```shell
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php"
```

- 원한다면, 아래와 같이 테스트 파일의 일부 문자열을 포함하는 파일만 실행 할 수 있다.
  - 테스트 파일 이름에 "app" 또는 "user" 라는 문자열이 있으면 실행한다.
  
```shell
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php app"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php user"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php point"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php shopping-mall"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php getter"
```


