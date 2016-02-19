<?php

namespace LaravelFlare\Settings;

use Illuminate\Routing\Router;
use LaravelFlare\Flare\Admin\Modules\ModuleAdmin;

class SettingsModule extends ModuleAdmin
{
    /**
     * Admin Section Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    protected $icon = 'cog';

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected $title = 'Settings';

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected $pluralTitle = 'Settings';

    /**
     * The Controller to be used by the Pages Module.
     * 
     * @var string
     */
    protected $controller = '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController';

    /**
     * Register the routes for the Settings Panel(s).
     *
     * @param \Illuminate\Routing\Router $router
     * 
     * @return
     */
    public function registerRoutes(Router $router)
    {
        $router->get('settings/{panel?}', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@getIndex')->name('settings');
        $router->post('settings/{panel?}', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@postIndex')->name('settings');
    }

    /**
     * Menu Items.
     * 
     * @return array
     */
    public function menuItems()
    {
        return \Flare::settings()->menu();
    }
}
