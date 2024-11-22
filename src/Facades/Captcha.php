<?php

namespace MohsenFathipour\CaptchaGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class Captcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'captcha';  // The service container binding name
    }
}