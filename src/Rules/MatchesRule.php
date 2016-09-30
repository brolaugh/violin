<?php

namespace Violin\Rules;
use Violin\Language;

use Violin\Contracts\RuleContract;

class MatchesRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return $value === $input[$args[0]];
    }

    public function error()
    {
        return Language::get('MatchesRule');
    }

    public function canSkip()
    {
        return true;
    }
}
