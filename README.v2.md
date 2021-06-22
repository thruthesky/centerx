# Matrix

- Matrix 는 단어의 뜻 그대로 웹/앱 또는 프로젝트 수행에 있어 모체(기반)이 되는 백엔드 프레임 워크이다.
- 버전 1.x 에서의 이름은 CenteX 이었으며 버전 2 에서 Matrix 로 변경이 되었다. 버전 2 에서는 Matrix 와 CenterX 라는 단어를 같이 쓰고 있으며, 버전 3 에서는 CenterX 라는 표기를 완전히 없앨 예정이다.
- Matrix 는 웹사이트 개발 및 Restful Api 를 통해서 Mobile App 의 백엔드로 개발 할 있도록 하는 프레임워크이며, 매우 직관적이 간단하여 다른 개발자들이 쉽게 이해하고 사용 할 수 있다.

# 목표

- 최대한 쉽고 짧은 소스 코드로 단순한 프레임워크 개발

# 개발 환경 및 방향

- 도커 + Nginx + PHP + MariaDB 로 구성되어져 있으며, 도커없이 직접 원하는 OS 에 설치를 해도된다.
- 버전 1 에서는 백엔드로 Restful API 를 완전히 지원하며, PHP 에서 직접 웹사이트를 랜더링을 하는 것도 하나의 방향이었는데,
  버전 2 에서는 백엔드와 클라이언트엔드를 완전히 분리시켜 작업하는 것을 권장하고 있다.

- 클라이언트 모듈
  - Vue.js 2(IE11 이 많이 사용되고 있어, Vue.js 2 선택)에서 작업이 편하도록 Github submodule 로 개발되어져 있다.
  - 플러터 패키지. Matrix 와 Restful API 통신을 하는 모듈이 pub.dev 패키지로 등록되어져 있다.
  

# Reference

- To see alpha version of Matrix 2 which has widgets and themes, see `next-2-alpha-1` branch.

# 버전 별 변경 사항 및 향후 전략

## 버전 3

- `centerx` 라는 명칭을 완전히 제거.
- PHP 에서 화면에 직접 렌더링하는 부분은 `view/admin` 빼고는 모두 제거.
  - `live-reload` 등 관련된 사항 재 정립
- `widgets` 폴더 제거
- Git repo 를 `https://github.com/withcenter/matrix` 로 이동.



## 버전 2

- 버전 2 에서 이름이 Centerx 에서 Matrix 로 변경이 되었다.
- 버전 1 에서 사용되던 MVC 패턴이 버전 2 에서는 보다 체계적으로 사용된다.
  - Model 에는 로직이들어가며 직접 DB 에서 데이터를 가져온다.
    Controller 에서는 DB 에 직접 액세스를 못하며, Model 을 통해서만 가능하다.
    View 화면을 보여주는 클랑이언트이다. SPA 또는 모바일앱 등에서 Restful API 로 Controller 에 접속하여 데이터를 DB 에 저장하거나 가져온다.
- 버전 1 에서 사용되던 widget 개념은 더 이상 사용되지 않을 것이며 다음 버전에서 widgets 폴더가 삭제될 것이다.
  현재 widgets 폴더는 관리자 페이지 등에서 사용되기 때문에 그대로 남아있다.
  
- 버전 1 에서는 theme 폴더를 통해서 PHP 에서 직접 화면에 렌더링을 하였으나 버전 2 에서는 권장하지 않고,
  PHP 는 오직 백엔드만 담당하고 클라이언트엔드는 Vue.js 또는 모바일앱과 같이 완전히 분리하여 작업하는 것을 권장한다.

- 참고로, 버전 2로 변경이 되면서, 많은 변화가 있었는데, 버전 1의 관리자 페이지가 버전 2로 모두 컨버팅 되지 않았다.
  현재 회원 정보 관리, 게시판 관리가 우선 지원되며, Vue.js SPA 로 대체될 예정이다.
  

  
# 설치와 기본 설정

본 문서에서는 우분투 서버에서 도커를 통해 centerx 설치하는 방벙에 대해 설명한다.

코어 개발자들이 개발 작업을 할 때에는 우분투 서버에서 작업을 하는 것이 아니라 윈도우즈, 맥, CentOS 등 여러 시스템에서 도커를 설치하고 테스트 개발을 한다.
즉, 우분투 뿐만아니라 도커가 실행되는 환경이면 centerx 가 잘 운영된다.
다만, 실제 서비스를 할 때에는 우분투 서버(또는 CentoOS 서버)를 추천한다.
도커를 사용하지 않고 직접 Nginx(Apache), PHP, MariaDB(MySQL)을 설치하여 CenterX 를 운영 할 수 있다.

## 설치 요약

