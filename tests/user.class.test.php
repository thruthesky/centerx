<?php

$u = user()->create(['email' => 'test' . time() . '@gmail.com', 'password' => '12345a']);

$user = user($u[IDX]);
isTrue($u[EMAIL] == $user->email, "same email");
$updated = $user->update(['what' => 'blue']);
isTrue($user->v('what') == 'blue', 'should be blue. but ' . $user->v('color'));
isTrue($user->what == 'blue', 'should be blue. but ' . $user->what);

