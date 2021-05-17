<section class="widget-samples">
    <?php

    foreach( glob(ROOT_DIR . "widgets/**/**/*.php") as $file ) {

        $info = parseDocBlock(file_get_contents($file));
        if ( !isset( $info['size'] ) ) continue;
        $arr = explode('/widgets/', $file);
        $arr2 = explode('/', $arr[1]);
        $path = $arr2[0] . '/' . $arr2[1];


        echo "<hr>";
        echo "<div><em>path</em>: $path</div>";
        if ( isset($info['dependency']) ) echo "<div><em>dependency</em>: $info[dependency]</div>";
        if ( isset($info['options']) ) echo "<div><em>options</em>: $info[options]</div>";
        echo "<div class='$info[size]'>";
        include widget($path);
        echo "</div>";

    }
    ?>
</section>

<style>
    .widget-samples .narrow { margin-top: .5em; max-width: 260px!important; }
    .widget-samples .wide { margin-top: .5em; max-width: 600px!important; }
    .widget-samples em {display: inline-block; min-width: 80px; color: #99338f; font-weight: bold; }
</style>
