<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class AlnumRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return (bool) preg_match('/^[\pL\pM\pN]+$/u', $value);
    }

    public function error()
    {
        return Language::get('AlnumRule');
    }

    public function canSkip()
    {
        return true;
    }
}
