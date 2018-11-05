<?php

namespace App;

use Sober\Controller\Controller;

class Merits extends Controller
{
    public static function list()
    {
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'merit',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        if (get_field('category_to_show')) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'merit_category',
                    'terms' => get_field('category_to_show')
                )
            );
        }

        return \get_posts($args);
    }

    public static function listGrouped()
    {
        $terms = \get_terms('merit_category', array(
            'hide_empty' => false
        ));

        $final = array();

        foreach ($terms as $term) {
            $merits = \get_posts(array(
                'post_type' => 'merit',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'merit_category',
                        'terms' => $term->term_id
                    )
                )
            ));
            $final[$term->name] = $merits;
        }

        return $final;
    }
}
