<?php

namespace LaravelFlare\Settings;

use LaravelFlare\Settings;
use LaravelFlare\Fields\FieldManager;
use Illuminate\Foundation\Http\FormRequest as Request;
use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Panel
{
    /**
     * Fields Manager.
     * 
     * @var \LaravelFlare\Fields\FieldManager
     */
    protected $fieldManager;

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

    /**
     * Panel Fields.
     * 
     * @var 
     */
    protected $fields;

    /**
     * Panel Settings.
     * 
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $settings;

    /**
     * __construct
     * 
     * @param stirng $key
     * @param array  $settings 
     */
    public function __construct($key, $settings = [])
    {
        $this->fieldManager = \App::make('LaravelFlare\Fields\FieldManager');

        $this->setupPanel($key, $settings);
    }

    /**
     * Return the Panel Key, with the Setting Key
     * appended (with dot notation) if provided.
     *
     * @param string $key
     * 
     * @return string
     */
    public function key($key = null)
    {
        if (!$key) {
            return $this->key;
        }

        return $this->key . '.' . $key;
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
        return $this->settings;
    }

    /**
     * Return the Panel Settings.
     * 
     * @return string
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Return the Panel Fields.
     * 
     * @return string
     */
    public function fields()
    {
        return $this->fields;
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
     * Setup a Collection of Options for the Panel,
     * and then setup the Options as Attribute Instances.
     * 
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = collect($options);

        $this->setFields();
    }

    /**
     * Set the available fields.
     *
     * @return void
     */
    public function setFields()
    {
        $this->fields = collect();

        foreach ($this->options as $key => $option) {
            if (!isset($option['type'])) continue;
            $this->fields->put($this->key().'.'.$key, $this->fieldManager->create($option['type'], $key, $this->getValue($key), $option));
        }
    }

    /**
     * Alias of getSetting($key).
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function setting($key)
    {
        return $this->getSetting($key);
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
        if (!$this->settings) {
            $this->getSettings();
        }

        if ($this->settings instanceof EloquentCollection && $this->settings->where('key', $this->key($key))->first()) {
            return $this->settings->where('key', $this->key($key))->first();
        }

        return new Setting(['key' => $this->key($key), 'value' => $this->getDefaultValue($key)]);
    }

    /**
     * Get all of the settings from the Flare Settings table.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSettings()
    {
        $this->settings = Setting::all();
    }

    /**
     * Alias of getValue($key).
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
     * Return a Default Setting Value.
     * 
     * @param string $key
     * 
     * @return mixed
     */
    public function getDefaultValue($key)
    {
        if ($setting = $this->options->get($key)) {
            return isset($setting['default']) ? $setting['default'] : null;
        }
    }

    /**
     * Update an Individual Setting
     * 
     * @param  string $key   
     * @param  mixed $value 
     * 
     * @return void
     */
    public function updateSetting($key, $value)
    {
        if ($value instanceof File) {
            $value = asset('files/'.$this->processFile($value));
        }

        $this->setting($key)->setAttribute('value', $value)->save();
    }

    /**
     * Update the Paenl using the input provided by a FormRequest
     * 
     * @param  \Illuminate\Foundation\Http\FormRequest $request 
     * 
     * @return void
     */
    public function updateFromRequest(Request $request)
    {
        foreach ($request->only($this->options()->keys()->toArray()) as $key => $value) {
            $this->updateSetting($key, $value);
        };
    }

    /**
     * Process Uploaded File.
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function processFile($file)
    {
        if (!$file) {
            return;
        }

        $file->move(
            base_path().'/public/files/', $filename = (time().'-'.$file->getClientOriginalName())
        );

        return $filename;
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
