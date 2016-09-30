<?php

namespace Violin\Rules;
use Violin\Language;

use Violin\Contracts\RuleContract;

class RegexRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return (bool) preg_match($args[0], $value);
    }

    public function error()
    {
        return Language::get('RegexRule');
    }

    public function canSkip()
    {
        return true;
    }
}
