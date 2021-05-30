<?php



// Login into PHP runtime.
setUserAsLogin(getProfileFromCookieSessionId());

// load view/view-name/index.php
include view()->file('index');
