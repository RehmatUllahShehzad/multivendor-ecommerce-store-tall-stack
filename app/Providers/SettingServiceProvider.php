<?php

namespace App\Providers;

use App\Http\Middleware\AutoSaveSetting;
use App\Managers\SettingManager;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Auto save setting
        if (config('setting.auto_save')) {
            $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
            $kernel->pushMiddleware(AutoSaveSetting::class);
        }

        $this->override();

        // Register blade directive
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $compiler) {
            $compiler->directive('setting', function ($expression) {
                return "<?php echo setting($expression); ?>";
            });
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('setting.manager', function ($app) {
            return new SettingManager($app);
        });

        $this->app->singleton('setting', function ($app) {
            return $app['setting.manager']->driver();
        });
    }

    private function override()
    {
        $override = config('setting.override', []);

        foreach (Arr::dot($override) as $config_key => $setting_key) {
            $config_key = is_string($config_key) ? $config_key : $setting_key;

            try {
                if (! is_null($value = setting($setting_key))) {
                    config([$config_key => $value]);
                }
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