- 먼저 도커를 설치하고 실행한다.\
  [우분투 도커 설치 참고](https://docs.docker.com/engine/install/ubuntu/)
  
- 도커는 docker-compose 를 통해서 실행하는데, CenterX 를 위한 기본 설정이 되어져 있는 Github repo 가 있다.
  아래와 같이 Docker compose 설정을 GitHub 에서 다운로드 또는 clone(또는 fork)
  한다.
  그리고 루트 계정으로 `/docker` 에 설치를 한다.

  - `git clone https://github.com/thruthesky/docker /docker`

- 그리고 docker-compose.yml 에서 MYSQL_PASSWORD 와 MYSQL_ROOT_PASSWORD 를 적절한 비밀번호로 변경한다.
  - `cd /docker`
  - `vi docker-compose.yml`

- 참고로, Nginx 서버 설정은 `/docker/etc/nginx/nginx.conf` 이며, 기본 홈페이지 경로는 `/docker/home/default` 이다.

- Nginx 에서 사용할 로그 파일을 생성한다.
  - `mkdir etc/nginx/logs`

- 그리고 아래와 같이 docker compose 를 실행한다.
  - `docker-compose up -d`
  - 여기 까지 하면, 도커가 실행되어 Nginx + PHP + MariaDB 가 구동되는 상태이다.
    

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

- Database 접속에서 아래의 에러가 나는 경우,
  데이터베이스 계정을 두 개 생성하여 Host 에 `localhost` 와 `172.18.0.2` 를 각각 추가해 주거나
  또는 데이터베이스 계정을 하나만 생성하여, `%` 를 포함하는 host 하만 추가한다.
  이 것은 로컬 접속과 다른 네트워크의 접속과 관련된 문제로 자세한 정보는 관련 문서를 참고한다.
  
```shell
mysqli::__construct(): (HY000/1045): Access denied for user 'sonub'@'172.18.0.2' (using password: YES) 
```


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



## 파이어베이스 설정

- Matrix 는 Firebase 설정을 하지 않음면 올바로 동작하지 않습니다. 즉, Firebase 연동은 필수입니다.
- Firebase Admin SDK Key Json 파일을 `keys` 폴더 아래에 저장하고 config 에 연결하면 됩니다.



## 각종 설정

- `centerx` - The project folder.
- `docker` - All docker things are saved.
  - `docker/etc` - Settings for Nginx, PHP and others.
  - `docker/logs` - Log files of Nginx and other logs.
  - `docker/mysqldata` - MariaDB database files are saved in this folder.
  - `docker/docker-compose.yml` - Docker Compose file.


## Live reload

아래의 live reload 항목 참고



# 클라이언트

## 클라이언트 작업시 참고 사항

- [Vue.js 프로젝트 진행시 참고 사항](https://docs.google.com/document/d/1WG3caN7_3eXRhPthBgDAgzzkI-OrVir1Bvnrbt-nsR0/edit#heading=h.lmaeoe85dwyn)


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
  

### 클라이언트에 초기 설정 값 지정하는 방법

- 초기 설정 값을 지정 할 때, router 로 부터 가져온 결과 값을 JSON 으로 보관하면 된다.
  - 예를 들어 카페 초기 설정 값을 지정하고자 한다면, `/?route=cafe.settings` 로 접속을 하면, 아래와 같은 값을 얻을 수 있다.
  
```json
{"response":{"mainDomains":["philov.com","www.philov.com","main.philov.com","sonub.com","www.sonub.com","main.sonub.com"],"countryDomains":["philov.com"],"rootDomainSettings":{"sonub.com":{"name":"\ud544\ub7ec\ube0c","countryCode":null},"philov.com":{"name":"\ud544\ub7ec\ube0c","countryCode":"PH"}},"mainMenus":{"qna":{"title":{"en":"QnA","ko":"\uc9c8\ubb38\uac8c\uc2dc\ud310"}},"discussion":{"title":{"en":"Discussion","ko":"\uc790\uc720\uac8c\uc2dc\ud310"}},"buyandsell":{"title":{"en":"Buy&sell","ko":"\ud68c\uc6d0\uc7a5\ud130"}},"reminder":{"title":{"en":"Reminder","ko":"\uacf5\uc9c0\uc0ac\ud56d"}},"job":{"title":{"en":"Job","ko":"\uad6c\uc778\uad6c\uc9c1"}},"rent_house":{"title":{"en":"Houses","ko":"\uc8fc\ud0dd\uc784\ub300"}},"rent_car":{"title":{"en":"RentCar","ko":"\ub80c\ud2b8\uce74"}},"im":{"title":{"en":"Immigrant","ko":"\uc774\ubbfc"}},"real_estate":{"title":{"en":"Realestate","ko":"\ubd80\ub3d9\uc0b0"}},"money_exchange":{"title":{"en":"Exchange","ko":"\ud658\uc804"}}},"sitemap":{"community":{"qna":[{"en":"QnA","ko":"\uc9c8\ubb38\uac8c\uc2dc\ud310"}],"discussion":[{"en":"Discussion","ko":"\uc790\uc720\uac8c\uc2dc\ud310"}],"buyandsell":[{"en":"Buy&sell","ko":"\ud68c\uc6d0\uc7a5\ud130"}],"reminder":[{"en":"Reminder","ko":"\uacf5\uc9c0\uc0ac\ud56d"}]},"business":{"job":{"title":{"en":"Job","ko":"\uad6c\uc778\uad6c\uc9c1"}},"rent_house":{"title":{"en":"Houses","ko":"\uc8fc\ud0dd\uc784\ub300"}},"rent_car":{"title":{"en":"RentCar","ko":"\ub80c\ud2b8\uce74"}},"im":{"title":{"en":"Immigrant","ko":"\uc774\ubbfc"}},"real_estate":{"title":{"en":"Realestate","ko":"\ubd80\ub3d9\uc0b0"}},"money_exchange":{"title":{"en":"Exchange","ko":"\ud658\uc804"}}}}},"request":{"route":"cafe.settings"}}
```

위에서 response 부분을 추출해서 앱 내의 설정 부분에 보관하면 된다.



# Vue.js & SEO & SPA & PWA

## Vue.js 로 작업을 하는 경우 주의 점

- Vue.js 는 SPA 로 백엔드와 분리되어져 있다. 이 때, Nginx 에서 도메인과 홈 경로 지정을 `/docker/home/centerx` 가 아닌
  `/docker/home/centerx/view/view-name` 와 같이 지정한다. 즉, 홈 폴더가 `/docker/home/centerx` 가 아닌 것이다. 이 부분에 대해서 혼동하지
  않도록 해야 한다.
  
- 특히, `/docker/home/centerx/view/view-name/index.php` 는 Vue.js 의 `/public/index.php` 에서 넘어오고 이 파일은 단순히 실제 로직이
  있는 파일을 include 하는 역할만 한다.

## SEO

- SPA 의 특징으로 인해 SEO 가 어렵다. SSR 을 SEO 가 Native 하지(직관적인지) 못하고 하기에는 개발 환경 설정 및 빌드가 번거롭게 느껴 질 수 있다.
  이와 같은 경우, PHP 로 Native SEO 를 할 수 있다.

- Vue.js 빌드를 하면 결과물을 dist 폴더에 저장하는데, 이를 Matrix 의 view 폴더로 지정한다. 즉, 빌드하면 바로 웹 폴더에 저장되는 것이다.

- 이 때, Vue.js 의 public 폴더에 index.php 를 둔다. index.php 는 vue.js 에서 인식하는 코드가 아니지만, 빌드를 할 때,
  Vue.js 가 빌드 폴더를 삭제해 버린다. 즉, index.php 는 index.html 과 함께 빌드 폴더에 존재해야하는데 매번 삭제되므로 아예 public 폴더에
  넣어 주는 것이다.
  - index.php 아주 간소하게 `include '../../var/domain/index.php'` 와 같이 다른 스크립트를 로드하는 코드만 넣는다.
    그리고 실질적인 코드는 `../../var/domain/index.php'` 에 기록하는 것이다.
    이 `var/../index.php` 에 `function display_latest_posts()` 와 같이 A 태그가 있는 게시물 링크 등을 뿌려 주는 함수를 준비해 놓고, Vue.js 가 빌드한 `index.html` 을 include 한다.
    그리고 이 `index.html` 에 PHP 코드를 `<?=display_latest_post()?>` 와 같이 함수를 호출하는 코드만 만들어 준다.
    요약을 하면, php 를 통해서 검색 로봇이 다른 글, 페이지로 크롤링을 할 수 있는 링크를 만들어 주는 것이다.
    그리고 도착하는 링크(글)에는 새로운 글들과 게시판 링크를 두어 크롤러가 인덱싱을 해 주는 것이다.
  - 이 때, Vue.js 의 index.html 에 `<div id="app">...</div>` 내에 `<?=display_latest_posts()?>` 를 두지 말고, 밖에 두어 Vue.js 가 관리하는 영역과 잘 조화가 되게 디자인을 하는 것이 좋다.

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


## Vue.js Build

### index.php & view-name.config.php

- index.php 와 view-name.config.php 는 필수 파일이고, Vue 가 build 하는 폴더에 같이 저장되어야 한다.
  - 그런데, Vue 가 build 를 할 때, 해당 폴더를 삭제해 버리므로, index 와 config 파일이 삭제된다.
  - 그래서, Vue 의 /public 폴더에 index 와 config 파일을 저장 해 놓는다.
  
- npm run build 를 하면,
  index.php 와 x.config.php 가 배포 폴더로 복사된다. 
  index.php 와 x.config.php 의 내용은 아무것도 없으며 오로지 var/sonub/** 의 파일을 읽어 들여서 실행한다. 
  즉, index.php 와 x.config.php 는 껍데기 뿐이고, 실제 PHP 코드는 var/sonub/** 에 들어 있다.


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
  - 이렇게 하기 위해서는 아래의 두 가지 방법을 사용 할 수 있다.
    - 첫째, 간단하게 /files/*/*.(jpg|jpeg|png|gif) 의 root folder 를 /docker/home/center/files 로 변경한다.
    - 둘째, nginx.conf 에 별도의 도메인(예: file.sonub.com)을 두어서,
      그 file.sonub.com 도메인의 root 폴더를 `/view/x` 가 아닌 CenterX 의 루트 폴더로 하고,
      config.php 의 `UPLOAD_SERVER_URL` 이 이미지 서버 주소인데,
      이를 HOME_URL 로 하지 않고, `view-name.config.php` 로 `UPLOAD_SERVER_URL` 을 다른 도메인으로 덮어 쓴다.
      그러면 이미지 경로가 `https://sonub.com` 이 아닌 `https://file.sonub.com` 이 된다.
    위 두 방법 중에서, 간단하게 root folder 를 변경하는 것을 추천한다.

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
  


# 광고, Advertisement

- 최대한 간단하게 작성
  - 필고 처럼 복잡하게 하지 않는다. 특히 Sonub 는 국가까지 선택을 하므로, 더 복잡해 질 수 있다.
  - 게시판 별 금액을 따로 두지 않는다.
    - 차라리 게시판을 세분화 하고, 통합이 필요하면, 커뮤니티 전체, 비지니스 전체를 그룹화해서 보여주도록 한다.
  - 특히, 위치별 금액을 따로 두지 않는다.
    예를 들어, 최상단 배너가, 글로벌인 경우, 1만 포인트, 구인 구직에만 노출되는 경우, 5천 포인트로 하지 않는다.
    똑 같이 1만 포인트로 한다.
    다만, 글로벌의 경우 여러개 광고가 번갈아가면서 보인다.

## Terms & Conditions

- Category banner.
  The banner that is displayed only under a specific category.
  
- Global banner.
  The banner that is displayed everywhere with or without category.
  When a category has a category banner, then the category banner will be display. or global banner will be displayed.

- Banners that has longer end dates will appear first.

- Point payment
  Banner price is different on each place. It is set by admin page.

- Cancellation.
  Advertisement can be cancelled before it begins.
  
- Refund penalty
  - If the banner had been display only a second, then the day will be treated as served.
  - If the not-served-yet-days(excluding today) is 0 days, then the point is not refundable.

  - To refund the point, the system must know how much point was set(paid) for 1 day.
    The charge (of point) may be changed often by admin.
    So, When user create the banner, the total point and periods(days) must be recorded.
    And, when user wants to cancel/refund the banner, the system can compute how much to return to the user.

- If the advertisement has not started yet, then 100% of the point will be refunded without penalty.
  - User can set the begin date of the advertisement and the user want to cancel the advertisement before the begin date,
  then 100% will be refunded.

- Each banner must be a png or jpg file. that means, GIF animation is not allowed.

- If one banner place has multiple banners to show, then it will rotate the banner by 7 seconds.

## Banner Place & Display

The table below explains how banners are dipslayed.

You can read it from left to right.

For instance, "Top banner is displayed on Top. And displayed always on Desktop. And displayed on always on Mobile.".

Banner Type|Place on Desktop|Place on Mobile|Class|Limit
------|-----|-------|------|-----
Top Banner|Top|Top|Global & Category|10 global banners. 2 category banners.
Sidebar Banner|Sidebar|Main|Global & Category|4 global banners. 2 category banners.
Square Banner|Category page|Category page|Category only|5 global banners. 30 category banners.
Line Banner |Category page|Category page|Category only|5 global banners. 30 category banners.

* Class\
  If the banner type has `global & category` class, global banner will take place when there is no category banner for that category.

### Top banner rotation

- total of 10 global banner can be uploaded.
- when there is no global banner, default banners will be displayed.
- when there is only 1 global banner, the global banner will be displayed on left, and default banner will be displayed on right.
- when there are 2 global banners, they will be displayed on one left side, and the other right side.
- when there are more than 2 global banners, the will be divided into two group and one group will be displayed on left, and the other group will be displayed on right.
- If a category has no category banner, then, global banner will be displayed just the way it is displayed as globally
- If a category has only one category banner, then the category banner will be display on left side and all the global
  banners will be displayed on right side.

### Sidebar banner rotation

- all banners will be rotated in one place.
- when a category has no banner, global banner will be shown.

## Banner management

- one post can have one banner.

- user can upload banner.
  - choose banner type(place)
    - top banner
    - category square banner
    - sidebar banner
    - line banner
  - then, choose a category or all category.
  - then, upload banner.
    - image type and size must be checked on backend. "GIF" is not allowed.
  - then, input click_url
    - or upload banner content image and input "text content" (without title) to show when clicked.
  - save.
  - then, select which country sites(cafes) to show the banner.
  - then, select how many days the advertisement will be displayed
  - then, deduct user's point.

- If the banner has expired, the user can reset the end day (and pay the point), to make the banner resume.

- User can extends the periods after cancel and refund (and pay the panelty).
  - The reason why cancel and refund is required is that,
      The user paid 100 point per 1 day. and the banner has 50 days left.
      Then, the point has changed as 200 point per day.
      and What if the user want to extends 30 days more?
      The problem happends on canncellation. The user has 50 days left with 100 per day. and if the add 30 days more
      with 200 per day, then the computation of refunding point gets complicated.
    

    
  
## 광고 기본, 설정 및 테이블 구조, Advertisement database table structure

- Advertisement does not have its own table.
  It uses `posts` table.
  (광고 테이블은 따로 없고, `posts` 테이블을 사용한다.)

- The advertisement category is stated on `ADVERTISE_CATEGORY`. (게시판 아이디는 `ADVERTISE_CATEGORY` 에 기록되어져 있다.)

- The advertisement begin date and end date.
  - Begin date is recorded at `beginAt`
  - End date is recorded at `endAt`


- Advertisement type is recorded at `code`.
- The banner image is saved as `files.code=banner`
- And when the advertisement content is being shown, the banner should not be shown.
  

## Banner display

- Get all the banners on app booting.
  - Get minimum data from backend.
  - Most of case, active banners will be less than 1,000.
    If there is less than 1,000 banners, then it is a good way to collect all the banners with minimum json data like
    banner place, image url and click url only.
    
- When advertisement banner is being display(when the user clicked the banner), the post author's information should not
  be shown, nor the post title, dates, etc. And the banner image must not being shown.
  So, there must a special design(view page) for advertisement.


## Banner image size

- There is no fixed image size. It is depending on how the designer want the banner size would be.

- Top banner & sidebar banner should have same banner size.
  
- Category square banner must be square size.
  

### Sonub banner image size

- For top banner of sonub, the size must be **570px width and 200px** height.
  When the banner is actually display on desktop or mobile, it may be shown in smaller size.
 
- The maximum logo height on desktop is 72px.
  The maximum height of logo and search box is 114px.
  So, the maximum height of header is 114px and it is stated in vue.js layout.scss

- Depending on the header size,
  The maximum banner size will be 114px. But it can be smaller than this.
  The maximum width of top banner will be 285px but it may be shown narrower when the screen size becomes smaller.
  

## Banner management

- Admin may set the point of a banner in `config.php` to 0.
  Then users can advertise without any point.
  
~~If a banner point in `config.php` is set to 0, then the banner can be deleted without stopping the banner when it is active.
  That is because, when the banner stopped, the system sets 0 to `advertisementPoint` on database,
    and the system considers if it is 0, the banner is inactive.
    So, it is not a good idea to set the point of a banner to 0.~~~
  


## 버전 1.x 에서 위젯으로 출력하는 방법

- 아래와 같이 type 에는 광고 타입을 기록하고, place 에서는 "게시판.카테고리"와 같이 표시한다.

```php
<?php include widget('advertisement/banner', ['type' => AD_TOP, 'place' => 'R']) ?>
```

## 버전 1.x 에서 게시판 목록에 광고 표시 방법

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




# 카페, Cafe

- Cafe functionality is a unique function for `sonub.com` site. So, it may not be appropriate for the model and
  controller to be under `controller` and `model` folder. Rather, they should be inside its view folder.
  But to make it easy to work, it is under the system folder temporarily.

- Cafe is like a group of small community in the site.
- Cafe is actually a category. That means, a cafe is a forum. So cafe can have its category title, description,
  subcategories, and more of what category has.

- The cafe in sonub site is targeting a global travel information sharing service.
  - Any one can create a cafe and they can share their interests or introduce their service.
  

- Cafe admin is the user who created the cafe.
  - User can create a cafe by submitting the cafe create form.
  - When user creates a cafe, the user can choose which country the cafe belongs to and sub domain of which root domain
    he wants to use.
    
- Cafe main site, main-cafe.
  - A cafe that are recorded in `CafeModel::$mainCafeDomains` are the main cafes.
    - And if it not main cafe, then it will be a sub-cafe.
  - Main cafe is not a category. Which means, it has no title, nor description, nor subscategories and nothing like
    what a subcafe has.
  - Main cafe has its settings inside `CafeModel::$mainCafeSettings`
  

- When user visits main-cafe,
  - It displays menus inside `$mainCafeSettings`.
  
- When user visits sub-cafe,
  - It displays subcategories of the sub-cafe, together with th main-cafe menus.
  
## Cafe PWA

- All cafe (both main-cafe and sub-cafe) works as PWA.
- All cafe (both main-cafe and sub-cafe) can be installed as A2HS.
  - Main cafe will use main cafe settings to patch manifest.json
  - Sub cafe will use its category settings to patch manifest.json
  



    
## 카페 부연 설명

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



# 데이터베이스 및 테이블 구조

- 모든 테이블에는 idx, createdAt, updatedAt 이 존재한다.(존재 해야 한다.)
- 레코드가 사용자의 소유를 나타낼 때에는 추가적으로 userIdx 가 존재해야 한다.

## 데이터베이스 계정 설정

- 가장 먼저 `keys` 폴더에 접속 정보가 존재하는지 확인을 한다.
  DB 접속 정보는 공개되면 안된다. 그래서 .gitignore 에 포함되어져 있는 keys 폴더에 보관을 한다. 또는 `db.config.php` 파일이 .gitignore 에
  들어가 있다.
  - 우선, `theme/theme-name/keys/db.config.php` 파일이 존재하면 로드한다.
  - 없으면, `etc/keys/db.config.php` 파일이 존재하는지 보고 있으면 로드한다.
  - 없으면, config.php 에 있는 접속 정보로 접속한다.



## 사용자 테이블

- `birthdate` 에는 YYYYMMDD 의 8자리 숫자 값이 들어간다. 만약, 앱으로 부터 년도 4자리 값만 입력을 받는다면, 19730000 와 같이 월/일의 값은 0으로 입력하면 된다.
- `provider` 는 로그인 기능을 제공하는 업체 코드이다. naver, kakao, google, facebook, 등이 들어가면 된다.
- `verification` 은 사용자 인증을 제공하는 업체 코드이다. `passlogin`, `danal` 등과 같이 들어가면 된다.


### 사용자 사진, 프로필 사진

- 사용자가 프로필 사진을 올릴 때,
  `file.userIdx` 에 회원 번호, `file.code` 에 `photoUrl` 이라고 입력하면, 해당 사진은 그 사용자의 프로필 사진이 된다.
  이 때, `file.taxonomy` 와 `file.entity` 의 값은 무시된다. 즉 아무 값이나 들어가도 상관 없다.
  
  주의: 1.0.x 에서는 `file.code` 가 아닌 `file.taxonomy` 에 `photoUrl` 이라고 저장했다.
  회원 사진을 사진을 업로드 할 때나 변경 할 때, `file.code` 값이 `photoUrl` 인 것을 사용하면 된다.

  회원 정보를 클라이언트로 전달 할 때, `photoIdx` 에 그 `file.idx` 가 전달된다.
  사용자 프로필 사진을 삭제할 때, `file.code = 'photoUrl' AND file.userIdx='사용자번호'` 조건에 맞는 사진을 삭제 할 수 있다.
  물론 `file.idx=photoIdx` 인 것을 삭제해도 된다.

- `users.photoUrl` 은 사용자 테이블에 저장된다.
  참고, 버전 1.x 에서는 meta 에 저장되었다.
  주의, 사용자가 프로필 사진을 업로드하면 그 사진이 업로드 되고, 프로필 사진 정보가 `files` 테이블에 기록된다.
  이 때, `users.photoUrl` 의 값은 무시된다.
  즉, 프로필 사진을 업로드했으면, `users.photoUrl` 은 무시되어야 하는 것이다.
  그러면 이 `users.photoUrl` 은 어떨때 사용될까?
  예를 들어 카카오톡 로그인을 하는 경우, 카카오톡 프로필 사진을 `users.photoUrl` 에 저장하는 것이다.
  참고로, 카톡 프로필 사진을 https 로 가져올 수 있다.
  


## wc_posts, 게시판 테이블, posts 테이블, posts table

- `post.model.php` 의 주석을 잘 보고 이해를 하면 좋다.

- `userIdx` 글 쓴이 idx.
- `otherUserIdx` 에는 글을 받는 사람의 idx 가 들어간다.
  예를 들어, 쪽지나 메일을 전송 할 때, 게시판 테이블을 활용하게되는데, 이 때, 받는이가 `otherUserIdx` 에 저장된다.
  중요한 점은, 이 때, 글을 수정 할 수 없다. Entity 로직에서 에러가 발생한다.
  삭제는 오직, 받는이 `otherUserIdx` 만 할 수 있다. 글 쓴이가 하려면, Entity 로직에서 에러가 발생한다.
  글 읽기는 양쪽 모두 가능하다. 주의: 이 부분은 Entity 로직에서 처리가 안되고, 위젯에서 구현해야 한다.

- `relationIdx` 는 현재 글이 어느 것(또는 다른 taxonomy 의 entity)과 연결되어져 있는지 표시 할 때 사용한다.
  예를 들면, 쇼핑몰에서 상품에 대한 후기는 코멘트로 남기고, 후기는 별도의 inquiry 게시판에 남기고자 한다.
  즉, 상품 A 에 대한 문의는 inquiry 게시판에 모두 기록된다.
  참고, 일반적인 문의는 채팅방 형식으로 해도 좋다. 1:1 문의는 채팅방이 적당하나, 공개를 할 수 없다. 즉, 공개 문의를 할 수 없다.
  참고, 쇼핑몰 상품 A 에 대한 후기는 코멘트로 남기는 것이 좋다.
  참고, 문의가 상품 별로 공개 문의 또는 사용자 선택에 의해서 비밀 문의로 되어져야 한다면, 별도의 게시판에 문의를 작성해야한다.
  이 때, (문의 게시판에 작성된) 문의가 어느 (쇼핑몰)상품의 것과 연관되어져 있는지를 relationIdx 로 표시 할 수 있다.
  즉, 이 때는 relationIdx 는 쇼핑몰 상품 번호가 되는 것이다.

  이 처럼 `relationIdx` 는 글과 글의 연결성을 표시하는 데에 사용되며, 여러 가지 방식으로 활용 할 수 있다.

- `private` 은 현재 글이 비밀글인지 아닌지를 'Y' 또는 공백으로 표시한다.
  주의: `private` 일 때에는 글 제목과 내용을 `privateTitle` 과 `privateContent` 로 저장한다. 그래서 검색에서 완전 배제를 한다.
  참고로 글 작성시, `private=Y` 로 전달하면, taxonomy 에서 title 과 content 를 자동으로 `private_title` 과 `privateContent`에 저장한다.
  검색을 할 때, private 이 아닌 글을 검색하고자 한다면, 공백인 것을 검색하면 된다.

- 'Y' 는 찬성(또는 like) 수
- 'N' 은 반대(또는 dislke) 수

- `Ymd` 는 글을 쓴 시점의 날짜(YYYYMMDD)의 값이 자동으로 들어간다.

- `noOfComments` 는 각 게시글의 코멘트 수를 표시한다. 게시판에서 코멘트 많은 순서로 글을 추출 하고자 할 때 사용 가능하다.
  참고로, 게시판 글 코멘트 삭제 기능은 없다. 삭제를 하지 못하고, 삭제됨 표시만 하는 것이다. 따라서, 코멘트 수는 증가만 하고, 감소를 하지 않는다.
  - 각 게시판 별 글 수, 코멘트 수가 필요한 경우는 count(*) 로 해서 처리를 한다.


- `code` 는 게시글에 부여되는 특별한 코드이고, 그 코드를 바탕으로 글을 추출 할 수 있다.
- `report` 는 신고된 회 수를 저장한다. 신고가 될 때마다 1씩 증가한다.

- `createdAt` 글이 작성된 시간 stamp. 처음 1회만 저장.
- `updatedAt` 글이 수정된 시간 stamp. 자주 업데이트 될 수 있음.
- `readAt` 글이 읽혀진 시간 stamp
- `deletedAt` 글이 삭제된 시간 stamp. 글이 삭제된 시간.
- `beginAt` 글이 시작되는 시간 stamp. 예를 들어, 해당 글이 언제 부터 보여져야 할 지, 또는 광고 프로그램에서, 광고가 언제 부터 시작되어야 할지
- `endAt` 글이 끝나는 시간 stamp. 글이 언제 부터 안보여져야 할 지. 광고 배너가 언제 끝나는 지 등.
  참고, beginAt 과 endAt 에 숫자 값이 입력되면 그대로 저장을 하지만, 문자열 값으로 입력되면, 날짜 문자열로 인식하여 자동으로 stamp 로 변환해서 저장한다.
  문자 날짜 값은 `input type='date'` 에서 사용하는 형식인 `YYYY-MM-DD` 로 표현되어야 한다. 예) 2021-05-26
  
- `beginDate` 과 `endDate` 은 `YYYY-MM-DD` 의 값을 가지는 데, DB 에 저장 할 때에는 `beginAt` 과 `endAt` 에 stamp 로 기록된다.
  즉, `beginDate` 과 `endDate` 은 필드에 존재하지는 않지만, 그리고 meta 속성으로도 저장되지 않지만,
  저장 할 때, `beginDate` 과 `endDate` 에 `YYYY-MM-DD` 로 저장 할 수 있고, 글을 읽을 때에도 이 값이 들어가 있다.


- 참고, 글이 삭제되면, 실제 레코드 지우지 않고,
  title, privateTitle, content, privateContent 만 빈 문자열로 저장한다.
  즉, 글의 작성자, 첨부 파일이나 코멘트 등은 그대로 살아있다.

- 'files' 필드는 글에 등록된 파일 들의 idx 를 콤마로 분리해서 저장한다. 예) "123,456"
  하지만, 글을 읽을 때에는 'files' 필드를 참조하지 않고, wc_files 의 entity 를 보고, 해당 글에 연결된 모든 파일을 가져온다.
  다만, 글 검색을 할 때, 'files' 필드에 값이 있으면 첨부 파일/사진이 있는 것으로 간주하여, 사진이 있는 파일만 가져오게 할 수 있다.

