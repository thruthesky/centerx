<?php


$email = 'test-register.' . time() . '@email.com';
$data = ['email' => $email];

$re = user()->register($data);
isTrue($re === e()->password_is_empty, 'Expect: password is empty.');


$record = user()->register([EMAIL=>$email, PASSWORD=>'12345a']);
isTrue( isSucess($record), 'Expect: password is empty.');


//$user = user($record[IDX]);


