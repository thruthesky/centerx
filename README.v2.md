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

## 버전 3 - TODO 목록

- `centerx` 라는 명칭을 완전히 제거.
- PHP 에서 화면에 직접 렌더링하는 부분은 `view/admin` 빼고는 모두 제거.
  - `live-reload` 등 관련된 사항 재 정립
- `widgets` 폴더 제거
- Git repo 를 `https://github.com/withcenter/matrix` 로 이동.
- 버전 3에서는 오직 백엔드용으로만 사용
  - 모든 자바스크립트, CSS, 위젯 등과 관련된 파일을 삭제.
  - 웹 브라우저 쿠키 관련 코드 삭제
  - 기타 웹 브라우저에 랜더링을 하는 관련된 모든 코드를 제거.
- 설정을 config.php 와 view/view-name/view-name.config.php 로 하는데, 번거롭다.
  - 설정 클래스인 config 클래스를 둔다. 이것은 config model 과는 다른 것이다.
  - 기존에는 설정을 const 또는 define 으로 관리를 해서, config.php 에서만 설정하고
    프로그램 실행 중간에서 설정 또는 변경 할 수 없었다.
    특히, unit test 를 할 때 문제가 되고 있으며, 또 관리도 어렵다.
    그래서 etc/core/config.php 에 설정 파일을 둔다. 이것은 버전 2 에서 이미 시작된 것이다.

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




## 호스트(도메인)와 view 의 연결, Host setting

- When you develop, you may need to test with real domain.
  - To do so, you may add a fake domain like `local.sonub.com` in `/etc/hosts` file.
  - Then, when you access `local.sonub.com` it goes to your local development computer.

ex) /etc/hosts
```text
127.0.0.1       local.sonub.com
```

- Then, get SSL. You may get it from `certbot`.

- Then, set the domain and SSL in `docker/etc/nginx.conf`

- Then, set the domain and with the view folder in `config.php`.

ex) config.php
```php
define('DOMAIN_THEMES', [
    '_' => 'default',
    '127.0.0.1' => 'default',
    'localhost' => 'sonub',
    'local.sonub' => 'sonub',
    '169.254.115.59' => 'sonub', // JaeHo Song's Emulator Access Point to Host OS.
    'www_docker_nginx' => 'sonub', // Docker container name
]);
```

- The key of `DOMAIN_THEMES` is the part of domain. And the value is the view folder name.

- See the `_`. It means the same of `_` in Nginx configuration. It matches all domains.
  Running tests or running PHP script from terminal, it may not have a host. So, it matches on `_`.

- See the `www_docker_nginx`. It is a container name which may by used from directly PHP to nginx connection.

- Simulator will work naturally with `/etc/hosts`.
  - But, emulators and real phone are not working with `/etc/hosts`.
  - Then, you can use IP address to connect to local development computer.

- To check if Emulator or Phones can connect to the local development computer,
  - Open Emulator or Phones, and access with IP address like `http://169.254.115.59/`
  - If it works, then you can use it. Or you should find right IP address for your local computer.
    - If you are using Mac, `ifconfig | grep inet` command may help.

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


- 공개되지 말아야하는 정보는 `keys` 폴더에 저장하면 된다. 이 폴더는 .gitignore 에 등록되어져 있어, git repo 에 추가되지 않는다.
  - 각 view-name 폴더에 keys 폴더를 두고 그 아래에 `db.config.php` 파일을 두어, DB 설정을 그곳에 할 수 있다.
    만약, `view-name/keys/db.config.php` 가 존재하지 않으면 `etc/keys/db.config.php` 를 읽는다. 그리고 etc 폴더에도 db.config.php 가
    없으면 루트 폴더의 config.php 에 있는 설정을 사용한다.
  - 초기 설정을 하는 과정에서 `db.config.php` 외에 `private.config.php` 도 읽어 들인다.
    먼저 `view/view-name/keys/private.config.php` 가 있으면 읽어 들이고 없으면 `etc/keys/private.config.php` 를 읽어 들인다.
    etc 폴더 밑에도 `private.config.php` 가 없으면 그냥 루트 폴더의 `config.php` 의 설정을 사용한다.

## Live reload

아래의 live reload 항목 참고


# 코딩 가이드라인, 스타일 가이드

- 권한 체크를 하지 않아서, controller 또는 클라이언트에게 곧 바로 노출되면 위함한 함수는 언더바(_)로 시작한다.
  예를 들면, 사용자 포인트를 변경 할 수 있는 user()->_setPoint() 함수와 같은 것이다.
  이런 함수는 프로그램 내부적으로만 사용해야 한다.

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


- config.php 의 설정에 따라, 클라이언트에서 `MATRIX_API_KEY` 설정을 해야하는 서버가 있으니 주의해야 한다.

## SEO, Vue.js 와 SEO

- SPA 의 특징으로 인해 SEO 가 어렵다. Nuxt.js 등으로 SSR 을 해도 SEO 가 Native 하지(직관적인지) 못하고, 또한 모든 팀원(개발자)들이 Nuxt.js 를
  잘 하는 것은 아니다. Nuxt.js 와 같은 것은 개발 환경 설정 및 빌드가 번거롭게 느껴 질 수 있다.
  
- Vue.js 로 SPA 를 해도, PHP 로 Native SEO 를 할 수 있다.

- Vue.js 빌드를 하면 결과물을 dist 폴더에 저장하는데, 이를 Matrix 의 view 폴더로 지정한다. 예) `/docker/home/matrix/view/default`.
  즉, 빌드하면 바로 `matrix` 의 웹 폴더에 저장되는 것이다.
  
- 중요한 것은 Vue.js 의 public/index.html 의 최 상단, 그리고 최 하단에 검색 엔진 로봇이 게시판과 사이트 맵을 긁어 갈 수 있도록 링크를 걸어주면 된다.
  즉, index.html 에 vue.js 앱을 부팅하지만, 맨 위, 아래에 SEO 를 위한 링크를 걸어두고, 그 링크를 클릭하면, PHP 로 된, 글 모음을 계속 보여주면 된다.
  그리고 그 링크를 클릭해서 접속하면, 웹 브라우저이면, Vue.js 앱을 부팅하고, 아니면, 계속해서 PHP 로 된 글을 보여준다.
  예)
