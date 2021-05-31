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