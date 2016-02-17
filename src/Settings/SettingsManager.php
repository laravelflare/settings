<?php

namespace LaravelFlare\Settings;

use LaravelFlare\Flare\Flare;

class SettingsManager
{
    protected $panels;

    /**
     * __construct
     *
     * 
     */
    public function __construct()
    {
        $this->setupPanels();
    }

    /**
     * Settings Menu Items
     * 
     * @return array
     */
    public function menu()
    {
        $menu = [];

        foreach ($this->panels as $key => $panel) {
            $menu[$panel->slug()] = $panel->title();
        }

        return $menu;
    }

    /**
     * Does a Panel Exist in the Settings Controller
     *
     * @param string $panel
     * 
     * @return boolean
     */
    public function panelExists($panel)
    {
        if ($this->getPanel($panel)) {
            return true;
        }

        return false;
    }

    /**
     * Load a Panel from the Array of Settings Panels
     * 
     * @param  string $panel 
     * 
     * @return array
     */
    public function getPanel($panel)
    {
        if (isset($this->panels[$panel])) {
            return $this->panels[$panel];
        }
    }
        
    /**
     * Initialize each of the Settings Panels and add them
     * to the Panels collection.
     * 
     * @return void
     */
    protected function setupPanels()
    {
        $panels = [];
        foreach ($this->getSettingsConfig() as $key => $settings) {
            if (array_key_exists('options', $settings)) {
                $panels[$key] = $settings;
                continue;
            } 
            $panels[0][$key] = $settings;
        }

        $this->panels = collect();
        foreach ($panels as $key => $settings) {
            $this->panels->put($key, (new Panel($key, $settings)));
        }
    }

    /**
     * Returns the settings as a Collection
     * 
     * @return 
     */
    protected function getSettingsConfig()
    {
        return collect(\Flare::config('settings'));
    }
}
