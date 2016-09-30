<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class BoolRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return is_bool($value);
    }

    public function error()
    {
        return Language::get('BoolRule');
    }

    public function canSkip()
    {
        return true;
    }
}
