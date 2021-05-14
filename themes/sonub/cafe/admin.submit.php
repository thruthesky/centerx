<?php
if (modeUpdate()) {
    $re = category(in('idx'))->update(in());
    if ($re->hasError) jsAlert($re->getError());
    jsGo('/?cafe.admin');
}