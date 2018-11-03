<?php

namespace App;

use Roots\Sage\Container;

\register_post_type('event', array(
    'label' => 'Event',
    'menu_icon' => 'dashicons-calendar-alt',
    'public' => true,
    'supports' => array('revisions', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes')
));

\register_post_type('character', array(
    'label' => 'Character',
    'menu_icon' => 'dashicons-universal-access',
    'public'=> true,
    'supports' => array('revisions', 'title', 'editor', 'page-attributes')
));

\register_post_type('downtime', array(
    'label' => 'Downtime Action',
    'menu_icon' => 'dashicons-edit',
    'public' => true,
    'supports' => array('revisions', 'title', 'editor', 'page-attributes')
));

\register_post_type('merit', array(
    'label' => 'Merit',
    'menu_icon' => 'dashicons-star-empty',
    'public' => true,
    'supports' => array('title', 'editor', 'page-attributes')
));

\register_post_type('game', array(
    'label' => 'Game',
    'menu_icon' => 'dashicons-tickets-alt',
    'public' => true,
    'supports' => array('title', 'page-attributes')
));

\register_taxonomy('merit_category', array('merit'), array(
    'label' => 'Category',
    'hierarchical' => true
));

\register_post_type('equipment', array(
    'label' => 'Equipment',
    'menu_icon' => 'dashicons-hammer',
    'public' => true,
    'supports' => array('title', 'page-attributes')
));
