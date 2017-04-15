<?php

namespace SBD\Softbd\Widgets;

use Arrilot\Widgets\AbstractWidget;
use SBD\Softbd\Facades\Softbd;

class UserDimmer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Softbd::model('User')->count();
        $string = $count == 1 ? 'user' : 'users';

        return view('softbd::dimmer', array_merge($this->config, [
            'icon'   => 'softbd-group',
            'title'  => "{$count} {$string}",
            'text'   => "You have {$count} {$string} in your database. Click on button below to view all users.",
            'button' => [
                'text' => 'View all users',
                'link' => route('softbd.users.index'),
            ],
            'image' => softbd_asset('images/widget-backgrounds/02.png'),
        ]));
    }
}
