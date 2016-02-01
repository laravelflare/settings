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
    protected static $icon = 'cog';

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected static $title = 'Settings';

    /**
     * Title of Admin Section.
     *
     * @var string
     */
    protected static $pluralTitle = 'Settings';

    /**
     * The Controller to be used by the Pages Module.
     * 
     * @var string
     */
    protected static $controller = '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController';

    /**
     * Register the routes for the Settings Panel(s).
     *
     * @param  \Illuminate\Routing\Router $router
     * 
     * @return
     */
    public function registerRoutes(Router $router)
    {
        $router->get('settings/{panel?}', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@getIndex'); 
        $router->post('settings/{panel?', '\LaravelFlare\Settings\Http\Controllers\SettingsAdminController@getIndex'); 
    }

    /**
     * Menu Items.
     * 
     * @return array
     */
    public function menuItems()
    {
        $menu = [];

        foreach ($this->getSettingsPanels() as $panelKey => $panel) {
            $menu['settings/'.$panelKey] = $this->settingsMenuTitle($panelKey, $panel);
        }

        if (count($menu) > 0) {
            $menu = array_merge(['settings' => 'Other Settings'], $menu);
        }

        return $menu;
    }

    /**
     * Returns the title for a Settings Panel
     * 
     * @param  string  $panelKey 
     * @param  array  $panel 
     * 
     * @return string 
     */
    public function settingsMenuTitle($panelKey, array $panel)
    {
        if (!isset($panel['title'])) {
            return ucwords(str_replace(['-', '_'], ['',''], $panelKey));
        }

        return $panel['title'];
    }

    /**
     * Returns a collection of Settings Panels.
     * 
     * @return 
     */
    public function getSettingsPanels()
    {
        return $this->getSettings()->filter(function ($item) {
            return isset($item['options']);
        });
    }

    /**
     * Returns the settings as a Collection
     * 
     * @return 
     */
    protected function getSettings()
    {
        return collect(\Config::get('flare-config.settings'));
    }
}