```html
<header>
  <a href="...">자유게시판</a>
  <a href="...">사이트맵</a>
</header>
<div id="app"></div>
<footer>
  <a href="...">기타 SEO 를 위한 링크.</a>
</footer>
```

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


## Vue.js Build, 배포


### 루트 경로 이용하는 경우, 간단한 방법

- 루트 경로를 이용하는 경우,
  - 예를 들면, `http://local.flutterkorea.com/login` 와 같이 최 상위 경로 `/` 에 Vue.js 앱을 서비스하는 경우,
    vue.js 에서 빌드 할 때, `dist` 폴더를 matrix 의 `view/view-name` 폴더로 지정해서, index.html 이 `view/view-name/index.html` 와
    같이 저장되도록 한다.
  - 그리고 nginx 에서 해당 폴더의 index.html 을 바로 불러들이면 된다. 즉, PHP 랑 전혀 상관이 없는 것이다.
    다만, 랜딩 페이지가 루트 `/` 가 아닐 수 있으니, try files 로 모든 하위 경로로 접속하면, 최 상위 index.html 을 로드하도록 한다.

```apacheconf
server {
    server_name  local.flutterkorea.com;
    listen       80;
    root /docker/home/centerx/view/flutterkorea;
    index index.html;
    location / {
        try_files $uri $uri/ /index.html?$args;
    }
}
```
- 하지만, Vue.js 에서 Restful API 를 실행하게 하려면,
  - vue.js 에서 `/public/api.php` 와 같이 dist 폴더에 api.php 를 미리 저장해 놓고, 빌드하면 dist 폴더에 저장되도록 한다.
  - 그리고 nginx 에서 `/api.php` 와 같은 backend api url 경로의 PHP 를 할 수 있도록 해야한다.
  - 예를 들면, 아래와 같이 하면 된다.

```apacheconf
server {
    server_name  local.flutterkorea.com;
    listen       80;
    root /docker/home/centerx/view/flutterkorea;
    index index.html;
    location / {
        try_files $uri $uri/ /index.html?$args;
    }
    location ~ \.php$ {
        fastcgi_pass   php:9000;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
    location ~* \/files\/.*\.(png|jpg|jpeg|gif)$ {
        root /docker/home/flutterkorea;
        expires max;
        add_header Access-Control-Allow-Origin *;
    }
    location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
        expires max;
        add_header Access-Control-Allow-Origin *;
    }
}
```

- 이 때, `api.php` 에 아래와 같이 저장하고, `http://local.flutterkorea.com/api.php` 와 같이 접속을 하면 된다.
```php
<?php
include '../../boot.php';
include CONTROLLER_DIR . 'api.php';
```

### 루트 경로 이용하는 경우, view config.php 를 실행해야 하는 경우

- `view/view-name/config.php` 는 루트 index.php 를 통해서 실행되어야 한다.

- 이와 같은 경우, nginx.conf 설정에서 root 를 matrix 의 루트 폴더로 지정하고,
  - vue.js 에서 빌드하면, `view/view-name` 에 결과물 저장되도록 dist 폴더를 조정하고,
  - `view/view-name/index.php` 에서 `include 'index.html';`와 같이 하면 된다.
  - 즉, vue.js 자체가 index.php 에 의해서 로드되므로, 원하는 것은 무엇이든 할 수 있는 것이다.




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
  

# Live reload



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

# Restful API, Protocol

## Api 경로

- 기본적인 Api 경로는 최상위 폴더의 `index.php` 이다.
- 하지만, 아래와 같이 다른 폴더로 변경을 할 수 있다.
  - 아래의 예제는 `/views/my-view/api.php` 로서,
    - 원하는 위치에 PHP 파일을 두고,
    - `matrix` 를 부트 한 다음,
    - `api.php` 를 통해서 api 호출을 하면 된다.
```php
<?php
include '../../boot.php';
include ROOT_DIR . 'controller/api.php';
```

## Api 참고

- API Protocol examples are written in `/etc/rest-client/rest-client.http`

- `route` is the route of the api call.
  Ex) `/?route=app.version`

- To get app version, access like below
  Ex) `/?route=app.version`


### Api live reload

- 테스트 할 때, api 자체로 live reload 해야 할 필요가 있다.

- To live reload the route on web browser,
  Run the `live-reload.js` Just add `/?route=....&reload=true`.
  And remove it from rest api client call.
  


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
  

# Boot, 부팅


## 부팅 순서, PHP 스크립트 호출 순서

- `index.php` 또는 어떤 위치의 PHP 스크립트라도 상관없다.
  시작 스크립트로서 `boot.php` 를 include 하면 된다.
    
  - `boot.php`\
    부팅 스크립트. 어느 위치의 스크립트이든 이 스크립트를 include 하면, Matrix 를 부팅하여 사용 할 수 있다.
    
    - `etc/config.php`
      시스템 설정 클래스. `Config` 클래스가 정의되며 `config()` 함수로 사용 가능하다.
      여기에 기본 값이 들어간다.

    - `config.php`\
      글로벌 설정. 이 스크립트를 통해서 여러가지 설정을 할 수 있다.]
      특히, `config()` 함수를 통해서 `Config` 클래스에 기본 설정된 값을 변경 할 수 있다.\
      버전 2.x 초기에 `config.php` 에 주로 설정을 보관하는 데, 이 설정이 대부분 `etc/config.php` 로 이동한다.
      
      - `db.config.php`
        
      - `private.config.php`
        
      - `view/view-name/config.php`\
        접속 도메인을 바탕으로 추가 설정을 각 `view/view-name/config.php` 에서 할 수 있다.\
        여기에 설정하는 추가 설정은 Restful API 를 호출 할 때에도 적용되는데 해당 theme 으로 접속 하도록 domain 지정을 해야 한다.
        
    
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

- 각 view 폴더에 keys 폴더는 git repo 에 추가되지 않는 private folder 이다.
  - 기본적으로 .gitginore 에 `keys/` 가 저장되어져 있는데, 글로벌 git ignore 에도 추가하도록 한다.



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

- 에러 문자열 코드 뒤에 `---` 를 표시하고 그 뒤에 추가적인 에러 설명 메시지가 들어 갈 수 있다.
  예) `error_user_not_found---thruthesky@gggg.com`
  
