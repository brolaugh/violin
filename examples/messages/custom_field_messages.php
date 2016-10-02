<?php

/**
 * Violin example. Custom field messages.
 *
 * Defining an error message for a particular field, when a
 * particular rule fails.
 *
 * This is the same as addFieldMessage, but allows adding
 * of multiple field messages in one go.
 */

require '../../vendor/autoload.php';

use Violin\Violin;
use Violin\Language;

Language::setLanguage('en');
$v = new Violin;

$v->addFieldMessages([
    'username' => [
        'required'  => [
          'en' => 'We need a username to sign you up.',
          'nl' => 'We hebben een gebruiksernaam nodig om je te kunnen registreren.'
        ],
        'alpha'     => [
          'en' => 'Your username can only contain letters.',
          'nl' => 'Je gebruikersnaam mag alleen uit leters bestaan.'
        ]
    ],
    'email' => [
        'email'     => [
          'en' => 'That email doesn\'t look valid.',
          'nl' => 'Dit is een fout mail adres.'
        ]
    ]
]);

$v->validate([
    'username'  => ['cats4life', 'required|alpha|min(3)|max(20)'],
    'email'     => ['dale.codecourse.com', 'required|email'],
    'password'  => ['ilovecats', 'required'],
    'password_confirm' => ['ilovecats', 'required|matches(password)']
]);

if ($v->passes()) {
    // Passed
} else {
    var_dump($v->errors()->all());
}
