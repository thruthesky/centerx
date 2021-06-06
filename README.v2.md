# Matrix


# References


# 클라이언트

## 클라이언트 초기 설정 로직

- 앱이 부팅하면 초기 설정 정보(메뉴 등)을 최대한 빠르게 보여 줄 필요가 있다.
  - 예를 들면, 사용자가 최초로 philov.com 에 접속하는 경우, 서버로 부터 데이터를 가져오기 까지 시간이 너무 걸린다.
  - 그래서, Vue.js 내에서 초기 설정 값들 저장하고, 앱 부팅시 바로 보여준다.

- 참고로, 웹 서버의 PHP 에서 index.html 에 자바스크립트로 초기 설정하는 것은 PWA 의 경우,
  index.html 을 service worker cache 를 해서, 웹 서버로 부터 최초 1회(한 번) 가져오면,
  manifest 에 있는 cache code 가 바뀌기 전까지는 다시 가져오지 않기 때문에 index.html 에 동적 정보를 넣으면 안된다.
  

- 따라서 PWA 를 하는 경우, Flutter 로 하던, Vue.js 로 하던 그냥, 앱 내의 소스에 기본 설정 값을 추가해 놓고,
  앱이 부팅하면, 서버로 부터 데이터를 가져와서 사용해야 한다.
  - 참고: 본 문서의 앱 내 로컬 캐시

- 참고로, 카페 전체 설정을 가져오는 경우,
  - 앱에서 부팅 후, route=cafe.settings 로 가져온 후, 로컬에 캐시를 해 놓고 빠르게 쓰면 된다.

- 요약,
  - 첫 로딩시 빨리 표시해야하는 정보는 앱 내 저장.
  - 그리고 서버에서 가져온 데이터를 표시. 로컬 캐시 필요.

# Vue.js & SPA & PWA

## Vue.js 클라이언트 모듈

- Vue.js 모듈은 https://github.com/withcenter/x-vue 에 있다.

- Vue.js 에서 x-vue/services/api.service.ts 를 직접 쓰지 말고, app.service.ts 를 두고, AppService.api 를 통해서만 쓰도록 한다.

- App 과 Api 에서 상태를 같이 쓰기 위해서,
  - Vue.js 에서 store/index.ts 에 반드시 store 파일이 존재해야하고,
  - Api State 와 app state 를 합친다.
  - 이 때, 개발자가 app 위해서 만든 기본 텍스트를 api 와 같이 사용 하게 할 수 있다.
    그래서 api 에서 언어 번역 파일을 서버에서 읽어 들여, state 를 변경하면, 기본 텍스트를 덮어 써서 쓸 수 있는 것이다.

```ts
import { texts } from "@/service/translation";
import { apiState } from "@/x-vue/services/api.store";

// 여기에 앱의 state 관리 변수를 추가하면 된다.
const state = {};

// 앱의 기본 번역된 텍스트를 아래 처럼 지정하면 된다. 
apiState.texts = texts;

Vue.use(Vuex);
export default new Vuex.Store({
  state: Object.assign({}, state, apiState), // 앱의 state 와 api state 를 합쳐서 저장한다.
  mutations: {},
  actions: {},
  modules: {},
});
```

## PWA

- Offline support 를 위해서 서비스 워커 캐시를 하는데, 이 경우 index.html 파일을 다시 서버로 부터 불러오지 않는다.
  - 따라서 서버에서 index.html 을 변경해 봐야 소용이 없다.
  
- 참고, 본 문서의 카페 설정 참고.
  


# 독립 스크립트