- 에러 관련 함수 중,
  - `error()` 는 에러 결과를 JSON 으로 출력한다.
  - `err()` 는 에러 코드와 에러 설명 메시지를 합친다.
  - `e()` 는 에러 객체로 `e()->user_not_found` 와 같이 에러를 호출 할 수 있다.
  위 함수 들 중에서 이름이 긴 순서로 포함을 한다. 짧은 함수 `e()` 가 에러 객체 또는 에러 메시지를 담고,
    `err()` 이 에러를 더하고, `error()` 이 에러를 출력한다.
    사실 `err()` 는 `add_error_string` 의 약자이다.
    예) 
    `error(err(e()->controller_file_not_found, $filePath));`

# 설정, Config, Meta Config

- 설정에는 여러가지가 있다.
  - PHP 부팅 스크립트 소스 코드에서 하는 config 는 system configuration 이라고 하며,
  - 앱의 관리를 위해서 meta 테이블에 정하는 config 는 meta configuration 이라고 한다.
    - meta configuration 에는 일반 사용자가 수정/관리 할 수 있는 meta 값들과
    - 관리자만 수정/관리 할 수 있는 admin meta 가 있다.
  
## MetaConfig 클래스

- 주의 할 점은 meta 에 taxonomy 가 `config` 이면, 설정이라는 뜻인데 실제 `config` 테이블은 존재하지 않는 가장의 taxonomy 이다.
  따라서, `config` 가 taxonomy 이지만, entity 로는 사용할 수 없다. 그래서 `entity()->create()` 와 같이 할 수 없다.
 
- 다만, MetaConfig 클래스를 통해서 meta 를 적절히 관리하고 있다. 

## System configuration

- `/etc/config.php` 에 기본 설정이 모두 저장된다. 또한 필요하면 추가적인 설정을 이곳에 새로운 변수로 추가하면 된다.
- 이 클래스는 직접 객체를 생성해서는 안되고, 반드시 `config()` 라는 함수로 참조해야 한다. 그래야 싱글톤으로 사용 할 수 있다.


## 일반 사용자 설정 또는 앱의 일반적인 설정

- meta 클래스에 들어가는 값을 말하며,
- 이 때 taxonomy 는 `config` 이고, entity 가 0 인 것은 모두 일반 설정이다.
- 만약, taxonomy 가 `config` 가 아니라면, entity 가 0 이든 아니든 상관 없이, 특정 글, 카테고리, 사용자, 파일 등에
  존속되는 메타 값 일 수 있다.

- `metaConfig()` 함수를 통해서 손쉽게 CRUD 할 수 있다.
  
## 관리자 설정

- 관리자 설정하는 값이 meta 테이블에 저장될 수 있는데, 이 때에는 taxonomy 가 `config` 이고 `entity` 는 반드시 1 의 값을 가진다.
  - taxonomy=`config` 와 entity=`1` 의 값을 가진 meta 는 오직 관리자만 생성, 수정, 삭제를 할 수 있다.

- `adminSettings()` 함수를 통해서 손쉽게 CRUD 할 수 있다.



## How to set admin to manage the site.

- Root admin, who has the full power, can be set to ADMIN_EMAIL constant in `config.php`.
  After setting the email in config.php, you may regsiter(or login) with the email.