- `listOrder` - 코멘트의 목록 순서는 parentIdx 를 바탕으로하는 재귀 함수를 통해서 정렬을 한다.
  그래서 코멘트 정렬에서 listOrder 가 사용되지는 않지만, 공지 사항 목록 우선 순위나 배너 표시 우선 순위 등 여러가지 상황에서 활용을 할 수 있다.

- `reminder` - 'Y' 이면 공지사항이라는 뜻이며, 'Y' 가 아니면(빈 값 또는 N)이면 일반 글이라는 뜻이다.

- `noOfViews` 는 조회수이다. 앱이나 SPA 에서는 라우트를 통해서 업데이트 해야하며, 검색 로봇 조회나, 이중 업데이트를 방지해야 한다.




## files, 파일 테이블


- taxonomy, entity 는 예를 들어, posts taxonomy 의 어떤 글 번호에 연결이 되었는지 또는 users taxonomy 의 어떤 사용자와 연결이 되었는지 나타낸다.
- code 는 파일의 코드 값으로 예를 들어, taxonomy=users AND entity=사용자번호 AND code=profilePhoto 와 같이 업로드된 파일의 특성을 나타낼 때 사용 할 수 있다.

- 파일이 꼭 게시판에 등록 될 필요는 없다.
  - taxonomy, entity 만 잘 활용해서 하면 된다.
  - 예를 들어, 사진이 특정 카테고리에 적용이 되어야 하는 경우, 특히, 서브 사이트나 카페를 만들 때, 하나의 카테고리마다 사진이 여러개 등록되어야하는 경우,
    taxonomy=cafe
    entity=cafe.idx
    code=logo 또는 code=icon 등으로 여러개의 사진/파일을 연결 할 수 있다.


