<?php

namespace Larso\Session;

use Larso\Foundation\Config;
use SessionHandlerInterface;
use Larso\Session\SessionManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Container\Container;
use Larso\Foundation\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->singleton('larso.session.drivers', function () {
            return [];
        });

        $this->container->singleton('session', function (Container $container) {
            $manager = new SessionManager($container);
            $drivers = $container->make('larso.session.drivers');
            $config = $container->make(Config::class);

            /**
             * Default to the file driver already defined by Laravel.
             *
             * @see \Illuminate\Session\SessionManager::createFileDriver()
             */
            $manager->setDefaultDriver('file');

            foreach ($drivers as $driver => $className) {
                /** @var SessionDriverInterface $driverInstance */
                $driverInstance = $container->make($className);

                $manager->extend($driver, function () use ($config, $driverInstance) {
                    return $driverInstance->build($config);
                });
            }

            return $manager;
        });

        $this->container->alias('session', SessionManager::class);

        $this->container->singleton('session.handler', function (Container $container): SessionHandlerInterface {
            /** @var SessionManager $manager */
            $manager = $container->make('session');

            return $manager->handler();
        });

        $this->container->alias('session.handler', SessionHandlerInterface::class);
    }

    public function boot()
    {
        Session::setFacadeApplication($this->container);
    }
}
