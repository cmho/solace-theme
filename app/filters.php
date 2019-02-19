<?php
namespace App;

use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );
    return template_path(locate_template(["views/{$comments_template}", $comments_template]) ?: $comments_template);
}, 100);

function add_meta_keys_to_revision($keys)
{
    array_push(
        $keys,
        "intelligence",
        "wits",
        "resolve",
        "strength",
        "dexterity",
        "stamina",
        "presence",
        "manipulation",
        "composure",
        "academics",
        "computer",
        "crafts",
        "investigation",
        "medicine",
        "occult",
        "politics",
        "science",
        "athletics",
        "brawl",
        "drive",
        "firearms",
        "larceny",
        "stealth",
        "survival",
        "weaponry",
        "animal_ken",
        "empathy",
        "expression",
        "intimidation",
        "persuasion",
        "socialize",
        "streetwise",
        "subterfuge",
        "size",
        "armor",
        "merits",
        "skill_specialties",
        "health",
        "willpower",
        "current_health",
        "current_willpower",
        "conditions",
        "equipment",
        "merits",
        "backstory",
        "connections",
        "complications",
        "supernatural",
        "massacre",
        "survive",
        "loss",
        "hobbies",
        "coping",
        "anything_else"
    );
    return $keys;
}
add_filter('wp_post_revision_meta_keys', __NAMESPACE__.'\\add_meta_keys_to_revision');

