<?php

class Theme
{

    public string $folderName;
    public string $folder;

    public function __construct()
    {
        $this->parseDomainTheme();
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
     *  theme()->file('index'); // 결과: /root/themes/sonub/index.php
     *  theme()->file('docs.privacy-policy'); // 결과: /root/themes/sonub/docs/privacy-policy.php
     *  theme()->file( filename: 'config' ); // 결과: /root/themes/sonub/config.php
     *  theme()->file( filename: 'config', prefixThemeName: true ); // 결과: /root/themes/sonub/sonub.config.php
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
     *  <style> include theme()->file('index', extension: 'css') </style>
     */
    public function file(string $filename, bool $prefixThemeName = false, string $extension = 'php'): string
    {

        if (str_contains($filename, '.')) {
            $arr = explode('.', $filename, 2);
            $filename = implode('/', $arr);
        }

        $file_path = ROOT_DIR . "themes/" . $this->folderName . '/' .
            ( $prefixThemeName ? $this->folderName . '.' : '') .
            $filename . '.' . $extension;

        if ( file_exists($file_path) ) return $file_path;

        $default_file_path = ROOT_DIR . "themes/default/" .
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
     * 현재 페이지 경로를 리턴한다.
     *
     * 현재 페이지 경로는 /?p=abc.def 와 같이 들어오거나, `p=` 를 생략하고, /?abc.def.ghi 와 같이 들어올 수 있다.
     * 점은 1개에서 3개 사이로 있어야 한다.
     *
     * 글 페이지 `p` 값이 없고, `/?` 으로 들어오지 않고, uri 에 값이 있으면, 글 페이지로 인식한다.
     *
     * @return string
     */
    public function page(): string {
        $p = in('p');
        if ( empty($p) ) {
            $uri = $_SERVER['REQUEST_URI'];
            if (str_starts_with($uri, '/?')) { // `/?` 으로 시작하고,
                $uri = str_replace('/?', '', $uri);
                $arr = explode('.', $uri);
                if ( count($arr) >= 2 && count($arr) <= 4 ) { // 점(.) 이 1개에서 3개까지이면,
                    $p = $uri;
                } else {
                    $p = 'home'; // `/?` 으로 시작하는데, 점이 없으면 그냥 홈
                }
            } else {                                // `/?` 으로 시작하지 않고,
                if ( $uri == '/' ) $p = 'home';     // uri 가 `/` 만 있으면, home
                else $p = 'forum.post.view';        // 아니면, 글 페이지
            }
        }
        return $this->file($p);
    }

    /**
     * 도메인을 파싱한다.
     */
    private function parseDomainTheme(): void
    {
        $_host = get_host_name();
        $this->folderName = 'default';
        foreach (DOMAIN_THEMES as $_domain => $_theme) {
            if (stripos($_host, $_domain) !== false) {
                $this->folderName = $_theme;
                break;
            }
        }
        $this->folder = ROOT_DIR . 'themes/' . $this->folderName . '/';
    }
}


$__Theme = null;
/**
 * @return Theme
 */
function theme(): Theme
{
    global $__Theme;
    if ( $__Theme == null ) {
        $__Theme = new Theme();
    }
    return $__Theme;
}