## 카테고리 테이블. Category table

- userIdx 는 게시판 관리자이다. 카페인 경우, 카페 주인이 된다.
- domain 은 게시판의 도메인이다. 홈페이지 도메인일 수도 있고, 그냥 그룹일 수도 있다. 카페의 경우, 카페 도메인이 된다.
- countryCode 는 국가 코드이다. 해당 게시판(또는 카페가) 어느 국가에 속해 있는지 표시를 하는 것이다.

- subcategories - A string with many subcategories separated by comma(,).
  For instance, "apple,banana,cherry"
  This subcategories may be seen on post list or post edit and each post can have one subcategory at `posts.subcategory`.

  - `subcategoriesArray` - subcategories 로 부터 콤마로 구분된 카테고리를 분리하여 배열에 저장하고 클라이언트로 전달한다.
    참고로, 가능한 원래 record field 이름은 유지하고, 가공한 정보를 새로운 이름으로 해서 클라이어늩로 전달한다.
    단, `wc_posts.files` 의 경우는 예외이다.

- postCreateLimit - users who has less points than this cannot create post
  For instance, this value is 1000 and user has 999. Then the user cannot create post.
- commentCreateLimit - users who has less points than this cannot create comment
- readLimit - users who has less points than this cannot create comment
  - @attention When a user creates a post, it reads the post internally.
    Which means, for post creating, user will read the post and if user has less point of 'readLimit' when creating, it will fail.
  - @attention, readLimit is only for post reading, not for comment reading.

