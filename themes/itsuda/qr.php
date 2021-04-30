<?php

include '../../boot.php';
// Check for a specific platform with the help of the magic methods:
$detect = new \Detection\MobileDetect();
if( $detect->isiOS() ){
	$url = "https://apps.apple.com/kr/app/itsuda/id1560827977";
} else {
	$url = 'https://play.google.com/store/apps/details?id=com.itsuda50.app3';
}


?>
	<script>
location.href = "<?=$url?>";
		</script>
