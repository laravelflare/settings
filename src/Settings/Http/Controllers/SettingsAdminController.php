<?php

namespace LaravelFlare\Settings\Http\Controllers;

use LaravelFlare\Settings\Setting;
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
    public function __construct(AdminManager $adminManager)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct($adminManager);

        $this->admin = $this->adminManager->getAdminInstance();
    }

    /**
     * Settings Panel.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.settings.index', []);
    }

    /**
     * Process Settings Update
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex(UpdateSettingsRequest $request)
    {

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
        parent::missingMethod();
    }
}
