<?php

namespace LaravelFlare\Settings;

class SettingsManager
{
    /**
     * Panels
     * 
     * @var array
     */
    protected $panels;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->setupPanels();
    }

    /**
     * Settings Menu Items.
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
     * Does a Panel Exist in the Settings Controller.
     *
     * @param string $panel
     * 
     * @return bool
     */
    public function panelExists($panel)
    {
        if ($this->getPanel($panel)) {
            return true;
        }

        return false;
    }

    /**
     * Alias of getPanel($panel)
     * 
     * @param  string $panel
     * 
     * @return array|void
     */
    public function panel($panel)
    {
        return $this->getPanel($panel);
    }

    /**
     * Load a Panel from the Array of Settings Panels.
     * 
     * @param string $panel
     * 
     * @return array|void
     */
    public function getPanel($panel)
    {
        if (isset($this->panels[$panel])) {
            return $this->panels[$panel];
        }
    }

    /**
     * Alias of getValue($panel).
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function value($key)
    {
        return $this->getValue($key);
    }

    /**
     * Return a Setting.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]); //->setAttribute('value', $this->getDefaultValue($key));
    }

    /**
     * Return a Setting Value.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getValue($key)
    {
        return $this->getSetting($key)->value;
    }

    /**
     * Get the Default Value (if set) for a Setting.
     * 
     * @param  string $key
     * 
     * @return mixed
     */
    public static function getDefaultValue($key)
    {
        if (strpos($key, '.') !== false) {
            list($panel, $key) = explode('.', $key, 2);
        }

        // TBC
    }

    /**
     * Initialize each of the Settings Panels and add them
     * to the Panels collection.
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
     * Returns the settings as a Collection.
     * 
     * @return 
     */
    protected function getSettingsConfig()
    {
        return collect(\Flare::config('settings'));
    }
}
