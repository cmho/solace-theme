<?php

namespace App;

use Sober\Controller\Controller;

class Beat extends Controller
{
    public static function count()
    {
        $beats = get_posts(array(
            'post_type' => 'beat',
            'posts_per_page' => -1,
        ));

        return array_sum(array_map(function ($n) {
            return get_field('value', $n);
        }, $beats));
    }
}
