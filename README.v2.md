# Matrix


## Boot


### PHP 스크립트 호출 순서

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
  
    
## Restful Api

- HTTP 입력 값에 route 가 있으면 `boot.php => controller/control.php => api.php` 의 순서로 실행된다.

- `api.php` 에서 session id 로 로그인을 하고, 각 route 에 맞는 controller 를 실행한다.


## View

- HTTP 입력 값에 route 가 없으면 `boot.php => controller/control.php => view.php => view/view-name/index.php` 의 순서로
  각 view 폴더의 index.php 가 실행된다.

- `themes/theme-name/index.php`\
  `controller/view.php` 의 `view()->file('index')` 에 의해서 각 뷰의 index.php 를 실행한다.

  - 이 index.php 에서 필요한 모든 처리를 하면 된다. 예를 들어 bootstrap 을 로드해서, 화면 디자인을 보여주고, 클릭을 하면 이동을 할 페이지로 링크를 걸면 된다.
    링크를 걸 때에는 아래의 page link 항목을 참고한다.
  
  - 만약, Vue.js 2 로 빌드된 index.html 를 웹 브라우저에 보여주어야 한다면, `include 'index.html';` 와 같이 하면 된다.
  
- 각 view 스크립트에서는 controller 를 사용해서 model 로 접속한다.


## Page Link

- `p` 태그를 통해서 다음 실행 페이지를 지정 할 수 있다. 그리고 `p=` 는 생략이 가능하다.
  예) `http://domain.com/?p=abc.def` 또는 `http://domain.com/?abc.def`


## Model

### View Model

```php
d(view()->file('index'));
d(view()->page());
```


## Api Response

- controller 의 리턴 값은 무조건 JSON 이며, 그 JSON 을 해독하면 response 키가 있는데, 그 키의 값이 컨트롤러 실행 후 결과 값이다.
  - response 는 JSON 값인데, 이 값을 다시 Modelling 하거나 `entity()->setMemoryData()` 또는 `entity()->copyWith()` 으로 객체화 하지
    않는다. 즉, 그냥 JSON 으로 사용한다.
    그 이유는 우선, PHP 단에서 View 를 사용하는 전통적인 웹 사이트 개발 보다는, SPA 또는 Flutter 와 같이 'SPA 웹'이나 플러터 앱에서 JSON 데이터를
    가져와서 사용하는 것을 권하기 때문이다.
    즉, SPA 를 처음 띄우기 위해서는 view/view-name/index.php 를 사용해야 하지만, 그 후 부터는 SPA 로 실행하는 것을 권장한다.
  
- response 가 성공의 값을 담고 있다면, 반드시 배열이어야 한다.
- response 가 에러의 값을 담고 있다면, 반드시 `error_` 로 시작하는 문자열이어야 한다.


## Api Error

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

## Config

### 일반 설정

- taxonomy 는 `config` 이고, entity 가 0인 것은 모두 일반 설정이다.

### 관리자 설정

- 관리자만 설정 할 수 있는 것으로 taxonomy 가 `config` 이고, entity 는 1 이다.


## 클라이언트 동작 방식

- 앱이 부팅 할 때, 관리자가 설정한 것들을 로드해야 한다.
  - 단, 양이 많은, 설정은 제외 할 수 있도록 관리자 설정을 관리한다.
  
- 필요한 게시판 설정을 미리 로드해야 한다.
- 



## Unit Testing

- 테스트 경로는 `controller/**/*.test.php` 파일과 `tests/*.test.php` 파일들이다.


### 테스트 예제

- 아래는 `controller/app/app.controller.test.php` 파일의 예제이다.
  controller 를 include 해서 테스트를 하면 된다.
  
```php
<?php
include "app.controller.php";
isTrue((new AppController())->version(), "App version");
```


### HTTP 로 컨트롤러 테스트 예제

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