- banCreateOnLimit - User cannot create post/comment if the user reaches the limit.

- createPost - is the Points to be given to the author on post creation. It can be minus value like -100.
- deletePost - is the Points to be given to the author on post deletion. It can be minus value like -100.
- createComment - is the Points to be given to the author on comment creation. It can be minus value like -100.
- deleteComment - is the Points to be given to the author on comment deletion. It can be minus value like -100.


- createHourLimit - Create limitation for hours.
- createHourLimitCount - How many can the user create post/comment within the `createHourLimit` hour.
- createDailyLimitCount - How many can the user create post/comment in a day.


## User Activity

- All actions(or events) should be recorded using `userActivity()->recordAction()`.

- User activities are recorded in the `user_activities`.
  The actions may be user register, login, post create, delete, like, dislike, and more.

  - When an entity of `posts` is created, taxonomy is `posts`, and the entity is the idx of the record, and categoryIdx is the category.idx.
    An entity of `posts` may be a post, a comment, or any record in `posts` table.

  - `fromUserIdx` is the user who trigger the action.
  - `toUserIdx` is the user who takes the benefit.
  - If the values of `fromUserIdx` and `toUserIdx` are same, then, `fromUserIdx` may be 0. Like user register, login, post create, delete, comment create, delete.
  - Note that, when a user like or dislike on his own post or comment, there will be no point history.

