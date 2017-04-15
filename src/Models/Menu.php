<?php

namespace SBD\Softbd\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use SBD\Softbd\Facades\Softbd;

/**
 * @todo: Refactor this class by using something like MenuBuilder Helper.
 */
class Menu extends Model
{
    protected $table = 'menus';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Softbd::modelClass('MenuItem'));
    }

    public function parent_items()
    {
        return $this->hasMany(Softbd::modelClass('MenuItem'))
            ->whereNull('parent_id');
    }

    /**
     * Display menu.
     *
     * @param string      $menuName
     * @param string|null $type
     * @param array       $options
     *
     * @return string
     */
    public static function display($menuName, $type = null, array $options = [])
    {
        // GET THE MENU - sort collection in blade
        $menu = static::where('name', '=', $menuName)
            ->with('parent_items.children')
            ->first();

        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        event('softbd.menu.display', $menu);

        // Convert options array into object
        $options = (object) $options;

        // Set static vars values for admin menus
        if (in_array($type, ['admin', 'admin_menu'])) {
            $permissions = Softbd::model('Permission')->all();
            $dataTypes = Softbd::model('DataType')->all();
            $prefix = trim(route('softbd.dashboard', [], false), '/');
            $user_permissions = null;

            if (!Auth::guest()) {
                $user = Softbd::model('User')->find(Auth::id());
                $user_permissions = $user->role->permissions->pluck('key')->toArray();
            }

            $options->user = (object) compact('permissions', 'dataTypes', 'prefix', 'user_permissions');

            // change type to blade template name - TODO funky names, should clean up later
            $type = 'softbd::menu.'.$type;
        } else {
            if (is_null($type)) {
                $type = 'softbd::menu.default';
            } elseif ($type == 'bootstrap' && !view()->exists($type)) {
                $type = 'softbd::menu.bootstrap';
            }
        }

        if (!isset($options->locale)) {
            $options->locale = app()->getLocale();
        }

        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make($type, ['items' => $menu->parent_items, 'options' => $options])->render()
        );
    }
}
