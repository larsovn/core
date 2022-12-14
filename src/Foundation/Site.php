<?php

namespace Larso\Foundation;

use RuntimeException;
use Illuminate\Cache\FileStore;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Filesystem\Filesystem;
use Larso\Http\RequestServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Larso\Http\ValidatorServiceProvider;
use Larso\Session\SessionServiceProvider;
use Illuminate\Contracts\Cache\Repository;
use Larso\Database\DatabaseServiceProvider;
use Illuminate\Contracts\Container\Container;
use Larso\Filesystem\FilesystemServiceProvider;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;

class Site
{
    /**
     * @var Paths
     */
    protected static $paths;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Application
     */
    protected $application;

    public static function bootApp(array $paths)
    {
        static::$paths = new Paths($paths);

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        (new static())->bootLaravel();
    }

    protected function bootLaravel(): Container
    {
        $container = new \Illuminate\Container\Container();
        $laravel = new Application($container, static::$paths);

        $this->config = $this->loadConfig(static::$paths->base);

        // DatabaseService::boot($this->config['database']);

        $container->instance('config', $config = $this->getIlluminateConfig());

        $container->instance('env', 'production');
        $container->instance('larso.config', $this->config);
        $container->alias('larso.config', Config::class);
        $container->instance('config', $config = $this->getIlluminateConfig());

        $this->registerCache($container);

        $laravel->register(FilesystemServiceProvider::class);
        $laravel->register(SessionServiceProvider::class);
        $laravel->register(RequestServiceProvider::class);
        $laravel->register(ViewServiceProvider::class);
        $laravel->register(DatabaseServiceProvider::class);
        $laravel->register(ValidatorServiceProvider::class);

        $laravel->boot();

        return $container;
    }

    public function loadConfig($basePath): Config
    {
        $file = "$basePath/config.php";

        if (! is_file($file)) {
            throw new RuntimeException('config.php not found');
        }

        $config = include $file;

        if (! is_array($config)) {
            throw new RuntimeException('config.php should return an array');
        }

        return new Config($config);
    }

    /**
     * @return ConfigRepository
     */
    protected function getIlluminateConfig()
    {
        return new ConfigRepository([
            'app' => [
                'timezone' => 'Asia/Ho_Chi_Minh',
            ],
            'view' => [
                'paths' => [
                    static::$paths->base . '/views',
                ],
                'compiled' => static::$paths->storage . '/views',
            ],
            'session' => [
                'lifetime' => 120,
                'files' => static::$paths->storage . '/sessions',
                'cookie' => 'session',
            ],
        ]);
    }

    /**
     * Register Cache Laravel
     *
     * @param Container $container
     * @return void
     */
    protected function registerCache(Container $container)
    {
        $container->singleton('cache.store', function ($container) {
            return new CacheRepository($container->make('cache.filestore'));
        });
        $container->alias('cache.store', 'cache');
        $container->alias('cache.store', Repository::class);

        $container->singleton('cache.filestore', function () {
            return new FileStore(new Filesystem(), static::$paths->storage . '/cache');
        });
        $container->alias('cache.filestore', Store::class);
    }
}