- For like and dislike, the history is saved under `post_vote_histories` but that has no information about who liked who.

### Vote activity logic

- Admin can set global vote point on point settings menu.
- Admin can set daily limit and hourly limit on global settings.
  - If it is not set, then there is no limit.
  - If it is set, the point will be changed only until it reaches the limit and user can still votes, but point will not be changed.


### How to record a user activity


- add the name of activity in `user_activity.defines.php`

- add activity name as a static member variable in Actions class.

- add a method like 'canXxxx()' in `user_acitivity.taxonomy.php` if it needs to check the permission before the activity
  - And add it to somewhere before the activity.
  - For instance `act()->canCreatePost()`

- add a method of recording activity in `user_acitivity.taxonomy.php`.
  - And add it after the activity.
  - For instance, `act()->register()`
  - If it needs to deduct point, deduct the point in this method.

- For instance, 'UserActivityTaxonomy::canRegister()' checks if the user can register, and 'UserActivityTaxonomy::register()' method records.




## 친구 관리 테이블

- 테이블 이름: friends
- 친구 목록은 n:n 관계이다. 그래서 별도의 테이블이 존재해야한다.
- myIdx 는 나의 회원 번호
- otherIdx 는 내 친구로 등록된 (다른 사용자의) 회원 번호.
- block 은 친구 신고를 하거나, 차단하는 경우, 'Y' 의 값을 가진다. 'N' 의 값을 가지지 않으며, 기본적으로는 빈(문자열) 값이다.



# 로그인


- 참고, 카카오로그인과 네이버로그인 모두 서브 도메인은 자동으로 무한대로 사용가능하다.
- 참고, 소셜 로그인을 하는 경우, DB 의 닉네임이 빈 값이 아니면, 닉네임을 덮어쓰지 않는다. 즉, 웹/앱에서 변경 하는 경우에도, 덮어쓰지를 않는다.

## 카카오 로그인

