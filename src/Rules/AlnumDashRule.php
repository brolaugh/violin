<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class AlnumDashRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return (bool) preg_match('/^[\pL\pM\pN_-]+$/u', $value);
    }

    public function error()
    {
        return Language::get('AlnumDashRule');
    }

    public function canSkip()
    {
        return true;
    }
}
