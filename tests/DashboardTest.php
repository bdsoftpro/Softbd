<?php

namespace SBD\Softbd\Tests;

use Illuminate\Support\Facades\Auth;

class DashboardTest extends TestCase
{
    protected $withDummy = true;

    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    public function testWeHaveAccessToTheMainSections()
    {
        // We must first login and visit the dashboard page.
        Auth::loginUsingId(1);

        $this->visit(route('softbd.dashboard'));

        $this->see('Dashboard');

        // We can see number of Users.
        $this->see('1 user');

        // list them.
        $this->click('View all users');
        $this->seePageIs(route('softbd.users.index'));

        // and return to dashboard from there.
        $this->click('Dashboard');
        $this->seePageIs(route('softbd.dashboard'));

        // We can see number of posts.
        $this->see('4 posts');

        // list them.
        $this->click('View all posts');
        $this->seePageIs(route('softbd.posts.index'));

        // and return to dashboard from there.
        $this->click('Dashboard');
        $this->seePageIs(route('softbd.dashboard'));

        // We can see number of Pages.
        $this->see('1 page');

        // list them.
        $this->click('View all pages');
        $this->seePageIs(route('softbd.pages.index'));

        // and return to Dashboard from there.
        $this->click('Dashboard');
        $this->seePageIs(route('softbd.dashboard'));
        $this->see('Dashboard');
    }
}
