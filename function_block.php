<?php
/*
 * Outputs a color (#000000) based Text input
 *
 * @param $text String of text
 * @param $min_brightness Integer between 0 and 100
 * @param $spec Integer between 2-10, determines how unique each color will be
 */

function genColorCodeFromText($text, $min_brightness = 100, $spec = 10)
{
    // Check inputs
    if (!is_int($min_brightness)) {
        throw new Exception("$min_brightness is not an integer");
    }

    if (!is_int($spec)) {
        throw new Exception("$spec is not an integer");
    }

    if ($spec < 2 or $spec > 10) {
        throw new Exception("$spec is out of range");
    }

    if ($min_brightness < 0 or $min_brightness > 255) {
        throw new Exception("$min_brightness is out of range");
    }

    $hash = md5($text); //Gen hash of text
    $colors = [];
    for ($i = 0; $i < 3; $i++) {
        $colors[$i] = max([round(((hexdec(mb_substr($hash, $spec * $i, $spec))) / hexdec(str_pad('', $spec, 'F'))) * 255), $min_brightness]);
    }
    //convert hash into 3 decimal values between 0 and 255
    if ($min_brightness > 0) { //only check brightness requirements if min_brightness is about 100
        while (array_sum($colors) / 3 < $min_brightness) { //loop until brightness is above or equal to min_brightness
            for ($i = 0; $i < 3; $i++) {
                $colors[$i] += 10;
            }
        }
    }

    //increase each color by 10
    $output = '';
    for ($i = 0; $i < 3; $i++) {
        $output .= str_pad(dechex($colors[$i]), 2, 0, STR_PAD_LEFT);
    }
    //convert each color to hex and append to output
    return '#' . $output;
}
