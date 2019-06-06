<?php
namespace App;

use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

global $post;

function set_html_mail_content_type()
{
    return 'text/html';
}
add_filter('wp_mail_content_type', __NAMESPACE__.'\\set_html_mail_content_type');

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
        "anything_else",
        "status"
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
            'intelligence' => intval($_POST['intelligence']),
            'wits' => intval($_POST['wits']),
            'resolve' => intval($_POST['resolve']),
            'strength' => intval($_POST['strength']),
            'dexterity' => intval($_POST['dexterity']),
            'stamina' => intval($_POST['stamina']),
            'presence' => intval($_POST['presence']),
            'manipulation' => intval($_POST['manipulation']),
            'composure' => intval($_POST['composure']),
            'family' => $purifier->purify($_POST['family']),
            'status' => $purifier->purify($_POST['status']),
            'virtue' => $purifier->purify($_POST['virtue']),
            'vice' => $purifier->purify($_POST['vice']),
            'quote' => $purifier->purify($_POST['quote']),
            'public_blurb' => $purifier->purify($_POST['public_blurb']),
            'academics' => intval($_POST['academics']),
            'computer' => intval($_POST['computer']),
            'crafts' => intval($_POST['crafts']),
            'investigation' => intval($_POST['investigation']),
            'medicine' => intval($_POST['medicine']),
            'occult' => intval($_POST['occult']),
            'politics' => intval($_POST['politics']),
            'science' => intval($_POST['science']),
            'athletics' => intval($_POST['athletics']),
            'brawl' => intval($_POST['brawl']),
            'drive' => intval($_POST['drive']),
            'firearms' => intval($_POST['firearms']),
            'larceny' => intval($_POST['larceny']),
            'stealth' => intval($_POST['stealth']),
            'survival' => intval($_POST['survival']),
            'weaponry' => intval($_POST['weaponry']),
            'animal_ken' => intval($_POST['animal_ken']),
            'empathy' => intval($_POST['empathy']),
            'expression' => intval($_POST['expression']),
            'intimidation' => intval($_POST['intimidation']),
            'leadership' => intval($_POST['leadership']),
            'persuasion' => intval($_POST['persuasion']),
            'streetwise' => intval($_POST['streetwise']),
            'subterfuge' => intval($_POST['subterfuge']),
            'size' => intval($_POST['size']),
            'armor' => intval($_POST['armor']),
            'integrity' => intval($_POST['integrity']),
            'current_health' => $_POST['current_health'],
            'current_willpower' => $_POST['current_willpower'],
            'health' => intval(intval($_POST['health'])),
            'willpower' => intval(intval($_POST['willpower'])),
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
        $ab = array();
        $addl_benefits = get_field('additional_benefits', intval($_POST['merits_'.$i.'_merit']));
        if ($addl_benefits) {
            foreach ($addl_benefits as $b) {
                $arr = array(
                    'rating' => $b['rating'],
                    'specifications' => array()
                );
                foreach ($b['benefits'] as $j => $benefit) {
                    if ($benefit['player-defined'] == true) {
                        array_push($arr['specifications'], array(
                            'index' => $j,
                            'specification' => $purifier->purify($_POST['merits_'.$i.'_benefit_def_'.$b['rating'].'_'.$j]),
                            'skill' => isset($_POST['merits_'.$i.'_benefit_def_'.$b['rating'].'_'.$j.'_skill']) ? $purifier->purify($_POST['merits_'.$i.'_benefit_def_'.$b['rating'].'_'.$j.'_skill']) : ''
                        ));
                    }
                }
                array_push($ab, $arr);
            }
        }
        array_push($merits, array(
            'merit' => intval($_POST['merits_'.$i.'_merit']),
            'rating' => intval($_POST['merits_'.$i.'_rating']),
            'specification' => $purifier->purify($_POST['merits_'.$i.'_specification']),
            'description' => $purifier->purify($_POST['merits_'.$i.'_description']),
            'additional_specifications' => $ab
        ));
    }

    for ($j = 0; $j < intval($_POST['skill_specialties']); $j++) {
        array_push($skill_specialties, array(
            'skill' => $purifier->purify($_POST['skill_specialties_'.$j.'_skill']),
            'specialty' => $purifier->purify($_POST['skill_specialties_'.$j.'_specialty'])
        ));
    }

    for ($k = 0; $k < intval($_POST['conditions']); $k++) {
        array_push($conditions, array(
            'condition' => intval($_POST['conditions_'.$k.'_condition']),
            'note' => $purifier->purify($_POST['conditions_'.$k.'_note'])
        ));
    }

    if (isset($_POST['id'])) {
        if (get_field('status', $_POST['id']) == 'Active' && !get_field('is_npc', $_POST['id'])) {
            // create revision for approval if it's a PC and the person saving it is not an admin
            $post_content['post_type'] = 'revision';
            $post_content['post_status'] = 'inherit';
            $revision_count = count(\wp_get_post_revisions(intval($_POST['id'])));
            $post_content['post_name'] = intval($_POST['id']).'-revision-v'.($revision_count+1);
            $post_content['post_parent'] = intval($_POST['id']);
            $post = \wp_insert_post($post_content);
            update_field('field_5bdcf2262be68', $merits, $post);
            update_field('field_5c45fac0556fc', $skill_specialties, $post);
            update_field('field_5bf216f2f5e3a', $conditions, $post);
            $updates = \get_post($post);
            // initiate experience expenditure as draft
            $char = \get_post($_POST['id']);
            /*$exp = \wp_insert_post(array(
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
                "There's a new experience expenditure for ".get_post($post)->post_title.". To see and approve it, go
                    <a href='https://solacelarp.com/wp-admin/revision.php?revision=".$post.">here</a>.";
            foreach ($admins as $admin) {
                \wp_mail(
                    $admin->user_email,
                    '[Solace] New experience expenditure for '.get_post($post)->post_title,
                    "<h2>".'New experience expenditure for '.
                    get_post($post)->post_title."</h2>".$message
                );
            }*/
            header('Location:'.\get_the_permalink($char));
            die(1);
        } else {
            $p = intval($_POST['id']);
            $po = get_post($p);
            if ((get_field('status', $p) == 'In Progress') && ($_POST['status'] == 'Submitted')) {
                $message =
                "There's a new character submission from ".get_the_author_meta('nickname', $po->post_author).": ".
                $po->post_title.". To review it, go <a href='".get_the_permalink($p)."'>here</a>";
                $admins = \get_users(array(
                    'role' => 'administrator'
                ));
                foreach ($admins as $admin) {
                    \wp_mail(
                        $admin->user_email,
                        '[Solace] New character submission from '.
                        get_the_author_meta('nickname', $po->post_author).': '.$po->post_title,
                        "<h2>".'New character submission from '.
                        get_the_author_meta('nickname', $po->post_author).' :'.
                        $po->post_title."</h2>".$message
                    );
                }
            }
            $post_content['ID'] = intval($_POST['id']);
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

function sendAcceptanceEmails()
{
    $chars = get_posts(array(
        'post_type' => 'character',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'status',
                'value' => 'Active'
            ),
            array(
                'relation' => 'OR',
                array(
                    'key' => 'approval_sent',
                    'value' => true,
                    'compare' => '!='
                ),
                array(
                    'key' => 'approval_sent',
                    'compare' => 'NOT EXISTS'
                )
            )
        )
    ));
    if ($chars) {
        foreach ($chars as $char) {
            $user = \get_user_by('id', $char->post_author);
            $message = "Hi, ".$user->display_name."!<br /><br />We are excited to inform you that your character has been approved! Please visit our website to review our code of conduct before game one. If you have any questions please send us an email and we are looking forward to seeing your character’s story unfold.<br /><br />Best,<br />The Solace ST Team<br />storytellers@solacelarp.com";
            \wp_mail(
                $user->user_email,
                '[Solace] Character Approved: '.$char->post_title,
                "<h2>".'Character Approved: '.
                $char->post_title."</h2>".$message
            );
            \update_field('approval_sent', true, $char);
        }
    }
    die(1);
}

