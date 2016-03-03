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
     * Register the routes for this Admin Section.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function registerRoutes(Router $router)
    {
        $router->group(['prefix' => $this->urlPrefix(), 'namespace' => get_called_class(), 'as' => $this->urlPrefix(), 'name' => 'settings'], function ($router) {
            $router->get('{panel?}', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@getIndex');
            $router->post('{panel?}', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@postIndex');
        });
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
