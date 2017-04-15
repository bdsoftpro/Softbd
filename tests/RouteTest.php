<?php

namespace SBD\Softbd\Tests;

class RouteTest extends TestCase
{
    protected $withDummy = true;

    public function setUp()
    {
        parent::setUp();

        $this->install();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetRoutes()
    {
        $this->disableExceptionHandling();

        $this->visit(route('softbd.login'));
        $this->type('admin@admin.com', 'email');
        $this->type('password', 'password');
        $this->press('Login');

        $urls = [
            route('softbd.dashboard'),
            route('softbd.media.index'),
            route('softbd.settings.index'),
            route('softbd.roles.index'),
            route('softbd.roles.create'),
            route('softbd.roles.show', ['role' => 1]),
            route('softbd.roles.edit', ['role' => 1]),
            route('softbd.users.index'),
            route('softbd.users.create'),
            route('softbd.users.show', ['user' => 1]),
            route('softbd.users.edit', ['user' => 1]),
            route('softbd.posts.index'),
            route('softbd.posts.create'),
            route('softbd.posts.show', ['post' => 1]),
            route('softbd.posts.edit', ['post' => 1]),
            route('softbd.pages.index'),
            route('softbd.pages.create'),
            route('softbd.pages.show', ['page' => 1]),
            route('softbd.pages.edit', ['page' => 1]),
            route('softbd.categories.index'),
            route('softbd.categories.create'),
            route('softbd.categories.show', ['category' => 1]),
            route('softbd.categories.edit', ['category' => 1]),
            route('softbd.menus.index'),
            route('softbd.menus.create'),
            route('softbd.menus.show', ['menu' => 1]),
            route('softbd.menus.edit', ['menu' => 1]),
            route('softbd.database.index'),
            route('softbd.database.bread.edit', ['table' => 'categories']),
            route('softbd.database.edit', ['table' => 'categories']),
            route('softbd.database.create'),
        ];

        foreach ($urls as $url) {
            $response = $this->call('GET', $url);
            $this->assertEquals(200, $response->status(), $url.' did not return a 200');
        }
    }
}