- 일반적으로 아무 도메인(예: sonub.com)에서 `https://sonub.com/index.php?route=...` 와 같이 접속하면
  `ROOT_DIR/index.php` 가 실행된다.
  - 하지만, Vue.js 나 기타 경우 홈페이지의 접속 경로를 `/view/x` 와 같이 해야 할 필요가 있다. 그래야 개발이 편하기 때문이다.
    nginx 의 root 폴더가 `/view/x` 로 되는데,
    웹 브라우저로 접속시 `ROOT_DIR/index.php` 가 실행되는 것이 아니라, `ROOT_DIR/view/x/index.php` 가 실행된다.
    이와 같은 경우에도 CenterX 가 실행이 가능하다.
```php
include '../../boot.php';
if ( isset($_REQUEST['route']) ) {
    include ROOT_DIR .'controller/control.php';
    return;
}
include ROOT_DIR . 'var/cafe.index.php';
include view()->folder . 'index.html';
```

- 다만, 주의해야 할 점은 Api 접속을 받아 들이기 위해서, `index.php?route=...` 와 같이 들어오면 controller 를 실행 해 주어야 한다.

- 이 때, 문제는 홈페이지 경로가 변경되어, 이미지 표시를 위해서 `https://sonub.com/files/abc.jpg` 와 같은 경로가 연결되지 않는다.
  - 이렇게 하기 위해서는 nginx.conf 에 별도의 도메인(예: file.sonub.com)을 두어서, 그 file.sonub.com 도메인의 root 폴더를 `/view/x` 가
    아닌 CenterX 의 루트 폴더로 한다.
    그리고, config.php 의 `UPLOAD_SERVER_URL` 이 이미지 서버 주소인데, 이를 HOME_URL 로 하지 않고, `view-name.config.php` 로
    `UPLOAD_SERVER_URL` 을 다른 도메인으로 덮어 쓴다.
  - 그러면 이미지 경로가 `https://sonub.com` 이 아닌 `https://file.sonub.com` 이 된다.


# Restful API

## Api 경로

- 본 문서의 `# 독립 스크립트` 를 참조한다.
    


# 클라이언트 캐싱

- 서버로 부터 데이터를 가져와야하는데, 통신 상태가 느리면, 화면에 정보가 늦게 보여지는데, 그러한 현상을 막고자 앱 내에서 캐시를 한다.
  -  캐시를 하면, 서버가 죽은 경우 또는 오프라인에서도 데이터를 보여줄 수 있다.

- 로직
  - 앱에서 서버로 호출 할 때, 먼저 로컬(앱 내의 local storage)에 저장된 데이터를 불러와 상태 관리자에 업데이트한다.
  - 그리고 서버로 부터 데이터를 가져 온 다음, 상태 관리자를 업데이트하고,
    - 로컬에 저장한다.
      즉, 다음에 앱이 실행되거나, 서버로 다시 호출 할 때, 최근에 저장된 내용을 먼저 쓰고, 서버로 부터 업데이트 된 내용을 쓰는 것이다.
      


# Security

- Controller must check `where` http var to not accept value. The `where` clause must have question mark only without right side value.
  

# Boot


## PHP 스크립트 호출 순서

- `index.php`
  시작 스크립트
    
  - `boot.php`\
    부팅 스크립트. 어느 위치의 스크립트이든 이 스크립트를 include 하면, Matrix 를 부팅하여 사용 할 수 있다.

    - `config.php`\
      글로벌 설정. 이 스크립트를 통해서 여러가지 설정을 할 수 있다.
      - 접속 도메인을 바탕으로 추가 설정을 각 `view/view-name/config.php` 에서 할 수 있다.
        - 추가 설정은 Restful API 를 호출 할 때에도 사용 할 수 있다.
    
    - `view/view-name/view-name.functions.php`\
      접속 도메인 별 view 폴더에 `view-name.functions.php` 스크립트를 두고, 추가 코드를 작성 할 수 있다.
      여기에 hook 등 필요한 코드를 실행 할 수 있다.

  - `controller/control.php`\
    부팅이 된 후, control.php 를 통해서 Restful API 로 연결해야 할지, View 를 로드해야 할지 결정한다.
    
    - HTTP 파라메타로 `route` 값이 전달되면, Restful API 로 간주하고 `controller/api.php` 를 로드하고,
      그렇지 않으면 웹 브라우저에 보여 줄 View 를 로드하는 것으로 간주하여 `controller/view.php` 를 로드한다.
  
    
