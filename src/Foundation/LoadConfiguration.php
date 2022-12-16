<?php

namespace Larso\Foundation;

use Illuminate\Foundation\Bootstrap\LoadConfiguration as BaseLoadConfiguration;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class LoadConfiguration extends BaseLoadConfiguration
{
    public function bootstrap(Application $app)
    {
        $items = [];

        if (file_exists($cached = $app->getCachedConfigPath())) {
            $items = require $cached;

            $loadedFromCache = true;
        }

        if (blank($items)) {
            $items = $this->getLaravelConfig();
        }

        $app->instance('config', $config = new Repository($items));

        if (! isset($loadedFromCache)) {
            // $this->loadConfigurationFiles($app, $config);
        }

        $app->detectEnvironment(function () use ($config) {
            return $config->get('app.env', 'production');
        });

        date_default_timezone_set($config->get('app.timezone', 'Asia/Ho_Chi_Minh'));

        mb_internal_encoding('UTF-8');

        $this->laravelConfigApp($app);
    }

    /**
     * @return void
     */
    protected function laravelConfigApp($app)
    {
        $configAppend = [

            'providers' => [
                \Illuminate\Auth\AuthServiceProvider::class,
                \Illuminate\Broadcasting\BroadcastServiceProvider::class,
                \Illuminate\Bus\BusServiceProvider::class,
                \Illuminate\Cache\CacheServiceProvider::class,
                \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
                \Illuminate\Cookie\CookieServiceProvider::class,
                \Illuminate\Database\DatabaseServiceProvider::class,
                \Illuminate\Encryption\EncryptionServiceProvider::class,
                \Illuminate\Filesystem\FilesystemServiceProvider::class,
                \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
                \Illuminate\Hashing\HashServiceProvider::class,
                \Illuminate\Mail\MailServiceProvider::class,
                \Illuminate\Notifications\NotificationServiceProvider::class,
                \Illuminate\Pagination\PaginationServiceProvider::class,
                \Illuminate\Pipeline\PipelineServiceProvider::class,
                \Illuminate\Queue\QueueServiceProvider::class,
                \Illuminate\Redis\RedisServiceProvider::class,
                \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
                \Illuminate\Session\SessionServiceProvider::class,
                \Illuminate\Translation\TranslationServiceProvider::class,
                \Illuminate\Validation\ValidationServiceProvider::class,
                \Illuminate\View\ViewServiceProvider::class,
            ],

            'aliases' => [
                'App' => \Illuminate\Support\Facades\App::class,
                'Arr' => \Illuminate\Support\Arr::class,
                'Artisan' => \Illuminate\Support\Facades\Artisan::class,
                'Auth' => \Illuminate\Support\Facades\Auth::class,
                'Blade' => \Illuminate\Support\Facades\Blade::class,
                'Broadcast' => \Illuminate\Support\Facades\Broadcast::class,
                'Bus' => \Illuminate\Support\Facades\Bus::class,
                'Cache' => \Illuminate\Support\Facades\Cache::class,
                'Config' => \Illuminate\Support\Facades\Config::class,
                'Cookie' => \Illuminate\Support\Facades\Cookie::class,
                'Crypt' => \Illuminate\Support\Facades\Crypt::class,
                'Date' => \Illuminate\Support\Facades\Date::class,
                'DB' => \Illuminate\Support\Facades\DB::class,
                'Eloquent' => \Illuminate\Database\Eloquent\Model::class,
                'Event' => \Illuminate\Support\Facades\Event::class,
                'File' => \Illuminate\Support\Facades\File::class,
                'Gate' => \Illuminate\Support\Facades\Gate::class,
                'Hash' => \Illuminate\Support\Facades\Hash::class,
                'Http' => \Illuminate\Support\Facades\Http::class,
                'Js' => \Illuminate\Support\Js::class,
                'Lang' => \Illuminate\Support\Facades\Lang::class,
                'Log' => \Illuminate\Support\Facades\Log::class,
                'Mail' => \Illuminate\Support\Facades\Mail::class,
                'Notification' => \Illuminate\Support\Facades\Notification::class,
                'Password' => \Illuminate\Support\Facades\Password::class,
                'Queue' => \Illuminate\Support\Facades\Queue::class,
                'RateLimiter' => \Illuminate\Support\Facades\RateLimiter::class,
                'Redirect' => \Illuminate\Support\Facades\Redirect::class,
                // 'Redis' => \Illuminate\Support\Facades\Redis::class,
                'Request' => \Illuminate\Support\Facades\Request::class,
                'Response' => \Illuminate\Support\Facades\Response::class,
                'Route' => \Illuminate\Support\Facades\Route::class,
                'Schema' => \Illuminate\Support\Facades\Schema::class,
                'Session' => \Illuminate\Support\Facades\Session::class,
                'Storage' => \Illuminate\Support\Facades\Storage::class,
                'Str' => \Illuminate\Support\Str::class,
                'URL' => \Illuminate\Support\Facades\URL::class,
                'Validator' => \Illuminate\Support\Facades\Validator::class,
                'View' => \Illuminate\Support\Facades\View::class,
            ],
        ];

        foreach ($configAppend as $key => $value) {
            $app['config']->set("app.$key", $value);
        }
    }

    /**
     * @return array
     */
    protected function getLaravelConfig()
    {
        // config path
        $configFiles = [
            'default' => __DIR__ . '/config.php',
            'public' => base_path('config.php'),
        ];

        // default
        $configArray = [];

        foreach ($configFiles as $file) {
            if (! is_file($file)) {
                continue;
            }
            $filebody = include $file;

            if (! is_array($filebody)) {
                continue;
            }

            $configArray = array_replace($configArray, $filebody);
        }

        return $configArray;
    }
}
