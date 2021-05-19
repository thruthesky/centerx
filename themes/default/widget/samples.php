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
        if ( isset($info['size']) ) echo "<div><em>size</em>: $info[size]</div>";
        if ( isset($info['dependency']) ) echo "<div><em>dependency</em>: $info[dependency]</div>";
        if ( isset($info['options']) ) echo "<div><em>options</em>: $info[options]</div>";
        if ( isset($info['description']) ) echo "<div><em>description</em>: $info[description]</div>";
        echo "<div class='widget $info[size]'>";
        include widget($path);
        echo "</div>";

    }
    ?>
</section>

<style>
    .widget-samples .widget { margin-bottom: 5em; padding: 1em; background-color: #efefef; }
    .widget-samples .icon { margin-top: .5em; }
    .widget-samples .narrow { margin-top: .5em; width: 260px; }
    .widget-samples .wide { margin-top: .5em; width: 600px; }
    .widget-samples em {display: inline-block; min-width: 100px; color: #99338f; font-weight: bold; }
</style>
