<?php if (loggedIn()) { ?>
    <?= ln('welcome') ?>, <?= login()->name ?>.
    <?php if (admin()) { ?>
        <div>
            <a href="/?admin.index">[<?= ln('admin') ?>]</a> |
            <?php if (isTranslationMode()) { ?>
                <span onclick="adminTranslate('N');">[<?= ln('stop translate') ?>]</span>
                <script>
                    mixins.push({
                        created() {},
                        methods: {
                            onSubmitTranslate: function(e, ln, code, clsName) {
                                const formData = new FormData(e.target);
                                const data = Object.fromEntries(formData);
                                data['code'] = code;
                                data['currentCodeName'] = code;
                                request('translation.update', data, function(res) {
                                    // Since, we cannot find a way to update the input box value on popover,
                                    // we just reload the page.
                                    location.reload();

                                    // console.log(res);
                                    // console.log('replace: ', data[ln]);
                                    // const nodes = document.getElementsByClassName(clsName);
                                    // // console.log(nodes);
                                    // for (let i = 0; i < nodes.length; i++) {
                                    //     // console.log(nodes[i]);
                                    //     nodes[i].innerText = data[ln];
                                    // }
                                }, alert);
                            }
                        }
                    })
                </script>
            <?php } else { ?>
                <span onclick="adminTranslate('Y');">[<?= ln('begin translate') ?>]</span>
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