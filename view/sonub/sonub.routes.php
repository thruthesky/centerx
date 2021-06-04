<?php

addRoute('notification.updateToken', function($in) {
    if (!isset($in[TOKEN])) return e()->token_is_empty;

    // If the topic has a dot(.), then it is considered as a domain.
    if ( str_contains($in['topic'], '.') ) {
        $arr = [ DEFAULT_TOPIC ];

        $host = $in['topic'];
        $rootDomain = get_root_domain($in['topic']);
        if ( $host == $rootDomain ) $arr[] = $host;
        else {
            $arr[] = $host;
            $arr[] = $rootDomain;
        }

        $in['topic'] = implode(',', $arr);
    }

    return token($in[TOKEN])->save($in);
});
