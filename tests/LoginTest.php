<?php

namespace SBD\Softbd\Tests;

class LoginTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    public function testSuccessfulLoginWithDefaultCredentials()
    {
        $this->visit(route('softbd.login'));
        $this->type('admin@admin.com', 'email');
        $this->type('password', 'password');
        $this->press('Login');
        $this->seePageIs(route('softbd.dashboard'));
    }

    public function testShowAnErrorMessageWhenITryToLoginWithWrongCredentials()
    {
        $this->visit(route('softbd.login'))
             ->type('john@Doe.com', 'email')
             ->type('pass', 'password')
             ->press('Login')
             ->seePageIs(route('softbd.login'))
             ->see(trans('auth.failed'))
             ->seeInField('email', 'john@Doe.com');
    }
}
