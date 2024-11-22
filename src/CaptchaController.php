<?php

namespace MohsenFathipour\CaptchaGenerator;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class CaptchaController extends Controller
{
    public function show($name = "form", $bgColorHex = null, $width = null, $height = null)
    {
        $width = $width ?? random_int(120, 125);
        $height = $height ?? random_int(35, 36);

        $image = imagecreatetruecolor($width, $height);

        if ($bgColorHex) {
            $bgColorRgb = sscanf($bgColorHex, "%02x%02x%02x");
        } else {
            $bgColorRgb = [random_int(200, 240), random_int(200, 240), random_int(200, 240)];
        }

        $backgroundColor = imagecolorallocate($image, $bgColorRgb[0], $bgColorRgb[1], $bgColorRgb[2]);
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        $characters = 'ABCDEFGHJKLMNPQRTWZ234679';
        $textLength = random_int(4, 6);
        $captchaText = '';
        for ($i = 0; $i < $textLength; $i++) {
            $captchaText .= $characters[random_int(0, strlen($characters) - 1)];
        }

        Session::put("captcha.$name", $captchaText);

        for ($i = 0; $i < strlen($captchaText); $i++) {
            $textColor = $this->getContrastingColor($image, $bgColorRgb);
            imagestring($image, random_int(3, 5), 10 + $i * random_int(18, 22), random_int(8, $height - 20), $captchaText[$i], $textColor);
        }

        for ($i = 0; $i < random_int(3, 5); $i++) {
            $lineColor = imagecolorallocate($image, random_int(50, 150), random_int(50, 150), random_int(50, 150));
            imageline($image, random_int(0, $width), random_int(0, $height), random_int(0, $width), random_int(0, $height), $lineColor);
        }

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return response($imageData)->header('Content-Type', 'image/png');
    }

    private function getContrastingColor($image, $bgColorRgb)
    {
        $brightness = ($bgColorRgb[0] * 0.299 + $bgColorRgb[1] * 0.587 + $bgColorRgb[2] * 0.114);

        if ($brightness > 186) {
            $r = random_int(0, 100);
            $g = random_int(0, 100);
            $b = random_int(0, 100);
        } else {
            $r = random_int(150, 255);
            $g = random_int(150, 255);
            $b = random_int(150, 255);
        }

        return imagecolorallocate($image, $r, $g, $b);
    }
}
