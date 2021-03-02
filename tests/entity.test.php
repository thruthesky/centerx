<?php




/// Create
$email = 'test'.time().'@email.com';
$record = entity(USERS)->create(['email' => $email, 'password' => '12345a']);
isTrue(isSucess($record));


/// Check & Get
$entity = entity(USERS, $record[IDX]);
isTrue($entity->exists());
isTrue($entity->get()[EMAIL] === $email);

/// Update
isTrue(isSucess($entity->update([NAME => 'JaeHo'])));
isTrue($entity->get()[NAME] === 'JaeHo');


/// Delete
isTrue(isSucess($entity->delete()));
isTrue($entity->exists() === false);



