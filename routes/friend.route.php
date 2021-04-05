<?php

class FriendRoute {

    public function add($in) {
        return friend()->add($in)->response();
    }

    public function delete(array $in) {
        return friend()->delete($in)->response();
    }

    public function block(array $in) {
        return friend()->block($in)->response();
    }

    public function unblock(array $in) {
        return friend()->unblock($in)->response();
    }

    public function list() {
        return friend()->list();
    }
    public function blockList() {
        return friend()->blockList();

    }
}
