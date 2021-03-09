<?php







testEntityTree();



class TestTaxonomy extends PostTaxonomy {
    public function __construct(int $idx)
    {
        parent::__construct($idx);
    }
}
function tt($idx): TestTaxonomy {
    return new TestTaxonomy($idx);
}
function testEntityTree() {

    $tt = tt(0);
    isTrue(get_class($tt), 'TestTaxonomy');


    $created = $tt->create(['categoryIdx' => 0, 'userIdx' => 0, 'title' => 'text taxonomy']);
    d($created);
    isTrue(get_class($created), 'TestTaxonomy');

    $title = 'this is title';
    $in = ['categoryIdx' => 0, 'userIdx' => 0, 'title' => $title, 'color' => 'blue'];

    isTrue( $tt->create($in)->title == $title, "title must be $title");
    isTrue( $tt->create($in)->content == '', "content must be ''");
    isTrue( $tt->create($in)->color == 'blue', "color: blue");


    isTrue( $tt->create($in)->update(['content' => 'yo'])->content == 'yo', 'content must be yo');

    isTrue( $tt->create($in)->update(['content' => 'hi'])->markDelete()->deletedAt > 0, 'post is marked as deleted.');
}