```php
adminSettings()->set('admin', 'thruthesky@gmail.com');
d(adminSettings()->get('admin'));
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




## 관리자 설정

- 관리자 설정이란,
  - 관리자 권한이 있는 사용자만 설정 할 수 있는 것으로,
  - 데이터베이스의 wc_meta 테이블의 taxonomy 가 `config`, entity 가 1 로 저장되는 키/값들이다.
  
- 관리자 설정과 관련된 라우트는 `app.setConfig`, `app.getConfig`, `app.deleteConfig`, `app.settings` 등이 있다.
  - `app.setConfig`, `app.deleteConfig` 라우트는 오직 관리자만 이용 할 수 있는 라우트로, 클라이언트에서 이 라우트를 이용하기 위해서는 관리자 권한이 있어야 한다.


- 참고로, 클라이언트 앱이 처음 시작 할 때, `app.settings` 라우트를 통해서, 관리자 설정을 클라이언트로 다운로드하는 것을 권장한다.
  모든 관리자 설정을 `app.settings` 로 가져 올 수 있다.
  
- 관리자 설정은 vue.js 홈페이지로 개발되어져 있으며, 서브 모듈 `x-vue/components/admin/setting/AdminSettings.vue` 에 의해서 코드가 관리된다.
  - 모든 관리자 설정은 옵션이다.
  - 예를 들어, 수퍼 관리자는 config.php 의 `ADMIN_EMAIL` 에 기록되는데, 관리자를 더 추가하고 싶다면,
    관리자 설정 페이지에서 키를 `admins` 으로 하고, 값 콤마로 분리한 여러개의 메일 주소를 입력하면 된다. 그러면 그 메일 주소의 사용자들이 관리자가 된다.
    즉, `admins` 키를 생성하지 않으면, 그냥 추가로 관리자를 두지 않는 것이도, `admins` 키를 생성하면 추가로 관리자를 두는 것이다.
    이 처럼, 옵션으로 원하면 `admins` 키를 생성하고, 원하지 않으면 생성하지 않으면 된다.
    
### 관리자 옵션 키

- 관리자 옵션 키는 미리 정해진 것이 있고, 각 클라이언트마다 필요로 하는 키들이 있을 수 있다.
  이러한 키 들을 직접 생성해서, 클라언트에서 사용 할 수 있다.

- 미리 정해진 키는 다음과 같다.
  키는 camelCase 를 쓰고, 값은 참/거짓을 표현 할 때, 참은 Y, 거짓은 N 을 입력한다. 모든 내용은 textarea 로 저장한다.
  - `admins` - 콤마로 구분 하여, 추가 관리자 기록
  - `searchCategories` - 검색 가능한 카테고리 제한. 값이 지정되지 않으면 전체 검색.
  - `termsAndConditions` - 가입 약관. 이용 약관.
  - `privacyPolicy` - 개인 정보 보호 정책.
  - `enableLike` - 좋아요 기능 활성화.
  - `enableDislike` - 싫어요 기능 활성화.
    사용 예) 매우 중요한 설정의 경우, 그 설정이 관리자 설정에 나타나지 않게 할 수 있다. 즉, 관리자 설정에 나타나지 않으므로, 삭제도 할 수 없다.
  - `like` - 추천 받는 사람의 포인트 증가. 0 또는 양의 정수라야 한다.
  - `dislike` - 비 추천 받는 살마의 포인트 감소. 0 또는 음의 정수라야 한다.
  - `likeDeduction` - 추천 한 사람의 포인트 증/감. 0 또는 양의 정수, 음의 정수.
    예를 들어, A 가 B 를 추천한 경우, A 의 포인트를 증가 시킬수도 감소 시킬 수도 있다.
  - `dislikeDeduction` - 비추천 한 사람의 포인트 증/감. 0 또는 양의 정수, 음의 정수.
    예를 들어, A 가 B 를 비 추천한 경우, A 의 포인트를 증가 시킬 수도 반대로 감소 시킬 수도 있다.
  - `voteDailyLimitCount` - 하루에 추천/비추천으로 포인트 증/감을 할 수 있는 회수. 이 회 수 이상 추천/비추천을 하면 포인트 증/감이 없다. 단, 추천/비추천은 된다.
  - `voteHourlyLimit` - 추천/비추천을 하는 시간 제한.
  - `voteHourlyLimitCount` - `voteHourlyLimit` 에서 지정한 시간 내에서 포인트 증/감을 허용 할 회 수.
    예를 들어, `voteHourlyLimit` 을 2 로 입력하고, `voteHourlyLimitCount` 에 3 을 입력하면,
    두 시간에 최대 3 번의 추천/비추천 포인트 증/감한다.
    이 회 수 이상 추천/비추천을 하면, 포인트 증/감 안 됨. 단, 추천/비추천 가능.
    자세한 내용은 포인트 시스템 참고.

  - `register` - 회원 가입을 하면 추가 할 포인트. 0 또는 양의 정수.
  - `login` - 로그인을 하면 추가 할 포인트. 0 또는 양의 정수.
  - 이 외에도 여러가지 있을 수 있다.


- 주의 할 점은 관리자 설정은 여러 곳에서 사용 될 수 있다.
  예를 들면, 사용자 포인트 증/감 또는 배너 관리 및 설정을 할 때, 그 설정 정보를 관리자 설정에 저장 할 수 있다.
  즉, 관리자 설정에서 추가하지 않은 설정도, 나타날 수 있는데, 그러한 정보를 삭제하도록 해야 한다. 또는 삭제를 한다면, 잘 알고 해야 한다.
  만약, 그러한 설정을 실수로 삭제하는 것을 미리 방지하기 위해서,
  vue.js `x-vue/components/admin/settings/AdminSettings.vue` 의 관리자 설정 페이지에서 적절하게 설정을 빼 주면 된다.
  
- 또한 몇 몇 중요한 관리자 설정은 동적으로 추가하도록 하지 말고, 미리 FORM 양식을 만들어 놓으면 좋다.
  즉, 코드 명으로 무슨 뜻인지 쉽게 파악이 안 될 수 있기 때문이다.


- 참고로, 관리자 설정에서 포인트 like, dislike 등의 용어(명칭)은 `user_activie.actions.php` 에서 사용하는 것과
  동일하게 설정되어야 코드 내에서 동작을 하게 된다.
  

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

## 광고 기능 추가해야 할 것

- 사업자 등록증을 올리도록 할 것.
  사업자 등록증에 있는 대표자가 본인 인증 하도록 해야 할 것.
  경고. 사업자등록증이 없거나 사업자등록증과 관계 없는 사업, 불법 광고, 성매매 유사 업종을 광고하는 경우 해당 광고는 즉시 차다며, 당국에 고발조치를 합니다.
  

## Terms & Conditions

- Category banner.
  The banner that is displayed only under a specific category.
  
- Global banner.
  The banner that is displayed everywhere with or without category.
  When a category has a category banner, then the category banner will be display. or global banner will be displayed.

- Banners that has longer end dates will appear first.

- Point payment
  Banner price is different on each banner place of each country. It is set by admin page.
  
- User cannot choose country when they upload(edit) banner.

- Cancellation.
  Advertisement can be cancelled before it begins.
  
- Refund penalty
  - If the banner had been display only a second, then the day will be treated as served.
  - If the not-served-yet-days(excluding today) is 0 days, then the point is not refundable.

  - To refund the point, the system must know how much point was set(paid) for 1 day.
    The charge (of point) may be changed often by admin.
    So, When user create the banner, the total point and periods(daymas) must be recorded.
    And, when user wants to cancel/refund the banner, the system can compute how much to return to the user.

- If the advertisement has not started yet, then 100% of the point will be refunded without penalty.
  - User can set the begin_date of the advertisement and the user want to cancel the advertisement before the begin_date,
  then 100% will be refunded.
    
- 관리자는 각 배너 포인트를 0 으로 설정 할 수 있다.
  즉, 사용자는 배너를 무료로 진행 할 수 있는 것이다. 이 때에는 최대 광고 설정 기간을 길게하지 않도록 해야 한다.

- Each banner must be a png or jpg file. that means, GIF animation is not allowed.

- If one banner place has multiple banners to show, then it will rotate the banner by 7 seconds.


## 광고 기능 코딩 기법 및 로직 설명

- 광고 게시판 아이디는 반드시 `ADVERTISEMENT_CATEOGRY` 에 있는 것을 사용한다.
- 광고 배너는 하나의 글이다.
  
- 광고 배너(글) 생성 시,
  - pointPerDay 와 advertisementPoint 는 0 으로 초기화 되어 meta 에 저장된다. 즉, 항상 사용 가능한 상태이다.
- 광고 배너(글)를 생성하고, `advertisement.start` 라우트로 시작을 해 주어야 한다. 이 대,
  - pointPerDay 는 해당 광고의 하루 포인트
  - advertisementPoint 에는 총 기간의 포인트가 meta 에 저장된다.
  
- 광고가 진행(시작)되기 전에 취소되면, post 의 meta 중 status 에 cancel 을 저장하고, 100% 환불된다.
- 광고가 시작되어, 중간에 중단되면, post 의 meta 중 status 에 stop 이 저장되고, 오늘을 빼고 나머지 일 수 만큼 환불 된다.
- 중단된 광고, 취소된 광고, 끝난 광고는 `advertisement.route` 호출을 통해서 광고 중단을 할 수 없다.
  단, 오늘 끝나는 광고는 중단 할 수 있다.

- 광고 상태는 active, inactive, waiting 과 같이 3 가지 클라이언트에게 전달된다.
  단, 실제로는 stop 과 cancel 두 가지가 더 있는데, stop 과 cancel 은 db record 에 저장되는 것으로 클라이언트에게 전달 될 때에는 inactive 로 전달된다.
  active, inactive, waiting 은 db record 에 저장되는 값이 아니라, 클라이언트로 response 할 때, 프로그램적으로 만들어지는 값이다.
  - 배너( 글 )를 입력 받아, 메타에 저장된 status 를 보고,
    - stop 이나 cancel 이면 inactive
  - advertisementPoint 에 값이 0 이면, 광고 설정이 안된 것으로, inactive
  - status 가 stop, cancel 이 아니고, advertisementPoint 가 있는 상태에서,
    - 광고 시작이 안되었으면, waiting
    - 광고 시작과 끝 시간 사이에 있으면, active
    - 광고 종료되었으면, inactive,

## Banner Place & Display


- Banner types are saved in `BANNER_TYPES` inside `config.php`.

- The table below explains how banners are displayed.

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
- If a category has no category banner, then, global banner will be displayed just the way it is displayed as globally.
  If there no global banner, then default banner will be displayed.
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

- Advertisement banners does not have its own table.
  It uses `posts` table.
  (광고 테이블은 따로 없고, `posts` 테이블을 사용한다.)

- The advertisement category is stated on `ADVERTISEMENT_CATEGORY`. (게시판 아이디는 `ADVERTISEMENT_CATEGORY` 에 기록되어져 있다.)

- The advertisement begin date and end date.
  - Begin date is recorded at `beginAt`
  - End date is recorded at `endAt`


- Advertisement type is recorded at `code`.
- The banner image is saved as `files.code=banner`
- And when the advertisement content is being shown, the banner should not be shown.

## Advertisement settings table.

- There is no table for Advertisement banners. But there is one for advertisement settings.

- if 'countryCode' is empty, then that is the default settings.
  Otherwise each record has its own settings for the countryCode.
  
- `maximumAdvertisementDays` is the maximum adverting days from tdoay. it is saved in meta table.

- `advertisementCategories` has the categories for user to post their banners on. It is saved in meta table.
  It can have many categories separating by comma(,).
  For instance, "qna,discussion,job".


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




# 카페, Cafe, 소너브

- 메일 회원 가입하지 않고, 소셜 로그인 하며, 회원 별 본인 인증을 하므로, 메일 주소를 회원 정보에 표시 하지 않는다.
- 전화번호, 이름, 생년월일(나이), 성별은 수정 불가하다. 본인 인증을 하면 자동으로 적용된다. 단, 닉네임은 수정 가능.
- 회원 정보에서 이름을 표시 할 때에는 "송x호" 와 같이 중간 글자를 안보이게 처리한다.

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


## 카페 설정

### cafe.check 라우트로 기본 설정

- 카페에서 사용되는 게시판, 기본 설정 등을 손쉽게 관리하기 위해서 `?route=cafe.check` 로 접속하면 된다.
  접속 예, `https://main.philov.com/index.php?route=cafe.check&reload=true`
  - 이 경로는 Json 을 리턴하는 것이 아니라, 카페 설정 정보를 보여준다.
  - 그리고 메인 메뉴에 사용되는 게시판의 경우, 존재하지 않으면 자동 생성한다.

