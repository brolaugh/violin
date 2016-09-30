<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class AlphaRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return (bool) preg_match('/^[\pL\pM]+$/u', $value);
    }

    public function error()
    {
        return Language::get('AlphaRule');
    }

    public function canSkip()
    {
        return true;
    }
}