add_action('wp_ajax_send_approvals', __NAMESPACE__.'\\sendAcceptanceEmails');

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
        'prerequisites' => get_field('prerequisites', $post),
        'prerequisites_list' => get_field('prerequisites_list', $post),
        'additional_benefits' => get_field('additional_benefits', $post)
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
    $args = array(
        'post_type' => 'downtime',
        'ID' => intval($_POST['id']),
        'post_status' => 'publish',
        'post_author' => intval($_POST['author']),
        'post_title' => $purifier->purify($_POST['post_title']),
        'post_content' => $purifier->purify($_POST['post_content']),
        'meta_input' => array(
            'character' => intval($_POST['character']),
            'game' => intval($_POST['game']),
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

function getEvents()
{
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);
    $posts = array_map(function ($c) {
        return array(
            'date' => get_field('date', $c->ID),
            'title' => get_the_title($c->ID),
            'url' => get_the_permalink($c->ID)
        );
    }, $posts);
    return json_encode($posts);
    die(1);
}

add_action('wp_ajax_get_events', __NAMESPACE__.'\\getEvents');
add_action('wp_ajax_nopriv_get_events', __NAMESPACE__.'\\getEvents');

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

function snapshotIntegrity()
{
    $characters = \App\Characters::getActivePCs();
    $integrities = array();
    foreach ($characters as $character) {
        array_push($integrities, array(
            'character' => $character->ID,
            'integrity' => get_field('integrity', $character->ID)
        ));
    }
    $p = wp_insert_post(array(
        'post_type' => 'integrity_snapshot',
        'post_status' => 'publish'
    ));

    update_field('field_5ca7f5f6617d5', $integrities, $p);
}

add_action('wp_ajax_snapshot_integrity', __NAMESPACE__.'\\snapshotIntegrity');

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
    $c = array_map(function ($x) {
        return array(
            'condition' => $x['condition']->post_title,
            'note' => $x['note']
        );
    }, get_field('conditions', $char->ID));
    echo json_encode($c);
    die(1);
}

