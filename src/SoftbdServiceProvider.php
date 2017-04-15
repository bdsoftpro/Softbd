<?php

namespace SBD\Softbd;

use Arrilot\Widgets\Facade as Widget;
use Arrilot\Widgets\ServiceProvider as WidgetServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;
use SBD\Softbd\Facades\Softbd as SoftbdFacade;
use SBD\Softbd\FormFields\After\DescriptionHandler;
use SBD\Softbd\Http\Middleware\SoftbdAdminMiddleware;
use SBD\Softbd\Models\User;
use SBD\Softbd\Translator\Collection as TranslatorCollection;

class SoftbdServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(WidgetServiceProvider::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Softbd', SoftbdFacade::class);

        $this->app->singleton('softbd', function () {
            return new Softbd();
        });

        $this->loadHelpers();

        $this->registerAlertComponents();
        $this->registerFormFields();
        $this->registerWidgets();

        $this->registerConfigs();

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
            $this->registerConsoleCommands();
        }

        if (!$this->app->runningInConsole() || config('app.env') == 'testing') {
            $this->registerAppCommands();
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router, Dispatcher $event)
    {
        if (config('softbd.user.add_default_role_on_register')) {
            $app_user = config('softbd.user.namespace');
            $app_user::created(function ($user) {
                if (is_null($user->role_id)) {
                    SoftbdFacade::model('User')->findOrFail($user->id)
                        ->setRole(config('softbd.user.default_role'))
                        ->save();
                }
            });
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'softbd');

        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('admin.user', SoftbdAdminMiddleware::class);

            if (config('app.env') == 'testing') {
                $this->loadMigrationsFrom(realpath(__DIR__.'/migrations'));
            }
        } else {
            $router->middleware('admin.user', SoftbdAdminMiddleware::class);
        }

        $this->registerViewComposers();

        $this->bootTranslatorCollectionMacros();
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Register view composers.
     */
    protected function registerViewComposers()
    {
        // Register alerts
        View::composer('softbd::*', function ($view) {
            $view->with('alerts', SoftbdFacade::alerts());
        });
    }

    /**
     * Register alert components.
     */
    protected function registerAlertComponents()
    {
        $components = ['title', 'text', 'button'];

        foreach ($components as $component) {
            $class = 'SBD\\Softbd\\Alert\\Components\\'.ucfirst(camel_case($component)).'Component';

            $this->app->bind("softbd.alert.components.{$component}", $class);
        }
    }

    protected function bootTranslatorCollectionMacros()
    {
        Collection::macro('translate', function () {
            $transtors = [];

            foreach ($this->all() as $item) {
                $transtors[] = call_user_func_array([$item, 'translate'], func_get_args());
            }

            return new TranslatorCollection($transtors);
        });
    }

    /**
     * Register widget.
     */
    protected function registerWidgets()
    {
        $default_widgets = ['SBD\\Softbd\\Widgets\\UserDimmer', 'SBD\\Softbd\\Widgets\\PostDimmer', 'SBD\\Softbd\\Widgets\\PageDimmer'];
        $widgets = config('softbd.dashboard.widgets', $default_widgets);

        foreach ($widgets as $widget) {
            Widget::group('softbd::dimmers')->addWidget($widget);
        }
    }

    /**
     * Register the publishable files.
     */
    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__).'/publishable';

        $publishable = [
            'softbd_assets' => [
                "{$publishablePath}/assets/" => base_path(config('softbd.assets_path')),
            ],
            'migrations' => [
                "{$publishablePath}/database/migrations/" => database_path('migrations'),
            ],
            'seeds' => [
                "{$publishablePath}/database/seeds/" => database_path('seeds'),
            ],
            'demo_content' => [
                "{$publishablePath}/demo_content/" => base_path('uploads'),
            ],
            'config' => [
                "{$publishablePath}/config/softbd.php" => config_path('softbd.php'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    public function registerConfigs()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/publishable/config/softbd.php', 'softbd'
        );
    }

    protected function registerFormFields()
    {
        $formFields = [
            'checkbox',
            'date',
            'file',
            'image',
            'multiple_images',
            'number',
            'password',
            'radio_btn',
            'rich_text_box',
            'select_dropdown',
            'select_multiple',
            'text',
            'text_area',
            'timestamp',
            'hidden',
            'code_editor',
        ];

        foreach ($formFields as $formField) {
            $class = studly_case("{$formField}_handler");

            SoftbdFacade::addFormField("SBD\\Softbd\\FormFields\\{$class}");
        }

        SoftbdFacade::addAfterFormField(DescriptionHandler::class);

        event('softbd.form-fields.registered');
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\ControllersCommand::class);
        $this->commands(Commands\AdminCommand::class);
    }

    /**
     * Register the commands accessible from the App.
     */
    private function registerAppCommands()
    {
        $this->commands(Commands\MakeModelCommand::class);
    }
}
