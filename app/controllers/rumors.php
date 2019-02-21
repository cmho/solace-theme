<?php

namespace App;

use Sober\Controller\Controller;

class Rumors extends Controller
{
    public static function listRumors($game = null, $char = null)
    {
        $args = array(
            'post_type' => 'rumor',
            'posts_per_page' => -1,
            'meta_query' => array(

            )
        );
        if ($game) {
            array_push($args['meta_query'], array(
                'key' => 'game',
                'value' => $game
            ));
        }

        if ($char) {
            array_push($args['meta_query'], array(
                'key' => 'character',
                'value' => serialize(intval($char)),
                'compare' => 'LIKE'
            ));
        }

        $rumors = get_posts($args);
        return $rumors;
    }
}
