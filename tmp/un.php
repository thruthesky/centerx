<?php



echo $a; // Warning: Undefined variable $a

$b;
echo $b; // Warning: Undefined variable $b


$c = [];
echo $c['cherry']; // Warning: Undefined array key "cherry"


function fc($v) {
	echo $v;
}
fc( $c['cherry'] ); // Warning: Undefined array key "cherry"



$d = [];
function fd(&$v) {
	$v = $v . '... Yo<br>';
}
fd( $d['dragon'] ); // No error with pass by reference.
echo $d['dragon'];


fd( $d2 );
echo $d2;