# Restful Api

- HTTP 입력 값에 route 가 있으면 `boot.php => controller/control.php => api.php` 의 순서로 실행된다.

- `api.php` 에서 session id 로 로그인을 하고, 각 route 에 맞는 controller 를 실행한다.


# View, Theme

- HTTP 입력 값에 route 가 없으면 `boot.php => controller/control.php => view.php => view/view-name/index.php` 의 순서로
  각 view 폴더의 index.php 가 실행된다.

- `themes/theme-name/index.php`\
  `controller/view.php` 의 `view()->file('index')` 에 의해서 각 뷰의 index.php 를 실행한다.

  - 이 index.php 에서 필요한 모든 처리를 하면 된다. 예를 들어 bootstrap 을 로드해서, 화면 디자인을 보여주고, 클릭을 하면 이동을 할 페이지로 링크를 걸면 된다.
    링크를 걸 때에는 아래의 page link 항목을 참고한다.
  
  - 만약, Vue.js 2 로 빌드된 index.html 를 웹 브라우저에 보여주어야 한다면, `include 'index.html';` 와 같이 하면 된다.
  
- 각 view 스크립트에서는 controller 를 사용해서 model 로 접속한다.


# Page Link

- `p` 태그를 통해서 다음 실행 페이지를 지정 할 수 있다. 그리고 `p=` 는 생략이 가능하다.
  예) `http://domain.com/?p=abc.def` 또는 `http://domain.com/?abc.def`


# Model

## View Model

```php
d(view()->file('index'));
d(view()->page());
```


# Api Response

- controller 의 리턴 값은 무조건 JSON 이며, 그 JSON 을 해독하면 response 키가 있는데, 그 키의 값이 컨트롤러 실행 후 결과 값이다.
  - response 는 JSON 값인데, 이 값을 다시 Modelling 하거나 `entity()->setMemoryData()` 또는 `entity()->copyWith()` 으로 객체화 하지
    않는다. 즉, 그냥 JSON 으로 사용한다.
    그 이유는 우선, PHP 단에서 View 를 사용하는 전통적인 웹 사이트 개발 보다는, SPA 또는 Flutter 와 같이 'SPA 웹'이나 플러터 앱에서 JSON 데이터를
    가져와서 사용하는 것을 권하기 때문이다.
    즉, SPA 를 처음 띄우기 위해서는 view/view-name/index.php 를 사용해야 하지만, 그 후 부터는 SPA 로 실행하는 것을 권장한다.
  
- response 가 성공의 값을 담고 있다면, 반드시 배열이어야 한다.
- response 가 에러의 값을 담고 있다면, 반드시 `error_` 로 시작하는 문자열이어야 한다.


# Api Error

- response 의 값이 `error_` 로 시작하는 문자열이면 에러이다.
- controller 가 리턴하는 겂이 없으면 `error_response_is_empty` 에러 발생.
- controller 가 배열이나 에러 문자열 외의 값을 리턴하면 `error_malformed_response` 에러 발생.

- 에러 문자열 코드 뒤에 `::` 를 표시하고 그 뒤에 추가적인 에러 설명 메시지가 들어 갈 수 있다.
  예) `error_user_not_found::thruthesky@gggg.com`
  
- 에러 관련 함수 중,
  - `error()` 는 에러 결과를 JSON 으로 출력한다.
  - `err()` 는 에러 코드와 에러 설명 메시지를 합친다.
  - `e()` 는 에러 객체로 `e()->user_not_found` 와 같이 에러를 호출 할 수 있다.
  위 함수 들 중에서 이름이 긴 순서로 포함을 한다. 짧은 함수 `e()` 가 에러 객체 또는 에러 메시지를 담고,
    `err()` 이 에러를 더하고, `error()` 이 에러를 출력한다.
    사실 `err()` 는 `add_error_string` 의 약자이다.
    예) 
    `error(err(e()->controller_file_not_found, $filePath));`

