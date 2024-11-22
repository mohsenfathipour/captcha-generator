<?php

if (!function_exists('generateCaptchaImage')) {
    /**
     * Helper function to generate captcha image.
     */
    function generateCaptchaImage($name, $bgColorHex = null, $width = null, $height = null)
    {
        $captchaController = new \App\Http\Controllers\CaptchaController();
        return $captchaController->show($name, $bgColorHex, $width, $height);
    }
}
