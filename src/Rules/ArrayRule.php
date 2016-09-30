<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;
use Violin\Language;

class ArrayRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return is_array($value);
    }

    public function error()
    {
      return Language::get('ArrayRule');
    }

    public function canSkip()
    {
        return true;
    }
}