function update_character()
{
    $config = \HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,br,b,a[href],i,em,strong,hr');
    $config->set('URI.MakeAbsolute', true);
    $purifier = new \HTMLPurifier($config);
    $post_content = array(
        'post_title' => $purifier->purify($_POST['post_title']),
        'post_author' => $purifier->purify($_POST['author']),
        'post_type' => 'character',
        'post_status' => 'publish',
        'meta_input' => array(
            'intelligence' => $purifier->purify($_POST['intelligence']),
            'wits' => $purifier->purify($_POST['wits']),
            'resolve' => $purifier->purify($_POST['resolve']),
            'strength' => $purifier->purify($_POST['strength']),
            'dexterity' => $purifier->purify($_POST['dexterity']),
            'stamina' => $purifier->purify($_POST['stamina']),
            'presence' => $purifier->purify($_POST['presence']),
            'manipulation' => $purifier->purify($_POST['manipulation']),
            'composure' => $purifier->purify($_POST['composure']),
            'family' => $purifier->purify($_POST['family']),
            'status' => $purifier->purify($_POST['status']),
            'virtue' => $purifier->purify($_POST['virtue']),
            'vice' => $purifier->purify($_POST['vice']),
            'quote' => $purifier->purify($_POST['quote']),
            'public_blurb' => $purifier->purify($_POST['public_blurb']),
            'academics' => $purifier->purify($_POST['academics']),
            'computer' => $purifier->purify($_POST['computer']),
            'crafts' => $purifier->purify($_POST['crafts']),
            'investigation' => $purifier->purify($_POST['investigation']),
            'medicine' => $purifier->purify($_POST['medicine']),
            'occult' => $purifier->purify($_POST['occult']),
            'politics' => $purifier->purify($_POST['politics']),
            'science' => $purifier->purify($_POST['science']),
            'athletics' => $purifier->purify($_POST['athletics']),
            'brawl' => $purifier->purify($_POST['brawl']),
            'drive' => $purifier->purify($_POST['drive']),
            'firearms' => $purifier->purify($_POST['firearms']),
            'larceny' => $purifier->purify($_POST['larceny']),
            'stealth' => $purifier->purify($_POST['stealth']),
            'survival' => $purifier->purify($_POST['survival']),
            'weaponry' => $purifier->purify($_POST['weaponry']),
            'animal_ken' => $purifier->purify($_POST['animal_ken']),
            'empathy' => $purifier->purify($_POST['empathy']),
            'expression' => $purifier->purify($_POST['expression']),
            'intimidation' => $purifier->purify($_POST['intimidation']),
            'leadership' => $purifier->purify($_POST['leadership']),
            'persuasion' => $purifier->purify($_POST['persuasion']),
            'streetwise' => $purifier->purify($_POST['streetwise']),
            'subterfuge' => $purifier->purify($_POST['subterfuge']),
            'size' => $purifier->purify($_POST['size']),
            'armor' => $purifier->purify($_POST['armor']),
            'integrity' => $purifier->purify($_POST['integrity']),
            'current_health' => $purifier->purify($_POST['current_health']),
            'current_willpower' => $purifier->purify($_POST['current_willpower']),
            'health' => intval($purifier->purify($_POST['health'])),
            'willpower' => intval($purifier->purify($_POST['willpower'])),
            "backstory" => !empty($_POST['backstory']) ? $purifier->purify($_POST['backstory']) : ' ',
            "connections" => !empty($_POST['connections']) ? $purifier->purify($_POST['connections']) : ' ',
            "complications" => !empty($_POST['complications']) ? $purifier->purify($_POST['complications']) : ' ',
            "supernatural" => !empty($_POST['supernatural']) ? $purifier->purify($_POST['supernatural']) : ' ',
            "massacre" => !empty($_POST['massacre']) ? $purifier->purify($_POST['massacre']) : ' ',
            "survive" => !empty($_POST['survive']) ? $purifier->purify($_POST['survive']) : ' ',
            "loss" => !empty($_POST['loss']) ? $purifier->purify($_POST['loss']) : ' ',
            "hobbies" => !empty($_POST['hobbies']) ? $purifier->purify($_POST['hobbies']) : ' ',
            "coping" => !empty($_POST['coping']) ? $purifier->purify($_POST['coping']) : ' ',
            "anything_else" => !empty($_POST['anything_else']) ? $purifier->purify($_POST['anything_else']) : ' ',
            "st_notes" => !empty($_POST['st_notes']) ? $purifier->purify($_POST['st_notes']) : ' '
        )
    );


    $merits = array();
    $skill_specialties = array();
    $conditions = array();

    for ($i = 0; $i < intval($purifier->purify($_POST['merits'])); $i++) {
        array_push($merits, array(
            'merit' => $purifier->purify($_POST['merits_'.$i.'_merit']),
            'rating' => $purifier->purify($_POST['merits_'.$i.'_rating']),
            'specification' => $purifier->purify($_POST['merits_'.$i.'_specification']),
            'description' => $purifier->purify($_POST['merits_'.$i.'_description'])
        ));
        $post_content['meta_input']['merits_'.$i.'_merit'] = $purifier->purify($_POST['merits_'.$i.'_merit']);
        $post_content['meta_input']['merits_'.$i.'_rating'] = $purifier->purify($_POST['merits_'.$i.'_rating']);
        $post_content['meta_input']['merits_'.$i.'_specification'] = $purifier->purify($_POST['merits_'.$i.'_specification']);
        $post_content['meta_input']['merits_'.$i.'_description'] = $purifier->purify($_POST['merits_'.$i.'_description']);
    }

    for ($j = 0; $j < intval($purifier->purify($_POST['skill_specialties'])); $j++) {
        array_push($skill_specialties, array(
            'skill' => $purifier->purify($_POST['skill_specialties_'.$j.'_skill']),
            'specialty' => $purifier->purify($_POST['skill_specialties_'.$j.'_specialty'])
        ));
        $post_content['meta_input']['skill_specialties_'.$j.'_skill'] = $purifier->purify($_POST['skill_specialties_'.$j.'_skill']);
        $post_content['meta_input']['skill_specialties_'.$j.'_specialty'] = $purifier->purify($_POST['skill_specialties_'.$j.'_specialty']);
    }

    for ($k = 0; $k < intval($purifier->purify($_POST['conditions'])); $k++) {
        array_push($conditions, array(
            'condition' => $purifier->purify($_POST['conditions_'.$k.'_condition']),
            'note' => $purifier->purify($_POST['conditions_'.$k.'_note'])
        ));
        $post_content['meta_input']['conditions_'.$k.'_condition'] = $purifier->purify($_POST['conditions_'.$k.'_condition']);
        $post_content['meta_input']['conditions_'.$k.'_note'] = $purifier->purify($_POST['conditions_'.$k.'_note']);
    }

    if (isset($_POST['id'])) {
        if (get_field('status', $_POST['id']) == 'Active' && !get_field('is_npc', $_POST['id'])) {
            // create revision for approval if it's a PC and the person saving it is not an admin
            $post_content['post_type'] = 'revision';
            $post_content['post_status'] = 'inherit';
            $revision_count = count(\wp_get_post_revisions($purifier->purify($_POST['id'])));
            $post_content['post_name'] = $purifier->purify($_POST['id']).'-revision-v'.($revision_count+1);
            $post_content['post_parent'] = $purifier->purify($_POST['id']);
            $post = \wp_insert_post($post_content);
            update_field('field_5bdcf2262be68', $merits, $post);
            update_field('field_5c45fac0556fc', $skill_specialties, $post);
            update_field('field_5bf216f2f5e3a', $conditions, $post);
            $updates = \get_post($post);
            // initiate experience expenditure as draft
            $char = \get_post($_POST['id']);
            $exp = \wp_insert_post(array(
                'post_type' => 'experience',
                'post_status' => 'draft',
                'post_title' => 'Experience for '.$char->post_title.', '.date('m/d/y'),
                'meta_input' => array(
                    'amount' => (Character::getExperienceCost($post) - Character::getExperienceCost($char)),
                    'character' => $purifier->purify($_POST['id'])
                )
            ));
            \add_post_meta($post->ID, 'experience_expenditure', $exp);
            $admins = \get_users(array(
                'role' => 'administrator'
            ));
            $message =
                "There's a new experience expenditure for ".$post->post_title.". To see and approve it, go here:
                    <a href='https://solacelarp.com/wp-admin/revision.php?revision=".$post;
            foreach ($admins as $admin) {
                \wp_mail($admin->user_email, '[Solace] New experience expenditure for '.$post->post_title, $message);
            }
            header('Location:'.\get_the_permalink($char));
            die(1);
        } else {
            $post_content['ID'] = $purifier->purify($_POST['id']);
        }
    }
    $post = \wp_insert_post($post_content);
    update_field('field_5bdcf2262be68', $merits, $post);
    update_field('field_5c45fac0556fc', $skill_specialties, $post);
    update_field('field_5bf216f2f5e3a', $conditions, $post);
    header('Location:'.get_the_permalink($post));

    die(1);
}

