# emp

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
  
- 코멘트 재귀 함수.

- .gitignore 에 기본적으로 widgets 폴더를 빼고, 원하는 위젯만 -f 로 넣을 것.
  
- git 에서 추가된 특정 폴더나 파일을 빼는 방법을 배울 것.

- @todo when categoryIdx of post changes, categoryIdx of children must be changes.

- meta 에 int, string, double(float) 은 serialize/unserialize 하지 말 것. 그래서 바로 검색이 되도록 한다.

- file upload error handling. https://www.php.net/manual/en/features.file-upload.errors.php

## 해야 할 일. 다음 버전.

- CRUD 함수 (예: getXxx(), setXxx(), update(), create(), delete(), exists() 등등) 외에는 모두 현재 객체를 리턴할 것.
  그래서, user()->by(email)->exists() 와 같이 호출 할 수 있도록 할 것.
  단, 옵션으로 user()->by(email, returnFormat: ARRAY_A) 와 같이 배열로 받을 수 있도록 한다.

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
  You can define any hooks or routes in configuration.

- All the default configuration can be over-written by theme configuration.
  That means, each theme can use different database settings.

  

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



# API Protocol

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


## User Api

- To login, access like below
  Ex) `/?route=user.login&email=...&password=...`
  
- To register
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
https://local.itsuda50.com/?route=post.create&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&category=apple&title=yo&content=content&a=apple&b=banana
```

- To update a post, add `sessionId` with `idx` and other `key/value` pair fields to update.
````text
https://local.itsuda50.com/?route=post.update&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&category=apple&title=updated-by-no.%204&content=content&a=apple&b=banana&idx=19
````

- To delete a post,
```text
https://local.itsuda50.com/?route=post.delete&sessionId=5-9b41c88bcd239de7ca6467d1975a44ca&idx=18
```

- To get a post, just give `posts.idx`. `sessionId` may not be needed.
```text
https://local.itsuda50.com/?route=post.get&reload=true&idx=19
```

- To list posts of a category.
  - Most of the search options goes in value string of `where` param. You can put any SQL conditions on `where`.
```text
https://local.itsuda50.com/?route=post.search&reload=true&where=(categoryId=<apple> or categoryId=<banana>) and title like '%t%'&page=1&limit=3&order=idx&by=ASC
```


## Comment Api


- To create a post,
  - Required fields are: `sessionId`, `rootIdx`, `parentIdx`.
    - `rootIdx` is the post.idx and `parentIdx` is the parent idx. parent idx can be a post.idx or comment.idx.
  - `content`, and other properties are optoinal.
  - Since `Entity` class supports adding any meta data, you can add any data in `&key=value` format.

```text
https://local.itsuda50.com/?route=comment.create&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&content=A&rootIdx=159&parentIdx=159
```

- To update a post, add `sessionId` with `idx` and other `key/value` pair fields to update.
````text
https://local.itsuda50.com/?route=comment.update&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&content=B-A-Updated&idx=162
````

- To delete a post,
```text
https://local.itsuda50.com/?route=comment.delete&reload=true&sessionId=4-d8023872c25451948d1a709230a238ee&idx=162
```

- To get a post, just give `posts.idx`. `sessionId` may not be needed.
```text
https://local.itsuda50.com/?route=comment.get&reload=true&idx=163
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

# Vote

- 추천 기능은 게시글 뿐만아니라, 사용자 프로필에도 할 수 있도록 vote_histories table 에 taxonomy 와 entity 를 추가해 놓았다.


# Theme

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

- Recommended admin page(widget) layout. You can pass child widget path over `cw`.
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



# Unit Testing

- 2021년 3월 기준, PHPUnit 이 PHP8 을 완벽히 지원하지 않는 것인지, 실행이 잘 안된다. 하지만, 에러가 나는 부분이 EzSQL 인 것을 감안하면, EzSQL 에 문제가 있지 싶다.
  - 그래서, 테스트 로직을 직접 작성했다.
  
- 아래와 같이 실행하면, `tests/*.test.php` PHP 스크립트(파일)을 실행한다.

```shell
% chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php"
```

- 원한다면, 아래와 같이 테스트 파일의 일부 문자열을 포함하는 파일만 실행 할 수 있다.
  - 테스트 파일 이름에 "app" 또는 "user" 라는 문자열이 있으면 실행한다.
  
```shell
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php app"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php user"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php point"
chokidar '**/*.php' -c "docker exec docker_php_1 php /root/tests/test.php shopping-mall"
```