# Config

## 일반 설정

- taxonomy 는 `config` 이고, entity 가 0인 것은 모두 일반 설정이다.

## 관리자 설정

- 관리자만 설정 할 수 있는 것으로 taxonomy 가 `config` 이고, entity 는 1 이다.


# 클라이언트 동작 방식

- 앱이 부팅 할 때, 관리자가 설정한 것들을 로드해야 한다.
  - 단, 양이 많은, 설정은 제외 할 수 있도록 관리자 설정을 관리한다.
  
- 필요한 게시판 설정을 미리 로드해야 한다.
- 



# Unit Testing

- 테스트 경로는 `controller/**/*.test.php` 파일과 `tests/*.test.php` 파일들이다.


## 테스트 예제

- 아래는 `controller/app/app.controller.test.php` 파일의 예제이다.
  controller 를 include 해서 테스트를 하면 된다.
  
```php
<?php
include "app.controller.php";
isTrue((new AppController())->version(), "App version");
```


## HTTP 로 컨트롤러 테스트 예제

- php test 는 www_docker_php 컨테이너에서 실행되는데, nginx 는 www_docker_nginx 에 있다.
  즉, www_docker_php 컨테이너에서 www_docker_nginx 컨테이너에 접속해서, nginx 에서 다시 PHP 실행을 위해서 www_docker_php 를 접속하는 것이다.
  이 때, test php 코드에서 접속을 할 때, http://www_docker_nginx/index.php 와 같이 접속을 해야 한다.
  그리고, nginx 설정에 www_docker_nginx 를 도메인으로 추가해 주고,
  config.php 의 도메인 설정에도 추가를 해 주어야 한다.
  


# 광고

## 광고 기본, 설정 및 테이블 구조

- 광고 테이블은 따로 없고, `posts` 테이블을 사용한다.

- 게시판 아이디는 `ADVERTISE_CATEGORY` 에 기록되어져 있다.

- 광고 시작과 종료
  - 시작 날짜는 beginAt 에 저장하고,
  - 종료 날짜는 endAt 에 저장한다.

- 광고 사진을 등록 할 때, `files` 테이블에 code 별로 등록을 한다.
  - 각 광고 code 는 광고 타입으로 `advertise.defines.php` 에 AD_XXX 로 등록되어져 있다.
  - 예를 들면, 날개배너(AD_WING), 게시판 사각 배너(AD_POST_LIST_SQUARE) 등이다.
  - 각 (광고 글)에 등록을 할 때, 각 code 별로 배너를 등록 할 수 있도록 해 준다.
  - 즉, 하나의 광고에 여러 code 가 있는데, 사진을 모두 등록하면, 모든 광고 위치에 다 나온다.

- 광고 표시를 할 때, `posts` 테이블에서 광고 기간이 남아 있는 것 중, `files` 테이블에서 원하는 광고 타입을 검색하는데, 그 광고 위치가 `metas` 에 있는 것을 뽑아낸다.
  관련 함수는 model/advertise/advertise.model.php 를 참고한다.


## 광고 배너의 크기

- 각 사이트에서 얼마의 크기를 표시하느냐에 따라서, 각 상황에 맞춰서 배너 크기를 정하면 된다.


## 광고 위치별 요약

- 필고 처럼, 복잡하게 하지 않는다.

- 최상위 배너(제호 배너)는
  - 데스크톱 맨 위에 항상 표시되며,
  - 글 읽기 페이지 맨 위에 표시된다.

- 날개 배너
  - 왼쪽 또는 오른쪽 날개에 광고가 나오고,
  - 모바일 첫 화면에 나온다.