add_action('admin_post_update_character', __NAMESPACE__.'\\update_character');

function save_character_post($post_id)
{
    global $post;
    $post = get_post($post_id);
    if (get_post_type() == 'character') {
        $e = wp_update_post(array(
            'ID' => get_field('experience_expenditure'),
            'post_status' => 'publish'
        ));
    }
}

add_action('wp_restore_post_revision', __NAMESPACE__.'\\save_character_post');

function get_merit_info()
{
    $id = intval($_POST['id']);
    $post = \get_post($id);
    \setup_postdata($post);
    $obj = array(
        'id' => $id,
        'ratings' => get_field('allowed_ratings', $post),
        'name' => get_the_title($post),
        'has_specification' => get_field('requires_specification', $post),
        'has_description' => get_field('requires_description', $post),
        'description' => get_field('description', $post),
        'prerequisites' => get_field('prerequisites', $post)
    );
    header('Content-type: application/json');
    echo json_encode($obj);
    die(1);
}

add_action('wp_ajax_get_merit_info', __NAMESPACE__.'\\get_merit_info');
add_action('wp_ajax_nopriv_get_merit_info', __NAMESPACE__.'\\get_merit_info');

function mass_add_experience()
{
    $config = \HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,br,b,a[href],i,em,strong,hr');
    $config->set('URI.MakeAbsolute', true);
    $purifier = new \HTMLPurifier($config);
    $characters = get_posts(array(
        'posts_per_page' => -1,
        'post_type' => 'character',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'is_npc',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => 'status',
                'value' => 'Active',
                'compare' => '='
            )
        )
    ));

    foreach ($characters as $character) {
        wp_insert_post(array(
            'post_type' => 'experience',
            'post_title' => $purifier->purify($_POST['reason']),
            'meta_input' => array(
                'character' => $character->ID,
                'amount' => intval($purifier->purify($_POST['amount']))
            )
        ));
    }
    die(1);
}

add_action('admin_post_mass_add_experience', __NAMESPACE__.'\\mass_add_experience');

function add_experience()
{
    $config = \HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,br,b,a[href],i,em,strong,hr');
    $config->set('URI.MakeAbsolute', true);
    $purifier = new \HTMLPurifier($config);
    wp_insert_post(array(
        'post_type' => 'experience',
        'post_title' => $purifier->purify($_POST['reason']),
        'meta_input' => array(
            'character' => intval($purifier->purify($_POST['character'])),
            'amount' => intval($purifier->purify($_POST['amount']))
        )
    ));

    die(1);
}

add_action('admin_post_add_experience', __NAMESPACE__.'\\add_experience');

