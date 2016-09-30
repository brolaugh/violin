<?php

namespace Violin\Rules;
use Violin\Language;

use Violin\Contracts\RuleContract;

class NumberRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return is_numeric($value);
    }

    public function error()
    {
        return Language::get('NumberRule');
    }

    public function canSkip()
    {
        return true;
    }
}