- [ 참고, Vue.js 로 카카오 로그인 방법](https://docs.google.com/document/d/1gxYvQ3P8VA3Tg5zhVqhllBInvGzuPMPZNNOn8yUt-_Q/edit#heading=h.k5wk7f8o3t8t)

- 카카오톡을 통해서 로그인을 하는 기능으로서 웹에서 카카오 로그인에 대한 코드는 이미 준비되어져 있다.

- config.php 에서 전체 설정을 할 수 있고, theme/theme-name/config.php 에서 테마별 설정을 할 수 있다.
  - 그리고 하나의 테마에서 여러 도메인을 사용하는 경우, 도메인 별로 카카오 프로젝트를 만들 필요 없이, 최대 10 개 도메인까지 사용 가능하다.
  - 그래서, theme/theme-name/config.php 에서 설정을 하는 경우, 도메인 별 옵션 처리를 할 필요가 없다.
    - 카카오톡 프로젝트 하나로 사이트 10개, Redirect URL 도 10개 등록 가능하다.

- 개발
  - 플랫폼에서 웹을 선택하는 경우, 로그인 방식이 `Javascript` 와 `Restful Api` 두가지가 있다.
  - 공식 문서에서 `REST API로 개발하는 경우 (Redirect URL 을)필수로 설정해야 합니다.` 와 같이 나온다.
  - 즉, 카카오톡 로그인 버튼을 눌렀을 때, 자바스크립트로 새 창을 띄워서 하는 경우, 로그인 성공 콜백 함수가 나오고 원하는데로 처리를 하면 된다.
    따라서, Redirect URL 을 설정 할 필요가 없다.

- 설정
  - `JAVASCRIPT_KAKAO_CLIENT_ID` 는 자바스크립트 로그인 용 키이다.
  - `JAVASCRIPT_KAKAO_CALLBACK_URL` 는 자바스크립트로 로그인을 한 다음 이동 할 페이지이다. 자바스크립트에서 로그인을 할 때에는 프로그램적으로 원하는 곳으로 이동 할 수 있다.
    - Rest API 를 사용하지 않으므로, Redirect URL 일 필요가 없다.

- 동작
  - 아이폰에서는 로그인 후, 홈페이지로 돌아가지 않는다. 사용자가 앱으로 돌아가기 버튼을 눌러야하는 번거로 움이 있다.
  - 안드로이드폰에서는 로그인 후, 홈페이지로 돌아간다.


## 네이버 로그인

- [참고, Vue.js 로 네이버 로그인하는 방법](https://docs.google.com/document/d/19pib_xo9FFf7PfanKtUqLVuD8AhpbgNBg3sudGpilKY/edit#heading=h.jelv7iom1uk0)

- 카카오 로그인은 10개 도메인과 10개 Redirect URL 을 제공해서, 어느 정도 활용성이 높고, 또 자바스크립트로 로그인을 하는 경우는 아예 Redirect URL 이 필요 없다.

- 하지만, 네이버의 경우, 하나의 네이버 프로젝트에 최대 2개의 도메인만 사용가능하다. 또한 각 도메인당 최대 5개의 Redirect URL 만 사용 가능하다.
10개 도메인을 사용한다면, 네이버의 경우 프로젝트당 2개의 도메인이 가능하므로, 5개의 프로젝트가 필요하다.
참고로 PC 웹과 Mobile 웹 두가지 슬롯이 있는데, 거의 완벽하게 동일한 것이다. 따라서 도메인을 2개 사용하면 된다.
이 경우, 서브 도메인이 많다면, Redirect URL 을 메인으로 두고, state 코드를 넘겨, 해당 서브도메인으로 돌아 올 수 있도록 해야 한다.

그래서, 여러 도메인을 사용하는 경우, 네이버 API KEY 가 도메인 별로 다를 수 있다. 따라서 config.php 에서 도메인 별로 옵션 처리가 되어야 할 수 있다.




# 관리자 페이지, Admin Page

- Starting Matrix(version 2), PHP does not render web pages directly to web browser. So, it needs a client-end to
  display admin site.
  The default website and its admin page is built-in Vue.js.

- Most of the admin page and its functionalities comes from Vue.js components. The components are inside
  `x-vue/components/admin` folder.
  And by simply adding admin routes in the `routes/index.ts` in Vue.js app, the Vue.js app can use admin pages.
  
```ts
import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Home from "../views/Home.vue";

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/admin",
    name: "Admin",
    component: () => import("@/x-vue/components/admin/Admin.vue"),
    children: [
      {
        path: "",
        name: "AdminUserList",
        component: () => import("@/x-vue/components/admin/AdminUserList.vue"),
      },
      {
        path: "user",
        name: "AdminUserList",
        component: () => import("@/x-vue/components/admin/AdminUserList.vue"),
      },
      {
        path: "category",
        name: "AdminCategoryList",
        component: () =>
                import("@/x-vue/components/admin/AdminCategoryList.vue"),
      },
      {
        path: "post",
        name: "AdminPostList",
        component: () => import("@/x-vue/components/admin/AdminPostList.vue"),
      },
      {
        path: "file",
        name: "AdminFileList",
        component: () => import("@/x-vue/components/admin/AdminFileList.vue"),
      },
      {
        path: "setting",
        name: "AdminSetting",
        component: () => import("@/x-vue/components/admin/AdminSetting.vue"),
      },
      {
        path: "messaging",
        name: "AdminPushNotification",
        component: () =>
                import("@/x-vue/components/admin/AdminPushNotification.vue"),
      },
    ],
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
```

## 관리자 설정

### 관리자 지정

- 관리자는 콤마로 분리하여 여러개의 메일 주소를 입력 할 수 있다.

## 게시판 관리

### 글 생성 위젯 옵션

글 생성 위젯 옵션에는 PHP INI 방식으로 내용을 입력 할 수 있다. `2차원 배열` 까지 정보를 입력 할 수 있다.

특히, 사진을 코드별로 업로드하는 위젯에서 `[upload-by-code]` 를 php.ini 방식의 입력을 통해서 여러개 사진을 업로드 할 수 있다.



# Restful API Protocol

- See `rest-client.http` for working examples

## App

### app.version

### app.time

```http request
https://main.philov.com/?route=app.time
```
```json
{"response":{"time":"Fri, 11 Jun 2021 15:11:07 +0900"},"request":{"route":"app.time"}}
```


# 쪽지 기능, Message Functionality

- 쪽지 기능을 이곳에 기록된 것 처럼 게시판을 통해서 구현 해도 된다.
  또 다른 방법으로는 클라이언트의 채팅 기능을 통해서 1:1 채팅 기능을 쪽지 기능으로 구현을 해도 된다.
  - 다만, 게시판 형태로 작성을 하면 내용 검색을 할 수 있지만, 1:1 채팅 기능을 통해서 구현하면 내용 검색이 안되는 단점이 있다.
    그래도 1:1 채팅 기능을 쪽지 기능으로 구현하는 것을 권장합니다.
  
- 아래의 내용은 버전 1.x 에서 위젯을 주로 활용하던 방법이다. 버전 2.x 에서는 위젯을 거의 사용하지 않으므로, 버전 2.x 에서는 맞지 않다.
  - 다만, 버전 2.x 에서는 아래의 로직을 클라이언트에서 구현하면 된다.

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


# 게시판, 글, 코멘트

## 게시글 목록 또는 검색. Post list parameters.

- 게시판 목록에서 검색에 사용되는

- `categoryId` 는 글 카테고리. 카테고리 번호를 숫자로 입력해도 된다.

- `subcategory` is the subcategory.

- `countryCode`
  국가별 글 목록을 할 때 사용한다.
  국가 코드의 경우, hook 을 통해서 수정 할 수 있다.
  예를 들어, 특정 theme 에서는 무조건 특정 국가의 글만 목록하고자 할 때, 사용 할 수 있다. 예를 들면 소너브에서 도메인/카페 별로 특정 국가의 글만 목록하고자 할 때 사용한다.


- `sc`
  `sc` holds the choice of subcategory when user is navigating.
  Whenever user choose a subcategory, `sc` will be set with the subcateogry.
  and pass the sc all the way on the navigation including creating and commenting, next page, etc..
  And when the app needs to show the list (after create, edit, or clicking list button), show the subcategory of `sc`.
  
  - For instance, User clicked `beta` subcategory under qna forum. The `sc` is `beta`.
    And the user goes to next page, then, creates a post and a comments,
    And when the user clicked `back to list` button, then the app should show `beta` subcategory under qna forum.
      So, the app needs to pass `sc` through all the navigation.
  - Another instance is that, the user goes to qna forum. The `sc` is emtpy. and you don't have to pass `sc` on the navigation.
    and edit a post that has `beta` category.
    after edit, the app should show qpona forum list not the `beta` subcategory list because `sc` is empty.
    
  - ~~참고. `nsub` 관련된 내용은 버전 1.x 에서 사용되는 것으로 더 이상 사용하지 않는다.~~
  - ~~사용자가 전체 카테고리에서 글 생성할 때, 'abc' 카테고리를 선택한다면, 그 글은 'abc' 카테고리 글이다.
    '전체카테고리'와 'abc' 카테고리 중 어떤 카테고리를 보여주어야 할까?
    정답은 전체 카테고리이다.
    글 쓰기 FORM 을 열 때, HTTP PARAM 으로 subcategory 값이 전달되지 않은 경우, nsub=all 로 전송을 한다.
    사용자가 전체 카테고리 목록에서, 특정 글을 수정 할 때, 그 글의 카테고리가 'abc' 라면, 글 작성 후, 전체 카테고리를 보여줘야 할까? 'abc' 카테고리만
    보여줘야 할까?
    정답은 전체 카테고리이다.
    글 쓰기 FORM 을 열 때, HTTP PARAM 으로 subcategory 값이 전달되지 않은 경우, nsub=all 로 전송을 한다.
    사용자가 'abc' 카테고리에서 글을 생성하면, 'abc' 카테고리를 보여줘야 한다.
    사용자가 'abc' 카테고리에서 글을 하나 수정할 때, 그 글의 카테고리를 'def' 로 바꾸면, 'abc' 와 'def' 중 어떤 카테고리를 보여줘야 할까?
    정답은 def 카테고리이다.
    요약을 하면, `nsub` 는 글 생성, 수정, 삭제를 할 때, 그 직전의 페이지 목록이 서브카테고리가 아닌 경우, FORM 전송 후 전체 카테고리로 보여주기 위한 것이다.~~

- `searchKey` 검색어
  - searchKey 에 값이 들어오면, `(title LIKE '%searchKey%' OR content LIKE '%searchKey%')` 와 같은 형태로 검색을 한다.
    이 때, 검색어는 `search_keys` 테이블에 저장된다.

- `userIdx` 는 사용자 번호
  - 그 사용자가 쓴 글을 검색한다.
    예) `https://local.itsuda50.com/?p=forum.post.list&categoryId=qna&userIdx=2&searchKey=hello`

- `categoryId` 는 글 카테고리 아이디(또는 번호)

- `subcategory` 해당 카테고리의 서브 카테고리의 글만 목록(또는 검색)한다.

- 클라이언트에서 

- For listing posts under a category, it requires `category.idx`. Whether the client is using SQL or prepared params,
  `category.idx` must be used, instead of `category.id`.
  - Client app should load the forum configuration at startup and cache for the next boot. So, they can use `category.idx`.



# 테스트, Unit Testing

- 처음 CenterX 를 시작 할 때, PHPUnit 이 PHP8 을 지원하지 않아, 직접 테스트 환경을 개발하였다.
  - 이 후, 굳이 PHPUnit 의 필요성을 느끼지 못하여 계속해서 직접 개발한 테스트 환경을 사용하고 있다.

- 참고, 테스트를 하면, test.php 에서 `boot.php` 를 실행한다. 하지만, `controller/control.php`는 실행하지 않는다.
  - 다만, test.php 의 `request()` 함수가 Nginx 를 통한 접속을 하므로, 그 때에는 Matrix 의 index.php 가 실행되어야 한다.

- 아래와 같이 실행하면, `tests/*.test.php` PHP 스크립트(파일)을 실행한다.
  - php container 이름과 centerx 설치 폴더를 잘 지정하면 된다.

```shell
docker exec [php_container_name] php [centerx_folder_name]/tests/test.php
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


# PWA, Service Worker



When, manifiest.json has changed by the server,
do one of the following to test if the changed json applies


- open the manifest.json from browser, then, Unregister the service worker, then refresh to to see updated manifest.json



- Do one of the following, to get the changed manifest.json and cache it into service worker cache.

- Clear the site data, then, close browser, then open browser, then see the updated manifest.json
- Or visit with new browser


For the real service,

- When manifeset.json is changed, only new users will get the new manifest.json
  So, changing it by admin page will not affect to users who already visited the site.

- Or rebuild the Vue.js WITH UPDATED manfiest.json and deploy, then all users will get new manifest.json
  The developer must change manifest.json or the cache id may not change and new manifest.json modified by server may not apply.




## Service worker errors

- The error message below explains that the icon src url in `manifest.json` is wrong and not downloadable.

```text
Error while trying to use the following icon from the Manifest: https://wwnymous.png/ (Download error or resource isn't a valid image)
```

- The error message below explains that the icon size in `manifest.json` is different from the actual image. 아래와 같은 에러는 manifest.json icon src url 의 사이즈가 잘못된 경우이다.

```text
Error while trying to use the following icon from the Manifest: https://www.ontue.com/assets/img/anonymous.png (Resource size is not correct - typo in the Manifest?)
```



# 문제점

- `sessionId` 의 암호화 강화.
  - md5 의 약점이 서로 다른 문자열이 동일한 md5 문자열이 될 수 있다. 예) 'apple' 의 md5 가 abcde123 인데, 'banana' 의 md5 도 abcde123 이 될
    수 있다. 그래서 비밀번호를 아무거나 막 입력 했을 때, 실제 비밀번호가 아닌데로 불구하고, 동일한 md5 결과가 나와서, 로그인이 될 수 있다.
    - 해결 책
      - md5 쌍을 2개로 만들 수 있다. idx, email, password, createdAt 을 하나의 쌍. name, nickname, updatedAt 을 다른 쌍으로 해서
        sessionId 를 만든다.
      - 비밀번호가 틀리면, 시간을 길게 두어서 brutal 공격을 막는다.
      - md5 대신, 다른 암호화 방식을 쓴다.