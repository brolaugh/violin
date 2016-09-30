<?php

namespace Violin\Rules;
use Violin\Language;

use Violin\Contracts\RuleContract;

class UrlRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public function error()
    {
        return Language::get('UrlRule');
    }

    public function canSkip()
    {
        return true;
    }
}
