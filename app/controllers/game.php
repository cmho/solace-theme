<?php

namespace App;

use Sober\Controller\Controller;

class Games extends Controller
{
    public static function listGames()
    {
        $tz = new \DateTimeZone('America/Chicago');
        $dt = new \DateTime('now', $tz);
        $args = array(
            'post_type' => 'game',
            'posts_per_page' => -1,
            'meta_key' => 'downtimes_open',
            'orderby' => 'meta_key',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => 'downtimes_visible',
                    'value' => true
                )
            )
        );
        return get_posts($args);
    }
}
