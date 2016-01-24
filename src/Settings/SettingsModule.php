<?php

namespace LaravelFlare\Settings;

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
}
