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

    public static function sortEquipment($list)
    {
        usort($list, function ($a, $b) {
            if ($a['item']->post_title == $b['item']->post_title) {
                return 0;
            }

            return ($a['item']->post_title < $b['item']->post_title) ? -1 : 1;
        });
        return $list;
    }
}
