<?php

namespace Violin\Rules;
use Violin\Language;

use Violin\Contracts\RuleContract;

class RequiredRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        $value = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $value);

        return !empty($value);
    }

    public function error()
    {
        return Language::get('RequiredRule');
    }

    public function canSkip()
    {
        return false;
    }
}
