<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class IpRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    public function error()
    {
        return Language::get('IpRule');
    }

    public function canSkip()
    {
        return true;
    }
}