- 광고가 없는 경우에는 각 place 별로 기본 광고가 노출된다. 기본 광고가 없는 광고가 있을 수도 있다.

- 광고는 자동으로 노출되는 것이 아니라, 각 위치 별로 적절하게 표시를 해 주어야 한다. 표시를 하는 방법은 아래의 항목을 참조한다.

## 광고 표시 방법

- `?route=advertise.all` 을 통해서 한번에 통째로 모든 광고 정보를 가져온다. 사실 필요한 필드만 가져오면, 광고 개 수가 300개 내외라면 용량은 많지 않다.
- 각 위치별 광고를 표시해 준다.

### 버전 1.x 에서 위젯으로 출력하는 방법

- 아래와 같이 type 에는 광고 타입을 기록하고, place 에서는 "게시판.카테고리"와 같이 표시한다.

```php
<?php include widget('advertisement/banner', ['type' => AD_TOP, 'place' => 'R']) ?>
```

### 게시판 목록에 광고 표시 방법

- 아래의 예제는 게시판 맨 위에 광고를 표시한다.

```php
hook()->add(HOOK_POST_LIST_TOP, function() {
    include widget('advertisement/banner', ['type' => AD_POST_LIST_SQUARE]);
});
```

- 아래의 예제는 게시판 목록의 중간에 광고를 표시한다.

```php
hook()->add(HOOK_POST_LIST_ROW, function($rowNo, PostTaxonomy $post) {
    if ( $rowNo == 2 ) {
        include widget('advertisement/banner', ['type' => AD_POST_LIST_SQUARE]);
        echo "<hr>";
    }
});
```



## 세부 설정

- 광고 게시판 카테고리를 `ADVERTISE_CATEGORY` 에 지정한다.
  - 참고로 advertisement category 의 list, edit widget 을 선택해야 한다.
  
- 배너 1번 크기. Bootstrap 4 의 col-3 의 너비가 255px 이다. 그래서 배너 1번 크기를 255 x 100 으로 통일한다.
  - 이 배너 크기를 날개 배너 등. 가능한 많은 곳에서 사용한다.
  - 제작은 408x160 으로 한다.

```css
.banner-255x100 {
    width: 255px;
    height: 100px;
}
```

- 배너 2번 크기. 정사각형 배너로 다자인을 하기 쉽고 활용을 할 곳도 많다.
  - 배너의 기본 크기는 320x320 로 제작하지만, 가능한 모든 장소에서 비율을 유지한채, 더 작게 보일 수 있다.



# 카페, Cafe




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


## 카페 로고 제작법

- 메인 카페와 서브 카페 모두 적용되는 것으로
  - 너비 500px, 높이 72px 로 고정되어져 있다.
  - 만약, 로고 디자인을 너비 300px 로 하고 싶다면,
    - 전체 이미지 너비는 500px 로 하고, 실제 디자인 내용을 300px 로 하고, 이미지의 중간에 위치시키면 된다.
      즉, 남는 여백은 그냥 빈 칸으로 두는 것이다.

# 카페 클라이언트 로직

## 카페 설정, 초기 메뉴 설정 등

- 참고: 본 문서의 클라이언트 초기 설정 로직
  
#### Vue.js 에서 작업

- 

- index.php 파일은 아래와 같이 간단하게 하고,

- index.html 에 name, logo, menu 가 들어간다.
  - 여기에 menu 는 카페 메인 메뉴이고, 카페 별 메뉴는 서버에서 가져와서 보여 주어야 한다.

### Sub cafe logic

- Get cafe category from localStorage into memory, and;
  - display cafe name on render view.
  - display admin menu if the user is cafe admin
  - display cafe menu
- When app is mounted(loaded), get the cafe category record and
  - save it on localStorage for the next use.
  - update the memory.

## 카페 프로토콜

### 전체 설정 가져오기

- `route=cafe.settings`