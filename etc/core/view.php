<?php

/**
 * Class Theme
 *
 * @property-read string $url
 */
class View
{

    public string $folderName;
    /**
     * @var string 현재 테마의 폴더 경로. 예) '/docker/home/centerx/themes/sonub/' 와 같은 전체 경로의 값을 가지면 맨 끝에 슬래시(/)가 붙는다.
     *              객체 초기화를 할 때 지정된다.
     */
    public string $folder;

    public function __construct()
    {
        $this->parseDomainTheme();
    }


    /**
     * @param $name
     * @return mixed
     */
    public function __get($name): mixed {
        if ( $name == 'url' ) {
            return HOME_URL . VIEW_FOLDER_NAME . '/' . $this->folderName . '/';
        } else {
            return null;
        }
    }



    /**
     * 현재 테마 폴더에서 파일을 찾고 없으면, default 폴더에서 찾는다. default 폴더에도 없으면,
     * 현재 테마 폴더에서 파일 경로를 리턴한다. 즉, 없는 파일의 경로를 리턴한다.
     *
     * - $filename 에 점(.)이 있으면, 첫번째 것만 슬래시(/)로 변경한다.
     *
     * @param string $filename
     * @param bool $prefixThemeName 앞에 테마 폴더 이름을 붙일지 말지 결정한다.
     * @param string $extension
     * @return string
     *
     * 예제)
     *  theme()->file('index'); // 결과: /root/themes/theme-name/index.php
     *  theme()->file('docs.privacy-policy'); // 결과: /root/themes/theme-name/docs/privacy-policy.php
     *  theme()->file( filename: 'config' ); // 결과: /root/themes/theme-name/config.php
     *  theme()->file( filename: 'config', prefixThemeName: true ); // 결과: /root/themes/theme-name/sonub.config.php
     *
     *  theme()->file('index', extension: 'css'); // 결과 테마 폴더에서 index.css 를 로드한다.
     *
     * 예제) theme/.../index.php 에서 아래와 같이 헤더/푸터를 로드 할 수 있다.
     *
     *      include theme()->file('header');
     *      include theme()->page();
     *      include theme()->file('footer');
     *
     * 예제) css 로드하기
     *  <style> <?php include theme()->file('index', extension: 'css') ?> </style>
     *
     * Example) Loading Javascript file under 'js' folder.
     *  <script> <?php include theme()->file('js/prepare', extension: 'js'); ?> </style>
     *
     * 트릭) 아래의 예제 처럼, 파일 명 자체에 점(.)이 들어가면 forum/post/list 로 인식이 되는데,
     *      맨 앞에 점을 하나 찍어주면 forum/post.list.php 로 인식하며,
     *      맨 처름 슬래시(/) 대신, 점을 찍어주어도 된다.
     *      이 것은 점을 최대 2개로 분리하기 때문이다.
     *  include theme()->file('.forum/post.list'); // 이것은 아래와 동일
     *  include theme()->file('forum.post.list'); // 위와 동일하게, forum/post.list.php 로 인식한다.
     */
    public function file(string $filename, bool $prefixThemeName = false, string $extension = 'php'): string
    {

        if (str_contains($filename, '.')) {
            $arr = explode('.', $filename, 2);
            $filename = implode('/', $arr);
        }

        $file_path = VIEW_DIR . $this->folderName . '/' .
            ( $prefixThemeName ? $this->folderName . '.' : '') .
            $filename . '.' . $extension;

        return $file_path;

        // @todo delete below. This code is not used in v2
        if ( file_exists($file_path) ) return $file_path;

        $default_file_path = VIEW_DIR . "default/" .
            ( $prefixThemeName ? $this->folderName . '.' : '') .
            $filename . '.' . $extension;

        if ( file_exists($default_file_path) ) return $default_file_path;

        return $file_path;
    }

    /**
     * CSS 파일을 포함한다. <style> ... </style> 와 같이 감싸주어야 한다.
     * @param string $filename
     * @return string
     * @example
     *  include theme()->css('index')
     */
    public function css(string $filename) {
        return theme()->file($filename, extension: 'css');
    }

    /**
     * Returns the theme script page file path.
     * @return string
     */
    public function page(): string {
        return $this->file($this->pageName());
    }