## Cafe PWA

- All cafe (both main-cafe and sub-cafe) works as PWA.
- All cafe (both main-cafe and sub-cafe) can be installed as A2HS.
  - Main cafe will use main cafe settings to patch manifest.json
  - Sub cafe will use its category settings to patch manifest.json
  

## 카페 로그인

- 소셜 로그인 만으로 한다.
  - 카카오, 구글, 페이북 3가지로만 로그인을 할 수 있도록 한다.
    - 네이버는 뺀다. 그 이유는 도메인 설정에서 한 개발자 앱(프로젝트)에 2개의 도메인만 허용된다. 많은 도메인을 사용하게 될 소너브 카페와는 맞지 않다.


    
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

- 데이터베이스의 connection 을 생성할 때, `db()->connection()->set_charset('utf8mb4')` 를 적용한다.
  즉, DB 의 모든 문자셋은 반드시 'utf8mb4' 또는 'utf8mb4_general_ci' 라야 한다.
  
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
- `verifier` 은 사용자 인증을 제공하는 업체 코드이다. `passlogin`, `danal` 등과 같이 들어가면 된다.
  이 필드의 값이 빈 문자열이면, 회원이 본인 인증을 하지 않은 것이다.


### 사용자 사진, 프로필 사진

- 사용자가 프로필 사진을 올릴 때,
  `file.userIdx` 에 회원 번호, `file.code` 에 `photoUrl` 이라고 입력하면, 해당 사진은 그 사용자의 프로필 사진로 저장된다.
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

- 'fileIdxes' 필드는 글에 등록된 파일 들의 idx 를 콤마로 분리해서 저장한다. 예) "123,456"
  주의 할 점은, 파일을 화면에 보여 줄 때(글/코멘트를)를 읽을 때에는 'fileIdxes' 필드를 참조하지 않고, wc_files 의 entity 를 보고, 해당 글에 연결된 모든 파일을 가져온다.
  다만, 글 검색을 할 때, 'fileIdxes' 필드에 값이 있으면 첨부 파일/사진이 있는 것으로 간주하여, 사진이 있는 파일만 가져오게 할 수 있다.
  DB table record 에는 존재하지 않지만, 글/코멘트를 읽을 때, `files` 라는 속성에 업로드된 파일이 포함된다.pos

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



- 글/코멘트를 쓸 때, 특정 포인트 이상이 있어야 글 또는 코멘트를 쓰게 할 수 있다. 아래의 설정이 포인트 기준으로 글/코멘트 작성 설정을 한다.

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
  - For instance `userActivity()->canCreatePost()`

- add a method of recording activity in `user_acitivity.taxonomy.php`.
  - And add it after the activity.
  - For instance, `userActivity()->register()`
  - If it needs to deduct point, deduct the point in this method.

- For instance, 'UserActivityTaxonomy::canRegister()' checks if the user can register, and 'UserActivityTaxonomy::register()' method records.




## 친구 관리 테이블

