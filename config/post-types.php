<?php

namespace App;

use Roots\Sage\Container;

\register_post_type('event', array(
    'label' => 'Event',
    'public' => true,
    'supports' => array('revisions', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes')
));

\register_post_type('character', array(
    'label' => 'Character',
    'public'=> true,
    'supports' => array('revisions', 'title', 'editor', 'page-attributes')
));

\register_post_type('downtime', array(
    'label' => 'Downtime Action',
    'public' => true,
    'supports' => array('revisions', 'title', 'editor', 'page-attributes')
));

\register_post_type('merit', array(
    'label' => 'Merit',
    'public' => true,
    'supports' => array('title', 'editor', 'page-attributes')
));

\register_post_type('game', array(
    'label' => 'Game',
    'public' => true,
    'supports' => array('title', 'page-attributes')
));

\register_taxonomy('merit_category', array('merit'), array(
    'label' => 'Category',
    'hierarchical' => true
));
