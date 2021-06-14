<?php

if ( API_CALL ) {
  include CONTROLLER_DIR . 'api.php';
  debug_log("controll.php:: API_CALL: yes");
}
else {
  include CONTROLLER_DIR . 'view.php';
  debug_log("controll.php:: API_CALL: no");
}

