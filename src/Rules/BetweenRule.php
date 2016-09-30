<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class BetweenRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return ($value >= $args[0] && $value <= $args[1]) ? true : false;
    }

    public function error()
    {
        return Language::get('BetweenRule');
    }

    public function canSkip()
    {
        return true;
    }
}
