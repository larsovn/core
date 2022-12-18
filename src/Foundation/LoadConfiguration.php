<?php

namespace Larso\Foundation;

use Illuminate\Support\Arr;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as BaseLoadConfiguration;

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
    }

    /**
     * Merge config user to default nested
     *
     * @param array $array
     * @param array $original
     * @return array
     */
    protected function configNested($array, $original)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (isset($original[$key])) {
                    if (Arr::isAssoc($value)) {
                        $original[$key] = $this->configNested($value, $original[$key]);
                    } else {
                        $original[$key] = array_merge($original[$key], $value);
                    }
                } else {
                    $original[$key] = $value;
                }
            } else {
                $original[$key] = $value;
            }
        }

        return $original;
    }

    /**
     * @return array
     */
    protected function getLaravelConfig()
    {
        /**
         * @var array
         */
        $configDefault = include dirname(__DIR__) . '/config_default.php';

        /**
         * @var array
         */
        $configUser = [];
        if (is_file(base_path('config.php'))) {
            $configUser = include base_path('config.php');
        }

        if (collect($configUser)->isNotEmpty()) {
            $configDefault = $this->configNested($configUser, $configDefault);
        }

        return $configDefault;
    }
}
