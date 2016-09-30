<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class DateRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        if ($value instanceof DateTime) {
            return true;
        }

        if (strtotime($value) === false) {
            return false;
        }

        $date = date_parse($value);

        return checkdate($date['month'], $date['day'], $date['year']);
    }

    public function error()
    {
        return Language::get('DateRule');
    }

    public function canSkip()
    {
        return true;
    }
}
