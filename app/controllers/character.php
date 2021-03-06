<?php

namespace App;

use Sober\Controller\Controller;

class Character extends Controller
{
    public static function experienceRecords()
    {
        $character = get_the_ID();
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'experience',
            'meta_query' => array(
                array(
                    'key' => 'character',
                    'value' => $character
                )
            )
        );
        return \get_posts($args);
    }

    public static function sumExperience()
    {
        $character = get_the_ID();
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'experience',
            'meta_query' => array(
                array(
                    'key' => 'character',
                    'value' => $character
                )
            )
        );

        $exp = \get_posts($args);
        $sum = 0;
        foreach ($exp as $e) {
            $sum += get_field('amount', $e);
        }
        return $sum;
    }

    public static function getExperienceCost($character)
    {
        $attributes =
            ((get_field('intelligence', $character)+get_field('wits', $character)+get_field('resolve', $character)
            +get_field('strength', $character)+get_field('dexterity', $character)+get_field('stamina', $character)
            +get_field('presence', $character)+get_field('manipulation', $character)+get_field('composure', $character))
            - 10)*4;
        $skills =
            (get_field('academics', $character)+get_field('computer', $character)+get_field('crafts', $character)
            +get_field('investigation', $character)+get_field('medicine', $character)+get_field('occult', $character)
            +get_field('politics', $character)+get_field('science', $character)+get_field('athletics', $character)
            +get_field('brawl', $character)+get_field('drive', $character)+get_field('firearms', $character)
            +get_field('larceny', $character)+get_field('stealth', $character)+get_field('survival', $character)
            +get_field('weaponry', $character)+get_field('animal_ken', $character)+get_field('empathy', $character)
            +get_field('expression', $character)+get_field('intimidation', $character)+get_field('persuasion', $character)
            +get_field('socialize', $character)+get_field('streetwise', $character)+get_field('subterfuge', $character)
            - 22)*2;
        $merits;
        foreach (get_field('merits', $character) as $merit) {
            $merits += $merit['rating'];
        }
        $merits -= 17;
        return $attributes + $skills + $merits;
    }

    public static function printDots($amt = 0)
    {
        for ($i = 1; $i <= 5; $i++) {
            if ($i > $amt) {
                echo '<i class="far fa-circle"></i>';
            } else {
                echo '<i class="fas fa-circle"></i>';
            }
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }

    public static function printDotsTen($amt = 0)
    {
        for ($i = 1; $i <= 10; $i++) {
            if ($i > $amt) {
                echo '<i class="far fa-circle"></i>';
            } else {
                echo '<i class="fas fa-circle"></i>';
            }
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }

    public static function printSquares($amt)
    {
        for ($i = 1; $i <= $amt; $i++) {
            echo '<i class="far fa-square"></i>';
        }
        echo '<span class="sr-only">'.$amt.'</span>';
    }

    public static function printSquaresInteractable($str = null)
    {
        $split = str_split($str);
        $bashing = 0;
        $lethal = 0;
        $agg = 0;

        for ($i = 0; $i < count($split); $i++) {
            echo '<a href="#" class="fa-stack">';
            echo '<i class="far fa-square fa-stack-1x"></i>';

            if (intval($split[$i]) == 0) {
                echo '<i class="fas fa-stack-1x indicator"></i></a>';
            } elseif (intval($split[$i]) == 1) {
                echo '<i class="fas fa-slash fa-stack-1x indicator"></i></a>';
                $bashing++;
            } elseif (intval($split[$i]) == 2) {
                echo '<i class="fas fa-times fa-stack-1x indicator"></i></a>';
                $lethal++;
            } elseif (intval($split[$i]) == 3) {
                echo '<i class="fas fa-asterisk fa-stack-1x indicator"></i></a>';
                $agg++;
            }
        }
        echo '<span class="sr-only">'.$bashing.' bashing, '.$lethal.' lethal, '.$agg.' aggravated</span>';
    }

    public static function questionnaire()
    {
        global $post;
        $questionnaire = array();
        array_push($questionnaire, get_field_object('field_5bf38a8987e1d')); // backstory
        array_push($questionnaire, get_field_object('field_5c36bd1092798')); // connections
        array_push($questionnaire, get_field_object('field_5bf38ac987e1e')); // complications
        array_push($questionnaire, get_field_object('field_5c36bd4792799')); // supernatural
        array_push($questionnaire, get_field_object('field_5bf38ae787e1f')); // massacre
        array_push($questionnaire, get_field_object('field_5bf38b0687e20')); // survive
        array_push($questionnaire, get_field_object('field_5bf38b3187e21')); // loss
        array_push($questionnaire, get_field_object('field_5bf38b3d87e22')); // hobbies
        array_push($questionnaire, get_field_object('field_5bf38b4987e23')); // coping
        array_push($questionnaire, get_field_object('field_5c36bd6d9279a')); // anything else
        return $questionnaire;
    }

    public static function hasDefensiveCombat($char)
    {
        return array_values(array_filter(get_field('merits', $char), function ($m) {
            if ($m['merit']->post_title == "Defensive Combat") {
                return true;
            }
            return false;
        }));
    }

    public static function getDefensiveCombatCalc($instance, $char)
    {
        $type = strtolower($instance['specification']);
        return min(get_field('wits', $char), get_field('dexterity', $char))+get_field($type, $char);
    }

    public static function initiativeFinal($char)
    {
        $base = get_field('dexterity', $char)+get_field('composure', $char);
        $equip = get_field('equipment', $char);
        foreach ($equip as $e) {
            if (get_field('initiative_modifier', $e['item'])) {
                $base += get_field('initiative_modifier', $e['item']);
            }
        }

        return $base;
    }

    public static function defenseFinal($char)
    {
        $base = min(get_field('wits', $char), get_field('dexterity', $char))+get_field('athletics', $char);
        $equip = get_field('equipment', $char);
        foreach ($equip as $e) {
            if (get_field('defense', $e['item'])) {
                $base += get_field('defense', $e['item']);
            }
        }

        return $base;
    }

    public static function speedFinal($char)
    {
        $base = get_field('strength', $char)+5;
        $equip = get_field('equipment', $char);
        foreach ($equip as $e) {
            if (get_field('speed', $e['item'])) {
                $base += get_field('speed', $e['item']);
            }
        }

        return $base;
    }

    public static function getArmorGeneral($char)
    {
        $base = 0;
        $equip = get_field('equipment', $char);
        foreach ($equip as $e) {
            if (get_field('general_armor', $e['item'])) {
                $base += get_field('general_armor', $e['item']);
            }
        }

        return $base;
    }

    public static function getArmorBallistic($char)
    {
        $base = 0;
        $equip = get_field('equipment', $char);
        foreach ($equip as $e) {
            if (get_field('ballistic_armor', $e['item'])) {
                $base += get_field('ballistic_armor', $e['item']);
            }
        }

        return $base;
    }

    public static function currentChar()
    {
        $author = wp_get_current_user();
        $chars = \get_posts(array(
            'post_type' => 'character',
            'posts_per_page' => 1,
            'author' => $author->ID,
            'meta_query' => array(
                array(
                    'key' => 'status',
                    'value' => 'Active'
                )
            )
        ));
        if ($chars) {
            return $chars[0];
        }
        return null;
    }

    public static function mentalSkillsSimple($id)
    {
        $skills = array();
        $skills['Academics'] = get_field('academics', $id);
        $skills['Crafts'] = get_field('crafts', $id);
        $skills['Computer'] = get_field('computer', $id);
        $skills['Investigation'] = get_field('investigation', $id);
        $skills['Medicine'] = get_field('medicine', $id);
        $skills['Occult'] = get_field('occult', $id);
        $skills['Politics'] = get_field('politics', $id);
        $skills['Science'] = get_field('science', $id);
        $skills = array_filter($skills, function ($c, $k) {
            if ($c != 0) {
                return 1;
            }
            return 0;
        }, ARRAY_FILTER_USE_BOTH);
        $skills = array_map(function ($k, $v) use ($id) {
            return (Character::hasAssetSkill($id, $k) ? '*' : '').$k." ".$v;
        }, array_keys($skills), $skills);
        return join(", ", $skills);
    }

    public static function physicalSkillsSimple($id)
    {
        $skills = array();
        $skills['Athletics'] = get_field('athletics', $id);
        $skills['Brawl'] = get_field('brawl', $id);
        $skills['Drive'] = get_field('drive', $id);
        $skills['Firearms'] = get_field('firearms', $id);
        $skills['Larceny'] = get_field('larceny', $id);
        $skills['Stealth'] = get_field('stealth', $id);
        $skills['Survival'] = get_field('survival', $id);
        $skills['Weaponry'] = get_field('weaponry', $id);
        $skills = array_filter($skills, function ($c, $k) {
            if ($c != 0) {
                return 1;
            }
            return 0;
        }, ARRAY_FILTER_USE_BOTH);
        $skills = array_map(function ($k, $v) use ($id) {
            return (Character::hasAssetSkill($id, $k) ? '*' : '').$k." ".$v;
        }, array_keys($skills), $skills);
        return join(", ", $skills);
    }
    public static function socialSkillsSimple($id)
    {
        $skills = array();
        $skills['Animal Ken'] = get_field('animal_ken', $id);
        $skills['Empathy'] = get_field('empathy', $id);
        $skills['Expression'] = get_field('expression', $id);
        $skills['Intimidation'] = get_field('intimidation', $id);
        $skills['Leadership'] = get_field('leadership', $id);
        $skills['Persuasion'] = get_field('persuasion', $id);
        $skills['Streetwise'] = get_field('streetwise', $id);
        $skills['Subterfuge'] = get_field('subterfuge', $id);
        $skills = array_filter($skills, function ($c, $k) {
            if ($c != 0) {
                return 1;
            }
            return 0;
        }, ARRAY_FILTER_USE_BOTH);
        $skills = array_map(function ($k, $v) use ($id) {
            return (Character::hasAssetSkill($id, $k) ? '*' : '').$k." ".$v;
        }, array_keys($skills), $skills);
        return join(", ", $skills);
    }

    public static function skillSpecialtiesSimple($id)
    {
        $sksps = get_field('skill_specialties', $id);
        $sksps = array_merge($sksps, Character::getSubSkillSpecialties($id));
        $sksps = array_map(function ($ss) {
            return $ss['skill'].": ".$ss['specialty'];
        }, $sksps);
        return join(", ", $sksps);
    }

    public static function meritsSimple($id)
    {
        $merits = get_field('merits', $id);
        $merits = array_map(function ($m) {
            $merit = get_post($m['merit']->ID);
            return '<a class="js-modal merit-link" href="#" data-id="'.$m['merit']->ID.'" data-modal-content-id="merits-modal">'.get_the_title($merit->ID)."</a> ".(count(get_field('allowed_ratings', $merit->ID)) > 1 ? $m['rating'] : '').($m['specification'] ? ' ('.$m['specification'].')' : '');
        }, $merits);
        return join(", ", $merits);
    }

    public static function getRumors($char, $game)
    {
        $args = array(
            'post_type' => 'rumor',
            'posts_per_page' =>  -1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'characters',
                    'value' => $char,
                    'compare' => 'IN'
                ),
                array(
                    'key' => 'game',
                    'value' => $game
                )
            )
        );
        return \get_posts($args);
    }

    public static function printSkills($char)
    {
        $skills = array(
            'mental' => array(
                'academics',
                'computer',
                'crafts',
                'investigation',
                'medicine',
                'occult',
                'politics',
                'science'
            ),
            'physical' => array(
                'athletics',
                'brawl',
                'drive',
                'firearms',
                'larceny',
                'stealth',
                'survival',
                'weaponry'
            ),
            'social' => array(
                'animal_ken',
                'empathy',
                'expression',
                'intimidation',
                'leadership',
                'persuasion',
                'streetwise',
                'subterfuge'
            )
        );

        foreach ($skills as $skill_cat => $skill_list) {
            echo "<h4>".ucwords(str_replace('_', ' ', $skill_cat))."</h4>";
            foreach ($skill_list as $skill) {
                echo '<div class="row between-xs middle-xs">';
                echo '<label>';
                if (Character::hasAssetSkill($char, $skill)) {
                    echo '* ';
                }
                echo ucwords(str_replace('_', ' ', $skill)).'</label>';
                echo '<div class="dots">';
                Character::printDots(get_field($skill, $char));
                echo '</div>';
                echo '</div>';
            }
        }
    }

    public static function getDowntimes($char, $game)
    {
        $args = array(
            'post_type' => 'downtime',
            'posts_per_page' =>  -1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'character',
                    'value' => $char
                ),
                array(
                    'key' => 'game',
                    'value' => $game
                )
            )
        );
        return \get_posts($args);
    }

    public static function hasAssetSkill($id, $skill)
    {
        return in_array(ucwords(str_replace("_", " ", $skill)), get_field('asset_skills', $id));
    }

    public static function getSubMerits($id)
    {
        $merits = get_field('merits', $id);
        $extra_merits = array();
        foreach ($merits as $m) {
            $merit = $m['merit'];
            if (get_field('additional_benefits', $merit->ID)) {
                foreach (get_field('additional_benefits', $merit->ID) as $b) {
                    if ($b['type'] == 'Merit') {
                        $nm = array(
                            'merit' => $b['merit']
                        );
                        if (isset($b['rating'])) {
                            $nm['rating'] = $b['rating'];
                        }
                        if (isset($b['specification'])) {
                            $nm['specification'] = $b['specification'];
                        }
                        array_push($extra_merits, $nm);
                    }
                }
            }
        }
        return $extra_merits;
    }

    public static function getSubSkillSpecialties($id)
    {
        $merits = get_field('merits', $id);
        $extra_sksps = array();
        if ($merits) {
            foreach ($merits as $m) {
                $merit = $m['merit'];
                if (get_field('additional_benefits', $merit->ID)) {
                    foreach (get_field('additional_benefits', $merit->ID) as $i => $b) {
                        foreach ($b['benefits'] as $j => $benefit) {
                            if ($benefit['type'] == 'Skill Specialty') {
                                if ($benefit['player-defined']) {
                                    $nss = array(
                                        'skill' => $m['additional_specifications'][$i]['specifications'][$j]['skill'],
                                        'specialty' => $m['additional_specifications'][$i]['specifications'][$j]['specification']
                                    );
                                } else {
                                    $nss = array(
                                        'skill' => ucwords($benefit['skill']),
                                        'specialty' => $benefit['specialty']
                                    );
                                }
                                array_push($extra_sksps, $nss);
                            }
                        }
                    }
                }
            }
        }
        return $extra_sksps;
    }
}
