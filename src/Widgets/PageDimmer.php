<?php

namespace SBD\Softbd\Widgets;

use Arrilot\Widgets\AbstractWidget;
use SBD\Softbd\Facades\Softbd;

class PageDimmer extends AbstractWidget
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
        $count = Softbd::model('Page')->count();
        $string = $count == 1 ? 'page' : 'pages';

        return view('softbd::dimmer', array_merge($this->config, [
            'icon'   => 'softbd-group',
            'title'  => "{$count} {$string}",
            'text'   => "You have {$count} {$string} in your database. Click on button below to view all pages.",
            'button' => [
                'text' => 'View all pages',
                'link' => route('softbd.pages.index'),
            ],
            'image' => softbd_asset('images/widget-backgrounds/03.png'),
        ]));
    }
}