- 테이블 이름: friends
- 친구 목록은 n:n 관계이다. 그래서 별도의 테이블이 존재해야한다.
- myIdx 는 나의 회원 번호
- otherIdx 는 내 친구로 등록된 (다른 사용자의) 회원 번호.
- block 은 친구 신고를 하거나, 차단하는 경우, 'Y' 의 값을 가진다. 'N' 의 값을 가지지 않으며, 기본적으로는 빈(문자열) 값이다.



# 회원가입, 로그인

- 아이디 대신, 메일 주소 형태의 문자열을 사용한다.
  이것은 실제 메일 주소 일 수도 있고 아닐 수도 있지만, 메일 주소 형식을 띄어야 한다.
  소셜 로그인을 하는 경우, 임시 (존재하지 않는) 메일 주소 일 수 있다.
  - 다만, 회원 가입을 메일 주소와 비밀번호로 하는 경우에는 메일 주소로 회원에게 메일을 보내거나, 비밀번호를 잃어 버렸을 때, 회원 확인용으로 사용 될 수 있다.
  - 참고로, 소셜 로그인을 하는 경우, 메일 주소는 임시로 만들어서 사용하며, 실제 메일 주소는 orgEmail 메타에 저장된다.
  
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


## 파이어베이스 로그인

웹으로 파이어베이스 로그인을 하는 경우 주로 구글, 페이스북, 애플 아이디로 로그인을 한다.
- 파이어베이스에 로그인을 하면, 메일이나 기타 정보를 백엔드 `user.firebaseLogin` 라우터로 넘기고,
- 백엔드에서 회원 정보 및 세션 아이디를 클라이언트에 넘겨주고, 웹 브라우저에 보관하는 것으로 로그인이 된다.
  즉, 로그인은 백엔드의 세션 아이디가 클라이언트에 보관되어져야 한다.
- 주의해야 할 것은, 다른 소셜 로그인과는 달리 파이어베이스의 경우 활용도가 높아
  - 파이어베이스에 로그인을 하면, 백엔드에도 같이 로그인되어야 하고, 
    벡엔드에서 로그아웃을 하면 파이어베이스에도 같이 로그아웃되어야 한다.
    즉, 로그인이 서로 유지가 되어야 한다.
    


## 휴대폰 번호 PASS 로그인

- 자세한 설명은 [휴대폰 번호 PASS 로그인 요약 문서](https://docs.google.com/document/d/1f7udtIGo0a4lliM8WGNiXh01lqRhkz76bWbszty6tSk/edit#heading=h.wks3lo2tvsr8)를 참고한다.
- 휴대폰 번호 PASS 로그인, 개발자 페이지에서 콜백 URL 이 `/etc/callbacks/pass-login/pass-login.callback.php` 로 설정되어져 있으며,
  실제로 잘 동작한다.
  PASS 로그인을 하면, 콜백 URL 에서 verifier 에 `passlogin` 이라고 입력하고, state 로 전달된 도메인으로 이동한다.
  도메인으로 돌아갈 때, 추가되는 URI 는 `/passlogin/success` 이다. 즉, state 가 `abc.sonub.com` 이라면,
  `https://abc.sonub.com/passlogin/success` 으로 전달된다.

### 휴대폰번호 PASS 로그인 - 테스트 하는 방법

- `https://main.philov.com/etc/callbacks/pass-login/pass-login.callback.php?test=1` 와 같이 접속하면 테스트를 할 수 있다.
  - 이 때, 화면 디자인이나 로그인 또는 회원 가입에 따른 DB 업데이트 등을 할 수 있다.

- 테스트 순서
  - 1. 먼저 홈페이지에 로그인을 한다.
  - 2. `/etc/callbacks/pass-login/pass-login.callback.php?test=1` 으로 접속하면, 본인 인증 한 후, 사용자 정보를 DB 에 업데이트한다.
  - 3. 홈페이지에서 인증된 사용자로 뜨는지 확인하고,
  - 4. 인증 사용자 전용 게시판에 글 쓰기가 가능한지 본다.

# 썸네일, Thumbnail

- 쎔네일을 사용하는 방법은 두 가지 방법이 있다.
  - 하나는 thumbnailUrl() 을 호출하여, 쎔네일 이미지 URL 을 가져오는 것이고
  - 또 다른 하나는 `https://.../etc/thumbnail.php` 와 같이 endpoint 를 이미지 태그 등에 넣어 바로 화면에 출력하는 것이다.
  - 이 둘다, 동일한 zoomThumbnail 함수를 사용하고, 둘 다 기본 사이즈 200x200 을 사용한다.
    - 사이즈가 같다면, 둘 중에 하나에서 생성한 이미지는 다른 것에 재 사용된다.

- 썸네일을 잘 하는 방법 또는 이미지를 잘 관리하는 방법
  - 가능하면 이미지 정 중앙에 객체(중요 이미지 부분, 대상이 되는 부분)를 넣으면 좋다. 그러면 썸네일을 할 때 잘 보인다.
  - 예를 들어, 가로 1, 세로 2 와 같은 비율로 너비는 작고 높이가 긴 세로 이미지를 썸네일로 표시하는 경우, 이미지를 올릴 때,
    - 객체(대상 또는 주요 부분)가 정 중앙에서 세로로 좀 길게 배열을 해야한다. 그래야 썸네일 했을 때 자연스럽다.
    - 그리고 그러한 사진만 올리는 카테고리를 따로 정해 놓고, 세로로 긴 사진은 그 카테고리에 따로 올리는 것이 좋다.
      예를 들면, 뉴스 게시판의 "세로 이미지" 라는 카테고리를 만들어 그 카테고리에 세로 이미지만 넣으면 좋다.

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



# 날씨, OpenWeatherMap

- `matrix` supports weather api from https://openweathermap.org/
- define open weather map api key in config.php
```php
define('OPENWEATHERMAP_API_KEY', '7cb555e44cdaac586538369ac275a33b');
```

- You can use `openweathermap.onecall` with `lat` and `lon`.


- ~~@see widgets/weather/openweathermap for example.~~




# 국가 정보, Country

## 국가 정보 참고 문서


- 참고: https://www.nationsonline.org/oneworld/country_code_list.htm
- 참고: https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes



국가 정보를 wc_countries 테이블 에 저장 해 놓았으며, etc/sql/countries.sql 에 SQL 로 dump 해 놓았다.

테이블에 들어가 있는 정보는 아래와 같다.

- `koreanName` 한글 국가 이름. 예) 아프가니스탄, 대한민국