function update_downtime()
{
    $config = \HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,br,b,a[href],i,em,strong,hr');
    $config->set('URI.MakeAbsolute', true);
    $purifier = new \HTMLPurifier($config);
    print_r($purifier);
    $args = array(
        'post_type' => 'downtime',
        'ID' => intval($purifier->purify($_POST['id'])),
        'post_status' => 'publish',
        'post_author' => $purifier->purify($_POST['author']),
        'post_title' => $purifier->purify($_POST['post_title']),
        'post_content' => $purifier->purify($_POST['post_content']),
        'meta_input' => array(
            'character' => intval($purifier->purify($_POST['character'])),
            'game' => intval($purifier->purify($_POST['game'])),
            'goal' => $purifier->purify($_POST['goal']),
            'assets' => $purifier->purify($_POST['assets']),
            'action_type' => $purifier->purify($_POST['action_type'])
        )
    );

    $action = wp_insert_post($args);
    header('Location:'.get_permalink($action));
    die(1);
}

add_action('admin_post_update_downtime', __NAMESPACE__.'\\update_downtime');

function respond_to_downtime()
{
    $config = \HTMLPurifier_Config::createDefault();
    $config->set('HTML.Allowed', 'p,br,b,a[href],i,em,strong,hr');
    $config->set('URI.MakeAbsolute', true);
    $purifier = new \HTMLPurifier($config);
    $id = intval($_POST['id']);
    $args = array(
        'post_type' => 'downtime',
        'post_status' => 'publish',
        'ID' => $id,
        'meta_input' => array(
            'response' => $purifier->purify($_POST['response'])
        )
    );
    $action = wp_update_post($args);
    header('Location:'.get_permalink($id));
    die(1);
}

add_action('admin_post_downtime_response', __NAMESPACE__.'\\respond_to_downtime');

function delete_character()
{
    wp_delete_post($_POST['id'], false);
    header('Location:'.home_url('/')."dashboard/");
    die(1);
}

add_action('wp_ajax_delete_character', __NAMESPACE__.'\\delete_character');
add_action('wp_ajax_nopriv_delete_character', __NAMESPACE__.'\\delete_character');

function delete_downtime()
{
    wp_delete_post($_POST['id'], false);
    header('Location:'.home_url('/')."downtimes/");
}

add_action('admin_post_delete_downtime', __NAMESPACE__.'\\delete_downtime');
add_action('admin_post_nopriv_delete_downtime', __NAMESPACE__.'\\delete_downtime');

function updateHealth()
{
    wp_update_post(array(
        'ID' => $_POST['character'],
        'meta_input' => array(
            'current_health' => $_POST['current_health']
        )
    ));
    die(1);
}

add_action('wp_ajax_update_health', __NAMESPACE__.'\\updateHealth');

function updateWillpower()
{
    wp_update_post(array(
        'ID' => $_POST['character'],
        'meta_input' => array(
            'current_willpower' => $_POST['current_willpower']
        )
    ));
    die(1);
}

add_action('wp_ajax_update_willpower', __NAMESPACE__.'\\updateWillpower');

function updateIntegrity()
{
    wp_update_post(array(
        'ID' => $_POST['character'],
        'meta_input' => array(
            'integrity' => (get_field('integrity', intval($_POST['character']))-1)
        )
    ));
    echo get_field('integrity', intval($_POST['character']))-1;
    die(1);
}
add_action('wp_ajax_breaking_point', __NAMESPACE__.'\\updateIntegrity');

function addBeat()
{
    wp_insert_post(array(
        'post_type' => 'beat',
        'post_status' => 'publish',
        'meta_input' => array(
            'value' => 1,
        )
    ));
    echo \App\Beat::count();
    die(1);
}

add_action('wp_ajax_add_beat', __NAMESPACE__.'\\addBeat');

function getBeats()
{
    $beats = get_posts(array(
        'post_type' => 'beat',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));

    $total = array_reduce($beats, function ($c, $i) {
        return $c + get_field('value', $i->ID);
    }, 0);

    echo $total;
    die(1);
}

add_action('wp_ajax_get_beats', __NAMESPACE__.'\\getBeats');