add_action('wp_ajax_add_condition', __NAMESPACE__.'\\addCondition');

function resolveCondition()
{
    $char = get_post($_POST['character']);
    $conditions = get_field('conditions', $char->ID);
    $cond = array_splice($conditions, intval($_POST['condition']), 1);
    if (get_field('resolution', $cond[0]['condition']->ID) && empty($_POST['delete'])) {
        wp_insert_post(array(
            'post_type' => 'beat',
            'post_status' => 'publish',
            'meta_input' => array(
                'value' => 1,
            )
        ));
    }
    update_field('conditions', $conditions, $char->ID);
    $c = array_map(function ($x) {
        return array(
            'condition' => $x['condition']->post_title,
            'note' => $x['note']
        );
    }, get_field('conditions', $char->ID));
    echo json_encode($c);
    die(1);
    return;
}

add_action('wp_ajax_resolve_condition', __NAMESPACE__.'\\resolveCondition');

function addEquipment()
{
    $char = get_post($_POST['character']);
    $equipment = get_field('equipment', $char->ID);
    if (!$equipment) {
        $equipment = array();
    }
    array_push($equipment, array(
        'item' => $_POST['item'],
        'uses' => $_POST['uses'],
        'note' => $_POST['note']
    ));
    update_field('equipment', $equipment, $char->ID);
    $c = array_map(function ($x) {
        return array(
            'item' => get_post($x['item'])->post_title,
            'type' => get_field('type', $x['item']),
            'initiative_modifier' => get_field('initiative_modifier', $x['item']),
            'durability' => get_field('durability', $x['item']),
            'damage' => get_field('damage', $x['item']),
            'required_strength' => get_field('required_strength', $x['item']),
            'clip_size' => get_field('clip_size', $x['item']),
            'general_armor' => get_field('general_armor', $x['item']),
            'ballistic_armor' => get_field('ballistic_armor', $x['item']),
            'defense' => get_field('defense', $x['item']),
            'speed' => get_field('speed', $x['item']),
            'cost' => get_field('cost', $x['item']),
            'qualities' => get_field('qualities', $x['item']),
            'uses' => $x['uses'],
            'note' => $x['note']
        );
    }, \App\Equipment::sortEquipment(get_field('equipment', $char->ID)));
    echo json_encode($c);
    die(1);
}