    /**
     * 현재 페이지 경로를 리턴한다.
     *
     * 현재 페이지 경로는 /?p=abc.def 와 같이 들어오거나, `p=` 를 생략하고, /?abc.def.ghi 와 같이 들어올 수 있다.
     * 점은 0개에서 3개 사이로 있어야 한다.
     * 즉, `/?menu` 와 같이 들어오면, theme/theme-name/menu.php 를 로드하고,
     * `/?menu.sitemap` 와 같이 들어오면, theme/theme-name/sitemap.php 를 로드한다.
     *
     *
     * 글 페이지 `p` 값이 없고, '/', `/?` 으로만 접속되는 경우, home.php 를 로드한다.
     *
     * 그렇지 않으면, uri 의 값을 글 페이지로 인식한다.
     *
     * 예제)
     * - `https://local.itsuda50.com/?` 와 같이 접속되면, /themes/[theme-name]/home.php 가 실행된다.
     * - `https://local.itsuda50.com/?p=admin.index` 와 같이 접속되면, /themes/[theme-name]/admin/index.php 가 실행된다.
     * - `https://local.itsuda50.com/?admin.index` 와 같이 접속되면, /themes/[theme-name]/admin/index.php 가 실행된다.
     * - `https://local.itsuda50.com/?admin.index&mode=submit` 와 같이 접속되면, /themes/[theme-name]/admin/index.php 가 실행된다.
     *
     * @return string
     */
    public function pageName(): string {
        $p = in('p');
        if ( empty($p) ) { // /?p= 와 같이 p 값이 없는 경우, 즉, "https://domain.com/abc-def" 와 같이 그냥 URL 로만 들어오는 경우,
            $uri = $_SERVER['REQUEST_URI'];
            if (str_starts_with($uri, '/?') && strlen($uri) > 2) { // `/?` 으로 시작하고 추가 문자열이 있을 때,

                $uri = str_replace('/?', '', $uri);
                $uriParts = explode('&', $uri); // '&' 로 분리. 즉, `/?admin.index&mode=submit` 과 같을 때, &mode= 이후는 버림.
                if ( str_contains($uriParts[0], '=') ) { // `/?mode=loggedIn` 와 같이 접속한 경우,
                    $p = 'home';
                } else {
                    $arr = explode('.', $uriParts[0]); // `/?admin.index` 부분에서 점으로 분리.
                    if ( count($arr) > 0 && count($arr) <= 4 ) { // 점(.) 이 1개에서 3개까지이면,
                        $p = $uriParts[0];
                    } else {
                        $p = 'home'; // `/?` 으로 시작하는데, 점이 없으면 그냥 홈
                    }
                }

            } else {                                // `/?` 으로 시작하지 않고,
//                debug_log("uri: $uri"); // 여기에 log 를 기록하면, '/favicon.ico' 와 같은 기록이 되는 것을 확인 할 수 있다.

                // 입력된 HTTP URI 에 특별한 값이 없으면, home
                if ( $uri == '' || $uri == '/' || $uri == '/?' || $uri == '/index.php' ) $p = 'home';
                else {
                    // 아니면, 글 페이지. Friendly URL 로 들어 온 경우.
                    // 주의, URL 에 ? 가 있을 수 있으니, 글을 가져올 때, ? 부터는 무시하도록 한다.
                    $p = 'forum.post.view';
                }
            }
        }
        return $p;
    }

    /**
     * 도메인을 파싱한다.
     */
    private function parseDomainTheme(): void
    {
        $_host = get_host_name();
        debug_log("view::parseDOmainTheme():: $_host");
        if ( empty($_host) ) {
            $this->folderName = DOMAIN_THEMES['_'];
        } else {
            $this->folderName = 'default';
            foreach (DOMAIN_THEMES as $_domain => $_theme) {
                if (stripos($_host, $_domain) !== false) {
                    $this->folderName = $_theme;
                    break;
                }
            }
        }
        $this->folder = VIEW_DIR . $this->folderName . '/';
    }
    
}


$__View = null;
/**
 * @return View
 */
function view(): View
{
    global $__View;
    if ( $__View == null ) {
        $__View = new View();
    }
    return $__View;
}

/**
 * @deprecated Use `view()`
 * @return View
 */
function theme(): View {
    return view();
}