- `englishName` 영문 국가 이름. 예) Japan, South Korea

- `officialName` 해당 국가 언어의 표기 이름. 예) 日本, الاردن , 한국

- `alpha2` 국가별 IOS 2자리 코드. Alpha-2 라고 표기하기도 함. 예) JP, KR

- `alpah3` 국가별 IOS 3자리 코드. Alpha-3 라고 표기하기도 함. 예) JPN, KOR

- `currencyCode` 통화 코드. 예) JPY, KRW

- `currencyKoreanName` 한글 통화 이름(명칭). 예) 엔, 원, 유로, 달러, 페소

- `currencySymbol` 통화 심볼. 예) ¥, €, ₩, HK$

- `numericCode` 국가별 ISO 숫자 코드. 예) 008, 한국은 410.

- `latitude`, `longitude` 국가별 중심의 GEO Location. 국가별 수도가 특정 도시가 아닌, 국가의 토지 면적에서 중심이 되는 부분의 위/경도 값이다.
  이 값을 활용 예)
  사용자의 국가 정보를 알고 있으면 그 국가의 중심부의 lat, lon 을 구해서, 해당 국가의 날씨 정보를 추출 할 수 있다. 비록 그 위치가 특정 도시가 아닌, 나라 면적의 중심이지만 적어도 그 국가의 날씨 정보를 알 수 있다.



## 국가 정보 코딩 예제

- `lib/country.class.php` 와 `lib/data.php` 를 참고한다.


- To get all country list with country code in 2 letter and country name.
  - By default, the route will return in English. To Korean version, add `&ln=ko` at the end.
  
```text
https://main.philov.com/index.php?route=country.all
https://main.philov.com/index.php?route=country.all&ln=ko
```

- you can get the whole country currency information like below.
  - By default, the route will return in English. To Korean version, add `&ln=ko` at the end.

```text
https://main.philov.com/index.php?route=country.currencies
https://main.philov.com/index.php?route=country.currencies&ln=ko
```

# 환율, Currency Conversion

- Matrix supports currency api from https://free.currencyconverterapi.com/


- You can define free version currency api in config.php. It can be easily switched to paid version.

```php
define('CURRENCY_CONVERTER_API_KEY', 'bd6ed497a84496be7ee9');
```

- You may want to get the whole country currency information. If you do, access the route like below.

```text
https://main.philov.com/index.php?route=country.currencies
```

By default, the route will return in English. To Korean version, add `&ln=ko` at the end.

## Get currency data

To get currency data, you need to give a pair of currency code just like below.

```text
https://main.philov.com/index.php?route=currency-converter.get&currency1=USD&currency2=KRW
```

The query above gets `KRW` currency rate against `USD`. And the controller does more than that.

One thing to note is that, there is query limit not only for free version but also for paid version.
So, it is important to limit the query to currency server.
And to limit the queries(or to maximize the queries), it queries 2 pairs to currency server.
For instance, if the client request `USD` to `KRW`, the controller queries `USD` to `KRW` and `KRW` to `USD`.
By doing this, it saves another query from `KRW` to `USD`.
You can test it by querying `&currency1=USD&currency2=KRW`, then `&currency1=KRW&currency2=USD`. When client queried
only 1 pair, the controller queries 2 pair and saves 2 caches of each query. So, the other pair is automatically cached.


```json
{
  "response": {
    "USD_KRW": 1131.894869,
    "KRW_USD": 0.000883,
    "cached": true
  },
  "request": {
    "route": "currency-converter.get",
    "currency1": "USD",
    "currency2": "KRW"
  }
}
```

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



# API KEYS

- 흔히, Restful Api Service 에 사용하는 api key 와 동일한 개념으로 Restful api 로 접속 할 때, 아이디와 비밀번호를 지정하게 한다.
  예를 들어, 테스트를 위해서, rest api endpoint 를 공개해서, 아무나 테스트용으로 접속해서 사용 할 수가 있는데,
  테스트가 끝나거나, 더 이상 테스트 사용하기를 원치 않을 때,
  또는 원치 않는 클라이언트로의 접속을 차단 할 때 등에 사용 될 수 있다.
  
- `MATRIX_API_KEYS` 에 지정하며 기본 값은 빈 배열(`[]`) 인데, 이와 같은 경우, 키 검사를 하지 않고 모두 허용한다.
  각 배열의 요소에는 문자열이 들어가는데, "id::password" 와 같은 형식을 띈다. 예) `key_id_abcd::abcd_password`
  
- `MATRIX_API_KEYS` 는 git repo 나 그외의 장소에 공개되면 안되므로, `view/view-name/keys/private.config.php` 에 저장한다.


# 포인트 시스템

- @TODO 글 쓰기를 할 때, 포인트가 감소하는 하는 설정을 한 경우, 지정한 회수 만큼만 감소하고 그 이후 글을 쓰면 더 이상 감소하지 않는가? 물론 ban 하면 더 이상 쓰기는 안되어야 한다.

- 관리자가 limit 설정을 하지 않으면, 자동으로 포인트 증/감을 하지 않는다. 즉, daily limit count 또는 hourly limit count 를 0 보다 큰 수로
  설정해야지만, 그 회 수 만큼만 포인트가 증/감한다.

- 포인트를 적용하는 곳(회원 가입, 로그인, 글 쓰기/삭제, 코멘트 쓰기/삭제, 추천, 비추천 등)에서는 포인트의 변화가 없어도(포인트 증감이 없어도) 기록을 남긴다.

- 이 기록을 바탕으로 추천/글쓰기/코멘트쓰기 시간/수 제한, 일/수 제한을 한다.

- "글/코멘트 쓰기 포인트 증가 제한"은 카테고리에 적용하는 것으로 글/코멘트를 합산하여 그 회 수를 계산한다.

- "글/코멘트 쓰기 포인트 증가 제한"은 제한된 회 수를 초과하면 포인트 증가만 안 될 뿐 계속 글을 쓸 수 있다.

  - 다만, "Ban" 옵션을 On 하면, "글/코멘트 쓰기 포인트 증가 제한"의 제한에 걸리면, 글/코멘트 쓰기 자체도 같이 제한한다. 즉, 글/코멘트 쓰기 제한이 되는 것이다.


