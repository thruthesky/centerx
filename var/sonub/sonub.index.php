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
            // 사이트 맵 처리. @see README
        } else if ( str_contains($uri, "/forum/") ) {
            // 게시판 목록 처리. @see README
            $categoryId = str_replace('/forum/', '', $uri);
        } else {
            $post = post($uri);
            if ( $post->idx ) {
                $html = patchSeoHeader($html, post: $post);
                $html = patchNextPosts($html, $post);
                return $html;
            } else {
                // 사이트 맵 페이지도 아니고, 글 목록도 아니고, 글 읽기도 아니면, 그냥 헤더의 SEO 항목만 패치해서 리턴.
                return patchSeoHeader($html);
            }
        }
    } else {
        // URI 가 없으면, 그냥 헤더 SEO 항목 패치해서 리턴.
        return patchSeoHeader($html);
    }
}

/**
 *
 */
function patchNextPosts(string $html, PostModel $post) {
    $posts = post()->search(
        where: "idx < ? AND parentIdx = 0 AND title <> ''",
        params: [$post->idx],
        limit: 2,
    );
    foreach( idxes($posts) as $idx ) {
        $post = post($idx);
        d($post->title);
    }

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


