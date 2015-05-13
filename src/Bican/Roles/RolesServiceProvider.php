<?php

namespace Bican\Roles;

use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/roles.php' => config_path('roles.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->registerBladeExtensions();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/roles.php', 'roles');
    }

    /**
     * Register Blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->directive('role', function() {
            return "<?php if (Auth::check() && Auth::user()->is$2): ?> ";
        });
        
        $blade->directive('endrole', function() {
            return "<?php endif; ?>";
        });
        
        $blade->directive('permission', function() {
            return "<?php if (Auth::check() && Auth::user()->can$2): ?> ";
        });
        
        $blade->directive('endpermission', function() {
            return "<?php endif; ?>";
        });
        
        $blade->directive('allowed', function() {
            return "<?php if (Auth::check() && Auth::user()->allowed$2): ?> ";
        });
        
        $blade->directive('endallowed', function() {
            return "<?php endif; ?>";
        });
        
    }
}
