<?php
/**
 * @file pagination
 * @name Default Pagination
 */
/**
 * $options['limit'] is the no of items to display in a list page.
 * $options['page'] is the current page no. It begins with no. 1.
 * $options['blocks'] is the no of pages to display on navigation bar(at bottom of the post list page)
 * $options['arrow'] to show or not the quick arrow button for very first page and very last page.
 * $option['total'] is the total no of items to display in all pages.
 * $option['url'] is the url for the post list page. In the url, `{page}` will be replaced with page no.
 *   - For example, if url is "?page=post.list&category=qna&page={page}" then, it will be converted into "?page=post.list&category=qna&page=5" where '5' is the page.
 */


$options = [];


$page = $options['page'] ?? 1;
$blocks = $options['blocks'] ?? 7;
$arrows = $options['arrows'] ?? false;


if ( !isset($options['total']) || empty($options['total']) ) {
    return;
}

if ( !isset($options['url']) || empty($options['url']) ) {
    return jsAlert('Url is empty on post list navigation bar');
}

if ( !isset($options['limit']) || empty($options['limit']) ) {
    return jsAlert('Limit is not set.');
}



$limit = $options['limit'];
$offset = ($page-1) * $limit;
$total_no_of_pages = ceil($options['total'] / $limit);
$second_last = $total_no_of_pages - 1;
$previous_page = $page - $blocks;
$counter_begin = 0;


function _url($no) {
    global $options;
    $re = str_replace('{page}', $no, $options['url']);
    return $re;
}


?>

<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
    <strong>Page <?php echo $page." of ".$total_no_of_pages; ?></strong>
</div>
<nav aria-label="Page navigation" style="display: inline-block">
    <ul class="pagination">
        <?php
        if($page > 1) {
            echo "<li  class='page-item'><a class='page-link' href='". _url(1) ."'>" . ($arrows ? '&lsaquo;&lsaquo;' : 'First') . "</a></li>";
        }
        ?>

        <li <?php if($page <= 1){ echo "class='page-item disabled'"; } ?>>
            <a class="page-link" <?php if($page > 1){ echo "href='". _url($previous_page) ."'"; } ?>><?=$arrows ? '&lsaquo;' :'Previous'?></a>
        </li>

        <?php
        if ($total_no_of_pages <= $blocks ){
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                if ($counter == $page) {
                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                } else{
                    echo "<li class='page-item'><a class='page-link' href='". _url($counter) ."'>$counter</a></li>";
                }
            }
        }
        else if($total_no_of_pages > $blocks){

            $counter_begin = floor(($page-1) / $blocks) * $blocks + 1;
            $until = $counter_begin + $blocks;
            if ( $until > $total_no_of_pages ) $until = $total_no_of_pages + 1;

            for ($counter = $counter_begin; $counter < $until; $counter++){
                if ($counter == $page) {
                    echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                }else{
                    echo "<li  class='page-item'><a class='page-link' href='". _url($counter) ."'>$counter</a></li>";
                }
            }

        }
        ?>

        <?php if($counter_begin + $blocks <= $total_no_of_pages) {

            $next_page = $counter_begin + $blocks;

            ?>

            <li  class='page-item' <?php if($page >= $total_no_of_pages) { /** @todo Is this code working? */ echo "class='disabled'"; } ?>>
                <a class='page-link' <?php if($page < $total_no_of_pages) { echo "href='". _url($next_page) ."'"; } ?>><?=$arrows ? '&rsaquo;' :'Next'?></a>
            </li>


            <li class='page-item'><a class='page-link' href='<?=_url($total_no_of_pages)?>'><?=$arrows ? '&rsaquo;&rsaquo;' :'Last'?></a></li>
        <?php } ?>
    </ul>
</nav>