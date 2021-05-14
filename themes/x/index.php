<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php

//    $entity = entity('search_keys');
//    $re = $entity->create(['searchKey' => 'apple']);

//    db()->insert('wc_search_keys', ['searchKey' => 'banana', 'updatedAt' => time(), 'createdAt' => time()]);


//    $keys = entity('search_keys')->search(where: 'searchKey=?', params: ['apple']);
//    foreach( $keys as $key ) {
//        echo "<hr> " . entity('search_keys',  $key['idx'])->searchKey;
//    }

//    d(db()->row('SELECT * FROM wc_search_keys WHERE searchKey=?', 'apple'));

//    db()->displayError = true;
//    $tx = translation()->create(['language' => 'uu', 'code'=>'tesu0t', 'text' => 'yo']);
//    d($tx);

//    entity('users')->create(['email' => 'abc...']);

//    $user = user()->create(['email' => 'abc@test.com', 'password' => '12345a']);
//    d($user);

//db()->displayError = false;
//    $re = db()->insert( DB_PREFIX . 'users', ['email' => 'a134@gmail.com', 'password' => '1345au', 'createdAt' => time(), 'updatedAt' => time() ]);
////    d($re);
//    if ( $re == 0 ) {
//        echo "Erorr";
//    }


    $re = user()->register(['email' => '00', 'password' => '12345a']);
    if ( $re->hasError ) {
        echo "Error: code: " . $re->getError();
    } else {
        echo "회원가입 성공";
    }

?>
</body>
</html>