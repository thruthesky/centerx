<?php







testEntityTree();
testEntityCreateWithMeta();
testEntityErrorHandling();




class TestTaxonomy extends PostTaxonomy {
    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }
}
function tt($idx=0): TestTaxonomy {
    return new TestTaxonomy($idx);
}

function testEntityErrorHandling() {

    isTrue(tt()->hasError === false, 'no error yet');

    // 에러 유발. 생성된 idx 를 지정하면 에러.
    isTrue(tt()->create(['idx' => 1])->hasError, 'idx must not provided');
    isTrue(tt()->create(['idx' => 1])->getError() == e()->idx_must_not_set, 'idx must not provided');

    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->getError() === e()->idx_must_not_set, 'chainging 에서 에러 전달' );
    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->read()->getError() == e()->idx_must_not_set, 'chainging 에서 에러 전달' );
    isTrue(tt()->create(['idx' => 1])->update(['idx' => 2])->read()->getData() == [], '에러가 있는 경우, 데이터는 []' );




}

function testEntityCreateWithMeta() {


    $title = 'this is title';
    $in = ['categoryIdx' => 0, 'userIdx' => 0, 'title' => $title, 'color' => 'blue'];


    $tt = tt(0);
    isTrue( $tt->create($in)->title == $title, "title must be $title");
    isTrue( $tt->create($in)->content == '', "content must be ''");
    isTrue( $tt->create($in)->color == 'blue', "color: blue");

    isTrue( $tt->create($in)->update(['content' => 'yo'])->content == 'yo', 'content must be yo');
    isTrue( $tt->create($in)->update(['content' => 'hi'])->markDelete()->deletedAt > 0, 'post is marked as deleted.');
}


function testEntityTree() {

    $tt = tt(0);
    isTrue(get_class($tt), 'TestTaxonomy');


    $created = $tt->create(['categoryIdx' => 0, 'userIdx' => 0, 'title' => 'text taxonomy']);

    isTrue(get_class($created), 'TestTaxonomy');

}

