<?php

namespace LaravelFlare\Settings\Policies;

class SettingsPolicy
{
    /**
     * Determine if the given Model can be viewed by the user.
     *
     * @param  $user
     * @param  $admin
     * 
     * @return bool
     */
    public function view($user, $admin)
    {
        return $user->is_admin;
    }
}
