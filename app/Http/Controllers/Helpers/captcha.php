<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;

class Captcha extends Controller
{
    public static function getCaptcha()
    {
        header('Content-type: image/jpg');
        $path = 'public/site/images/1.jpg';
        $font_array = [
            'public/site/fonts/UTM AvoBold.ttf',
            'public/site/fonts/PaletteMosaic-Regular.ttf',
            'public/site/fonts/GMV_DIN_Pro-Light.ttf',
            'public/site/fonts/Quicksand-Regular.ttf',
            'public/site/fonts/SVN-Product Sans Regular.ttf',

        ];
        $key_font1 = array_rand($font_array, 1);
        $key_font2 = array_rand($font_array, 1);
        $key_font3 = array_rand($font_array, 1);
        $key_font4 = array_rand($font_array, 1);
        $key_font5 = array_rand($font_array, 1);

        $jpg_image = imagecreatefromjpeg($path);
        
        //color text
        $color_array = [
            imagecolorallocate($jpg_image, 0, 0, 255),
            imagecolorallocate($jpg_image, 255, 51, 0),
            imagecolorallocate($jpg_image, 0, 153, 0),
            imagecolorallocate($jpg_image, 153, 0, 153),
            imagecolorallocate($jpg_image, 204, 0, 0),
        ];
        $key_color1 = array_rand($color_array, 1);
        $key_color2 = array_rand($color_array, 1);
        $key_color3 = array_rand($color_array, 1);
        $key_color4 = array_rand($color_array, 1);
        $key_color5 = array_rand($color_array, 1);

        $text = md5(time());
        $text = substr($text, 0, 5);


        imagettftext($jpg_image, 35, 10, 65, 60, $color_array[$key_color1], realpath($font_array[$key_font1]), $text[0]);
        imagettftext($jpg_image, 35, 19, 110, 60, $color_array[$key_color2], realpath($font_array[$key_font2]), $text[1]);
        imagettftext($jpg_image, 35, 25, 145, 60, $color_array[$key_color3], realpath($font_array[$key_font3]), $text[2]);
        imagettftext($jpg_image, 35, 38, 180, 60, $color_array[$key_color4], realpath($font_array[$key_font4]), $text[3]);
        imagettftext($jpg_image, 35, 50, 220, 60, $color_array[$key_color5], realpath($font_array[$key_font5]), $text[4]);

        imagejpeg($jpg_image);
        imagedestroy($jpg_image);

        return $text;
    }
}
