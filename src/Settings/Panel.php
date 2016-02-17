<?php

namespace LaravelFlare\Settings;

use LaravelFlare\Settings\SettingsManager;
use LaravelFlare\Flare\Admin\Attributes\AttributeManager;

class Panel
{
    protected $settingsManager;

    protected $attributeManager;

    protected $title;

    protected $key;

    protected $options;


    public function __construct($key, $settings = [])
    {
        $this->attributeManager = new AttributeManager();
       
        $this->setupPanel($key, $settings);
    }

    /**
     * Return the Panel Key
     * 
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Return the Panel Title
     * 
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the Panel Slug
     * 
     * @return string
     */
    public function slug()
    {
        if ($this->key() === 0) {
            return 'settings';
        }

        return 'settings/'.$this->key();
    }

    /**
     * Return the Panel URL
     * 
     * @return string
     */
    public function url()
    {
        return url($this->slug());
    }

    /**
     * Return the Panel Fields
     * 
     * @return string
     */
    public function fields()
    {
        return $this->options;
    }

    /**
     * Set the Panel Key
     * 
     * @param string $key
     * 
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Returns the title for a Settings Panel
     * 
     * @param  string  $panelKey 
     * @param  array  $panel 
     * 
     * @return string 
     */
    public function setTitle($settings = [])
    {
        if ($this->key() === 0) {
            $this->title = "General Settings";
            return;
        }

        if (!isset($settings['title'])) {
            $this->title = ucwords(str_replace(['-', '_'], ['',''], $this->key()));
            return;
        }

        $this->title = $settings['title'];
    }

    /**
     * Set Settings for Panel
     * 
     * @param array $settings
     *
     * @return void
     */
    public function setSettings($settings = [])
    {
        if (array_key_exists('options', $settings)) {
            $this->setOptions($settings['options']);
            return;
        }

        $this->setOptions($settings);
    }

    /**
     * Setup a Collection of Options as Attribute Instances
     * 
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = collect();

        foreach ($options as $key => $option) {
            $fullKey = $this->key().'.'.$key;
            $this->options->put($fullKey, $this->attributeManager->createAttribute($option['type'], $key, $option, $this->getSettingValue($fullKey)));
        }
    }

    public function getSettingValue($key)
    {
        return $key;
    }

    /**
     * Setup the Panel Information
     * 
     * @param  string $key      
     * @param  array $settings 
     * 
     * @return void
     */
    protected function setupPanel($key, $settings)
    {
        $this->setKey($key);
        $this->setTitle($settings);
        $this->setSettings($settings);
    }
}