- 일/수 제한은 해당일(오늘) 0시 0분 0초 부터 현재 시간까지 해당 글/코멘트/추천 들이 얼마나 발생했는지 확인하고 제한한다.
  예를 들어, 현재 시간이 14시 14분 14초 라면, 오늘 0시 0분 0초 부터 지금 현재 14시 14분 14초 까지 시간을 제한하는 것이다.

  즉, 하루에 10개를 제한 한다면, 0시 0분 0초 부터, 23시, 59분 59초 까지 10개를 썼는지 검사를 하는 것이다.
  만약, 23시 59분에 10개를 쓰고, 그 다음을 0시 0분에 또 10개를 쓸 수 있다. 즉, 20개를 연달아 쓸 수 있다.

- 게시판에는 Ymd 필드에 글 쓴 날짜의 YYYYMMDD 형식의 날자 값이 저장된다. 이 값은 글 쓰기에서 제한이 되지 않는다.

- 설정 관리
  - 추천/비추천의 경우, 관리자 설정에 설정을 관리하며
  - 게시판의 경우, 각 게시판 설정에서 관리를 한다.
  - 다만, 각 설정에 사용되는 필드명이나 코드 명은 user_activity.actions.php 와 user_activie.defines.php 에 기록되어져 있다.
    즉, 코드명이나 필드명을 여기에 기록 된 것으로 통일한다.

## 포인트 보유량에 따른 글, 코멘트 쓰기 제한

- 자세한 사항은 카테고리 테이블 설명을 참고한다.


## 포인트 시스템 활용도

- 예를 들어, 방명록 또는 출석부에 글 쓰는 경우, 200 포인트씩 증가하는데, 하루에 한번만 포인트가 증가(충전)하게 하고 싶다면,
  게시판의 설정에서
  `createDailyLimitCount` 필드(일/수 제한)에 1을 입력하고,
  `createPost` 필드(글 쓰기 포인트)에 200 으로 입력하면 된다.
  
- 또 다른, 예를 들어, 그림 짝 맞추기 게임을 하는 경우, 그 성공 결과를 게시판에 기록하는 경우,
  100 포인트 씩 하루에 5번까지만 포인트 충전이 되게하고 싶다면,
  해당 게시판의 설정에서 글 쓰기 포인트 100 포인트를 입력하고, 일/수에 5를 입력한다.
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


## 추천 보너스

- 글 쓰기, 코멘트 쓰기 등은 각 게시판 별로 보너스 포인트를 지정 할 수 있지만, 추천 보너스의 경우, 게시판 별로 보너스 포인트를 선택 지정 할 수 없으며, 전체 게시판에 적용된다.
  예를 들어, 추천 포인트를 5 로 하면, 모든 게시판의 글에 추천을 하면 포인트가 추가된다. 
  추천 보너스 역시 게시판 처럼 일/수, 시간/수 제한을 할 수 있다.
  

- `like` 포인트의 값은 0 또는 0 보다 커야한다. 즉, 추천을 받는 사람이 얻는 포인트를 증가시키면 증가 시켰지 감소시키면 안된다.
- `dislike` 포인트도 마찬가지로 0 또는 음수 값이어야 한다. 비 추천을 받으면, 포인트를 감소 시키면 감소 시켰지, 증가시키면 안된다.


- `voteDailyLimitCount` - 하루에 추천/비추천으로 포인트 증/감을 할 수 있는 회수.
  이 회 수 이상 추천/비추천을 하면 포인트 증/감이 없다. 단, 추천/비추천은 된다.
- `voteHourlyLimit` - 추천/비추천을 하는 시간 제한.
- `voteHourlyLimitCount` - `voteHourlyLimit` 에서 지정한 시간 내에서 포인트 증/감을 허용 할 회 수.
  예를 들어, `voteHourlyLimit` 을 2 로 입력하고, `voteHourlyLimitCount` 에 3 을 입력하면,
  두 시간에 최대 3 번의 추천/비추천 포인트 증/감한다.
  이 회 수 이상 추천/비추천을 하면, 포인트 증/감 안 됨. 단, 추천/비추천 가능.
  자세한 내용은 포인트 시스템 참고.

- 주의 할 점은, 각종 Limit count 가 기본적으로 0 인데, 0 이면, 하루에 한번도 추천 점수가 증가하지 않는다.
  즉, 이 값을 0 으로 하면, 0 번, 1로 하면 1번이 된다.



## 게임 포인트

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




# 보안

## blockUserFields

- 사용자 또는 해커가 Api call 을 통해서 회원 정보를 변경 할 수 없도록 `etc/config.php` 에 `blockUserFields` 를 설정 할 수 있다.
  배열로 여러개의 필드를 지정할 수 있으며, 여기에 기록된 필드는 사용자가 controller 를 통해서 업데이트 할 수 없다.
  단, entity()->update() 를 통해서, 내부적으로 업데이트 할 수 있다.
  하지만, user()->update() 를 통해서는 할 수 없다.
  즉, 사용자는 Api call 을 통해서 사용자 정보를 업데이트 할 때, `user()->update()` 를 통해서 업데이트 하는데 여기서 막는 것이다.
  
- `user()->update()` 로 업데이트할 때, 여기에 설정된 필드가 있으면 에러가 발생한다.
  - 따라서, "클라이언트엔드"로 부터 값 자체를 입력 받지 않아야 한다.
  - 또한, Unit test 를 할 때에는 이 값을 빼야 한다.
  - 가능한, 이 값은 각 `view/view-name/view-name.config.php` 에서 설정을 하도록 한다.
  
- 참고로 포인트의 경우 보안 문제로 `entity()->update()` 를 사용하지 않고 `setPoint()` 함수를 통해서 업데이트한다.


- 예제) 상황에 따라 블럭 필드를 설정 할 수 있는데, 클라이언트엔드에서 수정을 못하게 하려면 아래의 두 라우트를 막으면 된다.
  예를 들어, 소셜 로그인을 하면, `user.loginOrRegister` 로 접속을 하므로 업데이트를 할 수 있다.
  본인 인증을 하는 경우, API 호출이 아니어서, 업데이트 할 수 있다.
  즉, 회원 정보 수정에서만 아래의 필드는 업데이트 안되는 것이다.
  
```php
if ( in('route') == 'user.login' || in('route') == 'user.update' ) {
    config()->blockUserFields = [
        EMAIL,
        NAME,
        PHONE_NO,
        BIRTH_DATE,
        GENDER
    ];
}
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