add_action('wp_ajax_add_equipment', __NAMESPACE__.'\\addEquipment');

function skillSpData()
{
    $id = intval($_POST['id']);
    $content = '';
    foreach (get_field('skill_specialties', $id) as $i => $sksp) {
        $content .= '<li><strong class="skill">'.$sksp['skill'].':</strong> <span class="specialty">'.$sksp['specialty'].'</span> <button type="button" class="delete"><i class="fas fa-trash"></i></button><input type="hidden" name="skill_specialties_'.$i.'_skill" value="'.$sksp['skill'].'" /><input type="hidden" name="skill_specialties_'.$i.'_specialty" value="'.$sksp['specialty'].'" /></li>';
    }
    if (\App\Character::getSubSkillSpecialties($id)) {
        foreach (\App\Character::getSubSkillSpecialties($id) as $sksp) {
            $content .= '<li data-phantom="true"><strong class="skill">'.$sksp['skill'].':</strong> <span class="specialty">'.$sksp['specialty'].'</span></li>';
        }
    }
    return $content;
}
add_action('wp_ajax_get_skill_specialties', __NAMESPACE__.'\\skillSpData');

function updateNotes()
{
    global $post;
    $post = get_post($_POST['character']);
    update_field('st_notes', $_POST['notes'], $post->ID);
    die(1);
}

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
            'conditions' => get_field('conditions'),
            'st_notes' => get_field('st_notes')
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

function get_dashboard_characters()
{
    $posts = \get_posts(array(
        'post_type' => 'character',
        'posts_per_page' => -1,
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
                'key' => 'is_npc',
                'value' => true,
                'compare' => '!='
            ),
            array(
                'key' => 'status',
                'value' => 'Active',
                'compare' => '='
            )
        )
    ));

    $posts = array_map(function ($c) {
        $c->meta_content = get_fields($c->ID);
        return $c;
    }, $posts);
    header('Access-Control-Allow-Origin: *');
    echo json_encode($posts);
    die(1);
}

function get_dashboard_beats()
{
    $beats = array_sum(array_map(function ($x) {
        return \get_field('value', $x->ID);
    }, get_posts(array(
        'post_type' => 'beat',
        'posts_per_page' => -1
    ))));
    header('Access-Control-Allow-Origin: *');
    echo($beats);
    die(1);
}

function doHealing()
{
    global $post;
    $weeks = intval($_POST['weeks']);
    $characters = \App\Characters::getActivePCs();
    foreach ($characters as $post) {
        $weekcount = $weeks;
        $lethalcount = 0;
        setup_postdata($post);
        $wp = join("", array_fill(0, get_field('willpower'), '0'));
        update_field('current_willpower', $wp, $post->ID);
        $health = array_map(intval, array_reverse(str_split(get_field('current_health'))));
        for ($i = 0; $i < count($health); $i++) {
            if ($health[$i] == 1) {
                $health[$i] = "0";
            } elseif ($weekcount > 0) {
                if ($health[$i] == 2) {
                    $lethalcount++;
                    $health[$i] = "0";
                    if ($lethalcount > 3) {
                        $weekcount--;
                    }
                } elseif ($health[$i] == 3) {
                    $health[$i] = "0";
                    $weekcount--;
                }
            } else {
                break;
            }
        }
        update_field('current_health', join("", array_map(strval, array_reverse($health))), $post->ID);
    }
    wp_reset_postdata();
    die(1);
}

add_action('wp_ajax_do_healing', __NAMESPACE__.'\\doHealing');

add_action('rest_api_init', function () {
    register_rest_route('solace/v1', 'dashboard/characters', array(
        'methods' => 'GET',
        'callback' => __NAMESPACE__.'\\get_dashboard_characters'
    ));

    register_rest_route('solace/v1', 'dashboard/beats', array(
        'methods' => 'GET',
        'callback' => __NAMESPACE__.'\\get_dashboard_beats'
    ));
});

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
