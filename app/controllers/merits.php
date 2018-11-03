<?php

namespace App;

use Sober\Controller\Controller;

class Merits extends Controller
{
    public static function list()
    {
        return \get_posts(array(
            'posts_per_page' => -1,
            'post_type' => 'merit'
        ));
    }
}
