<?php

function isRealNameAuthUser() {
    return login()->v('plid');
}
