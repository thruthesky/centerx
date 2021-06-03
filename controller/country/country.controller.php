<?php

class CountryController {
    public function all($in) {
        $rets = [];
        if ( isset($in['ln']) && $in['ln'] == 'ko' ) $ln = 'KR';
        else $ln = 'EN';
        foreach( country()->search(limit: 1000, object: true) as $co ) {
            $rets[ $co->v('2digitCode') ] = $co->v("CountryName$ln");
        }
        return $rets;
    }
}