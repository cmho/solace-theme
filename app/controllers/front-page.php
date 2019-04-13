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
        $tz = new \DateTimeZone('America/Chicago');
        $date = new \DateTime('now', $tz);
        return \get_posts(array(
            'post_type' => 'event',
            'posts_per_page' => 3,
            'order' => 'ASC',
            'order_by' => 'meta_key',
            'meta_key' => 'date',
            'meta_query' => array(
                array(
                    'key' => 'date',
                    'value' => $date->format('Y-m-d 23:59:59'),
                    'compare' => '>'
                ),
            ),
        ));
    }
}
