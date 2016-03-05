<?php

namespace LaravelFlare\Settings\Http\Middleware;

use Closure;
use LaravelFlare\Settings\SettingsManager;

class PanelExists
{
    /**
     * User Manager.
     *
     * @var \LaravelFlare\Settings\SettingsManager
     */
    protected $settings;

    /**
     * @var |Illuminate|Http|Request
     */
    protected $request;

    /**
     * Create a new filter instance.
     */
    public function __construct(SettingsManager $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$panel = $request->route()->getParameter('panel')) {
            $panel = 0;
        }

        if (!$this->settings->panelExists($panel)) {
            return view('flare::admin.404', []);
        }
        
        return $next($request);
    }
}