function distributeBeats()
{
    wp_insert_post(array(
        'post_type' => 'beat',
        'post_status' => 'publish',
        'meta_input' => array(
            'value' => -100
        )
    ));
    $chars = get_posts(array(
        'post_type' => 'character',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'status',
                'value' => 'active'
            ),
            array(
                'key' => 'status',
                'value' => 'Active'
            )
        )
    ));

    foreach ($chars as $char) {
        wp_insert_post(array(
            'post_type' => 'experience',
            'post_title' => 'Beat pool disbursement '.date('m/d/y'),
            'post_status' => 'publish',
            'meta_input' => array(
                'amount' => 1,
                'character' => $char->ID
            )
        ));
    }

    echo \App\Beat::count();
    die(1);
}

add_action('wp_ajax_distribute_beats', __NAMESPACE__.'\\distributeBeats');

function addCondition()
{
    $char = get_post($_POST['character']);
    $conditions = get_field('conditions', $char->ID);
    if (!$conditions) {
        $conditions = array();
    }
    array_push($conditions, array(
        'condition' => $_POST['condition'],
        'note' => $_POST['note']
    ));
    update_field('conditions', $conditions, $char->ID);
    echo json_encode(get_field('conditions', $char->ID));
    die(1);
}

add_action('wp_ajax_add_condition', __NAMESPACE__.'\\addCondition');

function resolveCondition()
{
    return;
}

add_action('wp_ajax_resolve_condition', __NAMESPACE__.'\\resolveCondition');

function characterData()
{
    global $post;
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'character',
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'relation' => 'OR',
                array(
                    'key' => 'is_secret',
                    'value' => true,
                    'compare' => '!='
                ),
                array(
                    'key' => 'is_secret',
                    'compare' => 'NOT EXISTS'
                )
            ),
            array(
                'key' => 'status',
                'value' => 'Active',
                'compare' => '='
            )
        )
    );

    $posts = get_posts($args);
    $arr = array();
    foreach ($posts as $post) {
        setup_postdata($post);
        array_push($arr, array(
            'id' => $post->ID,
            'current_health' => get_field('current_health'),
            'current_willpower' => get_field('current_willpower'),
            'integrity' => get_field('integrity'),
            'conditions' => get_field('conditions')
        ));
    }
    wp_reset_postdata();
    echo json_encode($arr);
    die(1);
}

add_action('wp_ajax_get_character_data', __NAMESPACE__.'\\characterData');

function custom_rewrite_tag()
{
    add_rewrite_tag('%game%', '([^&]+)');
    add_rewrite_tag('%character%', '([^&]+)');
    add_rewrite_tag('%downtime%', '([^&]+)');
    add_rewrite_tag('%mode%', '([^&]+)');
}
add_action('init', __NAMESPACE__.'\\custom_rewrite_tag', 10, 0);

function custom_rewrites()
{
    add_rewrite_rule('character/([^/]+)/edit/?$', 'index.php?character=$matches[1]&mode=edit', 'top');
    add_rewrite_rule('downtime/([^/]+)/edit/?$', 'index.php?downtime=$matches[1]&mode=edit', 'top');
    add_rewrite_rule('game/([^/]+)/rumors/?$', 'index.php?game=$matches[1]&view=rumors', 'top');
    add_rewrite_rule('game/([^/]+)/downtimes/?$', 'index.php?game=$matches[1]&view=downtimes', 'top');
}
add_action('init', __NAMESPACE__.'\\custom_rewrites', 10, 0);

function ajax_login_init()
{
    add_action('wp_ajax_nopriv_ajaxlogin', __NAMESPACE__.'\\ajax_login');
}

function ajax_login()
{
    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die(1);
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', __NAMESPACE__.'\\ajax_login_init');
}

function getCharacterData()
{
    $user = wp_get_current_user();
    if (!$user) {
        die(1);
        return;
    }

    $char = get_post(intval($_GET['id']));
    if ($user->ID == $char->post_author || in_array('administrator', $user->roles)) {
        $blade = new Blade('templates');
        echo $blade->make('partials.content-dashboard-character', array('char' => $char));
    }
    die(1);
}

function addCharacterDataApi()
{
    register_rest_route('solace/v1', 'characters?id=([0-9]+)', array(
        'methods' => 'POST',
        'callback' => 'getCharacterData'
    ));

    register_rest_route('solace/v1', 'downtimes?char_id=([0-9]+)', array(
        'methods' => 'GET',
        'callback' => 'getDowntimesData'
    ));

    register_rest_route('solace/v1', 'rumors?char_id=([0-9]+)', array(
        'methods' => 'GET',
        'callback' => 'getRumorsData'
    ));
}

add_action('rest_api_init', __NAMESPACE__.'\\addCharacterDataApi');
