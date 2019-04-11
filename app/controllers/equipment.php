<?php

namespace App;

use Sober\Controller\Controller;

class Equipment extends Controller
{
    public static function list()
    {
        $equipment = get_posts(array(
            'post_type' => 'equipment',
            'posts_per_page' => -1
        ));

        return $equipment;
    }
}
