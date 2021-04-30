<?php


class Route
{
    public $func;
    public function add(string $route, $func): void
    {
        $this->func = $func;
    }
    public function run() {
        return $this->func( in() );
    }
}

global $__Route;
/**
 * Route 를 Singleton 으로 해야지, 내부 변수가 유지된다.
 * @return Route
 */
function route(): Route
{
    global $__Route;
    if ( $__Route ) return $__Route;
    $__Route = new Route();
    return $__Route;
}



