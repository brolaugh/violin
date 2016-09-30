<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class EmailRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function error()
    {
        return Language::get('EmailRule');
    }

    public function canSkip()
    {
        return true;
    }
}
