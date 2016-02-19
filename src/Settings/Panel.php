<?php

namespace LaravelFlare\Settings;

use LaravelFlare\Fields\FieldManager;

class Panel
{
    /**
     * Fields Manager.
     * 
     * @var \LaravelFlare\Fields\FieldManager
     */
    protected $fields;

    /**
     * Panel Title.
     * 
     * @var string
     */
    protected $title;

    /**
     * Panel Key.
     * 
     * @var string
     */
    protected $key;

    /**
     * Panel Options.
     * 
     * @var 
     */
    protected $options;

    public function __construct($key, $settings = [])
    {
        $this->fields = new FieldManager();

        $this->setupPanel($key, $settings);
    }

    /**
     * Return the Panel Key.
     * 
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Return the Panel Title.
     * 
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the Panel Slug.
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
     * Return the Panel URL.
     * 
     * @return string
     */
    public function url()
    {
        return url($this->slug());
    }

    /**
     * Return the Panel Settings.
     * 
     * @return string
     */
    public function settings()
    {
        return $this->options;
    }

    /**
     * Set the Panel Key.
     * 
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Returns the title for a Settings Panel.
     * 
     * @param string $panelKey
     * @param array  $panel
     * 
     * @return string
     */
    public function setTitle($settings = [])
    {
        if ($this->key() === 0) {
            $this->title = 'General Settings';

            return;
        }

        if (!isset($settings['title'])) {
            $this->title = ucwords(str_replace(['-', '_'], ['', ''], $this->key()));

            return;
        }

        $this->title = $settings['title'];
    }

    /**
     * Set Settings for Panel.
     * 
     * @param array $settings
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
     * Setup a Collection of Options as Attribute Instances.
     * 
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = collect();

        foreach ($options as $key => $option) {
            $fullKey = $this->key().'.'.$key;
            $this->options->put($fullKey, $this->fields->create($option['type'], $key, $this->getSettingValue($fullKey), $option));
        }
    }

    /**
     * Return a Setting Value.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getSettingValue($key)
    {
        return $key;
    }

    /**
     * Setup the Panel Information.
     * 
     * @param string $key
     * @param array  $settings
     */
    private function setupPanel($key, $settings)
    {
        $this->setKey($key);
        $this->setTitle($settings);
        $this->setSettings($settings);
    }
}
