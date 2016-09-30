<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class CheckedRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return in_array($value, ['yes', 'on', '1', 1, true, 'true'], true);
    }

    public function error()
    {
        return Language::get('CheckedRule');
    }

    public function canSkip()
    {
        return true;
    }
}
