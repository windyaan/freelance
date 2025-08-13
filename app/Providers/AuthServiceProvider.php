<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Chat::class => \App\Policies\ChatPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
