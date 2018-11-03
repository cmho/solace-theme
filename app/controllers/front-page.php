<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public static function news()
    {
        return \get_posts(array(
            'posts_per_page' => 4,
            'post_type' => 'post'
        ));
    }

    public static function events()
    {
        return \get_posts(array(
            'post_type' => 'event',
            'posts_per_page' => 3,
            'order' => 'ASC',
            'order_by' => 'meta_key',
            'meta_key' => 'date',
            'meta_query' => array(
                array(
                    'key' => 'date',
                    'value' => date('Y-m-d h:i:s'),
                    'compare' => '>='
                ),
            ),
        ));
    }
}
