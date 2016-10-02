<?php

/**
 * Violin example. Custom rule message.
 *
 * Defining an error message for when a particular rule fails.
 */

require '../../vendor/autoload.php';

use Violin\Violin;
use Violin\Language;

Language::setLanguage('en');
$v = new Violin;

$v->addRuleMessage('required', ['en'=>'Hold up, the {field} field is required!','nl'=>'Stop, de {field} veld is verplicht!']);

$v->validate([
    'username'  => ['', 'required|alpha|min(3)|max(20)'],
    'email'     => ['dale@codecourse.com', 'required|email'],
    'password'  => ['ilovecats', 'required'],
    'password_confirm' => ['ilovecats', 'required|matches(password)']
]);

if ($v->passes()) {
    // Passed
} else {
    var_dump($v->errors()->all());
}
