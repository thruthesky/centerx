<?php

class Theme
{

    public string $folderName;

    public function __construct()
    {
        $this->parseDomainTheme();
    }


    /**
     *
     *
     * @param string $filename
     * @param bool $prefixThemeName 앞에 테마 폴더 이름을 붙일지 말지 결정한다.
     * @return string
     *
     * 예제)
     *  theme()->file( filename: 'config.php' ); // 결과: /src/themes/sonub/config.php
     *  theme()->file( filename: 'config.php', prefixThemeName: true ); // 결과: /src/themes/sonub/sonub.config.php
     *
     */
    public function file(string $filename, bool $prefixThemeName = false): string
    {
        return ROOT_DIR . "themes/" . $this->folderName . '/' .
            ( $prefixThemeName ? $this->folderName . '.' : '') .
            $filename;
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
    }
}


$__theme = null;
/**
 * @return Theme
 */
function theme(): Theme
{
    global $__theme;
    if ( $__theme == null ) {
        $__theme = new Theme();
    }
    return $__theme;
}
