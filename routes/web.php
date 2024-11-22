<?php

use MohsenFathipour\CaptchaGenerator\CaptchaController;

Route::get('/captcha/{name?}', [CaptchaController::class, 'show']);