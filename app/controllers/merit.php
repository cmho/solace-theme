<?php

namespace App;

use Sober\Controller\Controller;

class Merit extends Controller
{
    public static function dots()
    {
        $allowed = get_field('allowed_ratings');
        $out = "";
        $last;
        $count = 0;
        if (count($allowed) > 1) {
            foreach ($allowed as $rating) {
                $count++;
                if ($last && $last+1 == $rating && $count != count($allowed)) {
                    $last = $rating;
                    continue;
                } elseif ($last && $count != count($allowed)) {
                    $out .= "-";
                    for ($i = 0; $i < $last; $i++) {
                        $out .= "●";
                    }
                } elseif ($last && $last+1 == $rating) {
                    $out .= "-";
                } elseif ($last) {
                    $out .= ", ";
                }

                for ($j = 0; $j < $rating; $j++) {
                    $out .= "●";
                }

                $last = $rating;
            }
        } else {
            for ($j = 0; $j < $allowed[0]; $j++) {
                $out .= "●";
            }
        }

        return $out;
    }

    public static function addlBenefits($id) {
        if (get_field('additional_benefits', $id)) {
            return $benefits = get_field('additional_benefits', $id);
        }
        return;
    }
}
