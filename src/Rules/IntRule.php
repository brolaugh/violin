<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class IntRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return is_numeric($value) && (int)$value == $value;
    }

    public function error()
    {
       return Language::get('IntRule');
    }

    public function canSkip()
    {
        return true;
    }
}
