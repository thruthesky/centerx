<?php


class TaxonomyTest extends Entity {
    public function __construct(string $taxonomy, int $idx=0)
    {
        parent::__construct('TaxonomyTest', $idx);
    }
}


testBasics();
testEntitySetIdx();
testEntityCrud();


function testBasics() {
    return;
//    $created = entity('test')->create(['name' => 'yo']);
//    $obj = entity('test', $created[IDX]);
//    isTrue( $obj->exists(), 'exists!');
//    isTrue($obj->v('name') == 'yo');
//    isTrue(entity('test')->v('name') == null, 'must be null');
}
function testEntitySetidx() {
    $entity = entity('abc');
    isTrue(get_class($entity), 'Entity');
    $tt = new TaxonomyTest(123);
    isTrue(get_class($tt) == 'TaxonomyTest');
    $child = $tt->setIdx(456);
    isTrue(get_class($child) == 'TaxonomyTest');
}
function testEntityCrud() {


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

}




