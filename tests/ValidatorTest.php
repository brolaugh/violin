<?php

use Violin\Violin;
use Violin\Language;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    protected $v;

    public function setUp()
    {
        Language::setLanguage('en');
        $this->v = new Violin;
    }

    public function testBasicValidValidation()
    {
        $this->v->validate([
            'first_name'     => ['Billy', 'required|alpha|max(20)'],
            'last_name'      => ['Garrett', 'required|alpha|max(20)'],
            'email|Email'    => ['billy@codecourse.com', 'required|email'],
            'password'       => ['ilovecats', 'required'],
            'password_again' => ['ilovecats', 'required|matches(password)']
        ]);

        $this->assertTrue($this->v->passes());
        $this->assertFalse($this->v->fails());

        $input = [
            'first_name'  => 'Billy',
            'last_name'   => 'Garrett',
            'email|Email' => 'billy@codecourse.com',
            'password'    => 'ilovecats',
            'password'    => 'ilovecats'
        ];

        $rules = [
            'first_name'     => 'required|alpha|max(20)',
            'last_name'      => 'required|alpha|max(20)',
            'email'          => 'required|email',
            'password'       => 'required',
            'password_again' => 'required|matches(password)'
        ];

        $this->v->validate($input, $rules);

        $this->assertTrue($this->v->passes());
        $this->assertFalse($this->v->fails());
    }

    public function testBasicInvalidValidation()
    {
        $this->v->validate([
            'first_name'     => ['Billy', 'required|alpha|max(20)'],
            'last_name'      => ['', 'required|alpha|max(20)'],
            'email'          => ['billy@codecourse', 'required|email'],
            'password'       => ['ilovecats', 'required'],
            'password_again' => ['ilovecatsanddogs' , 'required|matches(password)']
        ]);

        $this->assertTrue($this->v->fails());
        $this->assertFalse($this->v->passes());
    }

    public function testRuleMessage()
    {
        $this->v->addRuleMessage('required', 'This field is required!');

        $this->v->validate([
            'username' => ['', 'required']
        ]);

        $this->assertEquals(
            $this->v->errors()->first('username'),
            'This field is required!'
        );
    }

    public function testReplaceMessageFormatOnError()
    {
        $this->v->addRule('testRule', function($value, $input, $args) {
            return false;
        });

        $this->v->addRuleMessage('testRule', 'We got {$#} arguments: {$*}.');

        $this->v->validate([
            'age' => [0, 'testRule(1, 2, 3)']
        ]);

        $this->assertEquals(
            $this->v->errors()->first(),
            'We got 3 arguments: 1, 2, 3.'
        );
    }

    public function testRuleMessages()
    {
        $this->v->addRuleMessages([
            'required' => 'This field is required!',
            'alpha'    => 'Only alpha characters please!',
            'email'    => 'Enter a valid email!'
        ]);

        $this->v->validate([
            'username' => ['', 'required|alpha'],
            'name' => ['123', 'alpha'],
            'email'    => ['notanemail', 'required|email']
        ]);

        $errors = $this->v->errors();

        $this->assertEquals(
            $errors->first('username'),
            'This field is required!'
        );

        $this->assertEquals(
            $errors->first('name'),
            'Only alpha characters please!'
        );

        $this->assertEquals(
            $errors->first('email'),
            'Enter a valid email!'
        );
    }

    public function testFieldMessage()
    {
        $this->v->addFieldMessage('username', 'required', 'We need a username, please.');

        $this->v->validate([
            'username' => ['', 'required']
        ]);

        $this->assertEquals(
            $this->v->errors()->first('username'),
            'We need a username, please.'
        );
    }

    public function testFieldMessages()
    {
        $this->v->addFieldMessages([
            'username' => [
                'required' => 'We need a username, please.'
            ],
            'email' => [
                'required' => 'How do you expect us to contact you without an email?'
            ]
        ]);

        $this->v->validate([
            'username' => ['', 'required|alpha'],
            'email' => ['', 'required|email']
        ]);

        $errors = $this->v->errors();

        $this->assertEquals(
            $errors->first('username'),
            'We need a username, please.'
        );

        $this->assertEquals(
            $errors->first('email'),
            'How do you expect us to contact you without an email?'
        );
    }

    public function testPassingCustomRule()
    {
        $this->v->addRule('isbanana', function($value, $input, $args) {
            return $value === 'banana';
        });

        $this->v->validate([
            'fruit' => ['apple', 'isbanana']
        ]);

        $this->assertFalse($this->v->passes());
    }

    public function testFailingCustomRule()
    {
        $this->v->addRule('isbanana', function($value, $input, $args) {
            return $value === 'banana';
        });

        $this->v->validate([
            'fruit' => ['banana', 'isbanana']
        ]);

        $this->assertTrue($this->v->passes());
    }

    public function testMultipleCustomRules()
    {
        $this->v->addRule('isbanana', function($value, $input, $args) {
            return $value === 'banana';
        });

        $this->v->addRule('isapple', function($value, $input, $args) {
            return $value === 'apple';
        });

        $this->v->validate([
            'fruit_one' => ['banana', 'isbanana'],
            'fruit_two' => ['apple', 'isapple']
        ]);

        $this->assertTrue($this->v->passes());
    }

    public function testPassingCustomRuleWithArguments()
    {
        $this->v->addRule('isoneof', function($value, $input, $args) {
            return in_array($value, $args);
        });

        $this->v->validate([
            'items' => ['seeds', 'isoneof(seeds, nuts, fruit)']
        ]);

        $this->assertTrue($this->v->passes());
    }

    public function testFailingCustomRuleWithArguments()
    {
        $this->v->addRule('isoneof', function($value, $input, $args) {
            return in_array($value, $args);
        });

        $this->v->validate([
            'items' => ['burger', 'isoneof(seeds, nuts, fruit)']
        ]);

        $this->assertFalse($this->v->passes());
    }

    public function testValidationWithAliases()
    {
        $this->v->addFieldMessages([
            'username_box' => [
                'required' => 'We need a username in the {field} field, please.'
            ]
        ]);

        $this->v->validate([
            'username_box|Username' => ['', 'required'],
            'password' => ['secret', 'required|alpha']
        ]);

        $errors = $this->v->errors();

        $this->assertFalse($this->v->passes());
        $this->assertTrue($this->v->fails());
        $this->assertEquals(
            $errors->first('username_box'),
            'We need a username in the Username field, please.'
        );
    }

    public function testSkippingOtherRulesIfNotRequired()
    {
        $this->v->validate([
            'username' => ['alex', 'required|alpha'],
            'email' => ['', 'alpha|email']
        ]);

        $this->assertEquals(
            $this->v->errors()->first('email'),
            'email must be alphabetic.'
        );
    }

    public function testBeforeCallbackOnValidation()
    {
        $this->v->before(function($v) {
            $this->assertEquals($v->getInput()['user'], 'Billy');
        });

        $this->v->validate([
            'user' => ['Billy', 'required|alpha|max(5)']
        ]);

        $this->assertTrue($this->v->passes());
    }

    public function testAfterCallbackOnValidation()
    {
        $alphaMessage = 'The {field} needs letters!';
        $maxMessage   = 'You need to have less than {$0} characters.';

        $this->v->after(function($v) use ($maxMessage) {
            if (! $v->errors()->isEmpty()) {
                $v->addFieldMessage('user', 'max', $maxMessage);
            }
        });

        $this->v->after(function($v) use ($alphaMessage) {
            if (! $v->errors()->isEmpty()) {
                $v->addFieldMessage('user', 'alpha', $alphaMessage);
            }
        });

        $this->v->validate([
            'user' => ['Billy2', 'required|alpha|max(3)']
        ]);

        $this->assertFalse($this->v->passes());

        $this->assertEquals(
            $this->v->errors()->all('user')[0],
            'The user needs letters!'
        );

        $this->assertEquals(
            $this->v->errors()->all('user')[1],
            'You need to have less than 3 characters.'
        );
    }
}
