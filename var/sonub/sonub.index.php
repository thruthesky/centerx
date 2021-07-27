<?php

include '../../boot.php';
//$cafe = cafe(domain: get_host_name());
//d($cafe); exit;


if ( isset($_SERVER['PHP_SELF']) && str_contains($_SERVER['PHP_SELF'], 'manifest.json') ) {
    $str = file_get_contents(view()->folder . 'manifest.json');
    $json = json_decode($str, true);
    $cafe = cafe(domain: get_host_name());

    $json['lang'] = 'en';
    $json['start_url'] = "/?start_url=pwa";
    $json['orientation'] = "natural";
    $json['scope'] = "/";
    $json['theme_color'] = "#ffffff";

    if (!in_array(get_host_name(), $cafe->mainCafeDomains)) {
        $json['background_color'] = $cafe->app_background_color;
        $json['name'] = $cafe->title;
        $json['short_name'] = $cafe->app_name;
        $json['description'] = $cafe->description;

        //get uploaded app icon
        $appIcon = $cafe->appIcon();
        if($appIcon->ok) {
            $json['icons'] = [
                [
                    'src' => $appIcon->url,
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose" => "any maskable",
                ],
            ];
        }

    }

    header("Content-Type: application/json");
    echo json_encode($json);
    exit;
}

if (isset($_REQUEST['route'])) {
    include ROOT_DIR . 'controller/control.php';
    return;
}

// Vue.js 의 index.html
$html = file_get_contents(view()->folder . 'index.html');
$html = patchSeo($html);
//d('hi');
echo $html;




function patchSeo($html): string {

    /**
     * SEO 처리.
     * 게시판 글 목록 또는 글 읽기, 사이트 맵이면,
     */
    if (isset($_SERVER['REQUEST_URI'])) {
        $uri = $_SERVER['REQUEST_URI'];
        if ( $uri == '/sitemap' ) {
            // 사이트 맵 페이지 처리. @see README
            $html = patchSeoHeader($html);
            $html = patchSeoSitemap($html);
            $html = patchSeoNextPosts($html);
            return $html;
        } else if ( str_contains($uri, "/forum/") ) {
            // 게시판 목록 처리. @see README
            $categoryId = str_replace('/forum/', '', $uri);
            $html = patchSeoHeader($html);
            $html = patchSeoNextPosts($html, categoryId: $categoryId );
            return $html;
        } else {
            // URI 가 있는데, sitemap 페이지도 아니고, 게시판 목록도 아닌 경우,
            $post = post($uri);
            if ( $post->idx ) {
                // 글 읽기
                $html = patchSeoHeader($html, post: $post);
                $html = patchSeoNextPosts($html, $post);
                return $html;
            } else {
                // 회원 가입, 로그인, 프로필, 가입 약관 등의 기타 페이지.
                // 사이트 맵 페이지도 아니고, 글 목록도 아니고, 글 읽기도 아니면, 그냥 헤더의 SEO 항목만 패치해서 리턴.
                return patchSeoHeader($html);
            }
        }
    } else {
        // 홈 또는 잘못된 페이지?
        // URI 가 없으면, 그냥 헤더 SEO 항목 패치해서 리턴.
        return patchSeoHeader($html);
    }
}

function patchSeoSitemap($html) {

    $parts = explode('<nav>', $html, 2);

    $seo = "";
    foreach( cafe()->mainMenus as $menu ) {
        $seo .= "<a href='/forum/$menu'>$menu</a>\n";
    }

    $html = $parts[0] . "\n<div class='sitemap'>" . $seo . "</div><nav>" . $parts[1];

    return $html;
}

/**
 * 글 읽기의 경우, 같은 카테고리의 다음 글(코멘트 포함)을 몇개를 리턴한다.
 */
function patchSeoNextPosts(string $html, PostModel $post = null, string $categoryId = '', int $no=10) {
    if ( $post ) {
        // 글 읽기
        $where = "categoryIdx=? AND idx < ?";
        $params = [ $post->categoryIdx, $post->idx ];
    } else if ( $categoryId ) {
        // 글 목록
        $cat = category($categoryId);
        $where = "categoryIdx=?";
        $params = [$cat->idx];
    } else {
        // 기타. 최근 글 표시.
        $where = "1";
        $params = [];
    }

    $posts = post()->search(
        where: $where,
        params: $params,
        limit: $no,
    );


    $seo = "\n";
    foreach( idxes($posts) as $idx ) {
        $post = post($idx);
        if ( $post->parentIdx == 0 ) {
            // 글이면, 글 정보
            if ( $post->title ) $title = $post->title;
            else $title = mb_substr($post->content, 0, 60);
            $url = $post->url;
        } else {
            // 코멘트이면, 코멘트 내용을 제목으로, 그리고 URL 은 원 글의 URL 로 한다.
            $title = mb_substr($post->content, 0, 60);
            $root = post($post->rootIdx);
            $url = $root->url;
        }
        // 제목이 없으면, 에러 방지를 위해서, 숫자로 표시한다.
        if ( empty($title) ) $title = $post->idx;
        $title = trim($title);
        $seo .= "<a href='$url'>$title</a>\n";
    }


    $before = explode('<nav>', $html, 2);
    $after = explode('</nav>', $html, 2);

    $html = $before[0] . "\n<nav class='seo'>" . $seo . "</nav>" . $after[1];

    return $html;
}

/**
 * @param $html
 * @param PostModel|null $post
 * @return string
 */
function patchSeoHeader($html, PostModel $post = null): string {

    /// 기본 SEO 패치 내용
    $site_name = SEO_SITE_NAME;
    $url = SEO_URL;
    $author = SEO_AUTHOR;
    $title = SEO_TITLE;
    $keywords = SEO_KEYWORDS;
    $description = SEO_DESCRIPTION;
    $image = SEO_IMAGE;

    /// 글 읽기
    if ( $post ) {
        $author = $post->user()->displayName;
        $url = $post->url;
        $title = $post->title;
        $description = mb_substr($post->content, 0, 254);
        $description = str_replace("\n", "", $description);
        $description = str_replace("<", "", $description);
        $description = str_replace(">", "", $description);
        $description = str_replace('"', "'", $description);
        $description = preg_replace("/\s+/", " ", $description);
        $description = preg_replace("/^\s+/", "", $description);

        if ( $post->fileIdxes ) {
            $files = $post->files();
            if ( $files ) {
                $image = $files[0]->url;
            }
        }
    }

    $before = explode('<title>', $html, 2);
    $after = explode('</title>', $html, 2);

$header = <<<EOH
<title>$title</title>
<meta name="description" content="$description">
<meta name="keywords" content="$keywords">
<meta name="author" content="$author">
<meta itemprop="name" content="$site_name">
<meta itemprop="description" content="$description">
<meta itemprop="image" content="$image">
<meta property="og:site_name" content="$site_name">
<meta property="og:type" content="website">
<meta property="og:title" content="$title">
<meta property="og:url" content="$url">
<meta property="og:description" content="$description">
<meta property="og:image" content="$image">
EOH;

    $html = $before[0] . $header . $after[1];


    return $html;
}


