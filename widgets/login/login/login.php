<?php if (loggedIn()) { ?>
    <?= ln('welcome') ?>, <?= login()->nicknameOrName ?>.
    <?=login()->idx?>
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
                                }, alert);
                            }
                        }
                    })
                </script>
            <?php } else { ?>
                <span onclick="adminTranslate('Y');">[<?= ln('begin translate') ?>]</span>
            <?php } ?>
        </div>

        <script>
            function adminTranslate(flag) {
                Cookies.set('adminTranslate', flag);
                location.reload();
            }
        </script>
    <?php } ?>
    <a href="/?user.logout.submit">[ <?=ln('logout')?> ]</a>
<?php } else { ?>

    <div class="fs-sm">
        <a class="d-block" href="/?user.login">
            <?=ln('please_login')?>
            <div class="mb-0 alert alert-info fs-md"><?=ln('to_login')?></div>
        </a>
        <a class="d-block mt-1 text-right" href="/?user.register"><?=ln('or_register')?></a>
    </div>
<?php  } ?>
