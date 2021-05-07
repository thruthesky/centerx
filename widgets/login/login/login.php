

<?php if ( loggedIn() ) { ?>
    <?=ln('welcome')?>, <?=login()->name?>.
    <?php if ( admin() ) { ?>
        <div>
            <a href="/?admin.index">[<?=ln('admin')?>]</a> |
            <?php if ( isTranslationMode() ) { ?>
                <span onclick="adminTranslate('N');">[<?=ln('stop translate')?>]</span>
                <script>
                    mixins.push({
                        created() {
                        },
                        methods: {
                            onSubmitTranslate: function(ln, code) {
                                console.log('translate!');

                                // var res = ...
                                // var dom == document.getElementById(code);
                                // dom.innerText = res[ln];
                            }
                        }
                    })
                </script>
            <?php } else { ?>
                <span onclick="adminTranslate('Y');">[<?=ln('begin translate')?>]</span>
            <?php } ?>
        </div>
    <?php } ?>
<?php } else { ?>

<?php  } ?>

<script>
    function adminTranslate(flag) {
        Cookies.set('adminTranslate', flag);
        location.reload();
    }
</script>
