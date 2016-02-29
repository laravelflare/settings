<?php

namespace LaravelFlare\Settings\Http\Controllers;

use LaravelFlare\Settings\Setting;
use LaravelFlare\Settings\SettingsManager;
use LaravelFlare\Flare\Admin\AdminManager;
use LaravelFlare\Flare\Admin\Modules\ModuleAdminController;
use LaravelFlare\Settings\Http\Requests\UpdateSettingsRequest;

class SettingsAdminController extends ModuleAdminController
{
    /**
     * Admin Instance.
     * 
     * @var 
     */
    protected $admin;

    /**
     * __construct.
     * 
     * @param AdminManager $adminManager
     */
    public function __construct(AdminManager $adminManager, SettingsManager $settingsManager)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct($adminManager);

        $this->admin = $this->adminManager->getAdminInstance();
        $this->settings = $settingsManager;
    }

    /**
     * Settings Panel.
     * 
     * @param mixed $panel
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex($panel = null)
    {
        // If no panel, load the default.
        if (!$panel) {
            $panel = 0;
        }

        // Replace for Middleware later.
        if (!$this->settings->panelExists($panel)) {
            return self::missingMethod();
        }

        return view('flare::admin.settings.index', ['panel' => $this->settings->getPanel($panel)]);
    }

    /**
     * Process Settings Update.
     *
     * @param mixed $panel
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex(UpdateSettingsRequest $request, $panel = null)
    {
        // If no panel, load the default.
        if (!$panel) {
            $panel = 0;
        }

        // Replace for Middleware later.
        if (!$this->settings->panelExists($panel)) {
            return self::missingMethod();
        }

        $panel = $this->settings->getPanel($panel);


        foreach ($request->except(['_token']) as $key => $value) {
            if ($panel->settings()->has($fullKey = $panel->key().'.'.$key)) {
                Setting::updateOrCreate(['setting' => $fullKey], ['value' => $request->get($key)]);
            }
        }

        return redirect($request->url())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The settings have been updated.', 'dismissable' => false]]);
    }

    /**
     * Method is called when the appropriate controller
     * method is unable to be found or called.
     * 
     * @param array $parameters
     * 
     * @return
     */
    public function missingMethod($parameters = array())
    {
        return parent::missingMethod();
    }
}
