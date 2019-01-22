<?php

namespace App;

use Sober\Controller\Controller;

class Conditions extends Controller
{
    public static function list()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'condition',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        return \get_posts($args);
    }
}
