<?php

namespace Larso\Database;

use Larso\Foundation\AbstractServiceProvider;
use Illuminate\Container\Container as ContainerImplementation;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->container->singleton(Manager::class, function (ContainerImplementation $container) {
            $manager = new Manager($container);

            $config = $container['larso']->config('database');

            if (! isset($config['driver'])) {
                $config['driver'] = 'mysql';
            }
            $config['engine'] = 'InnoDB';
            $config['prefix_indexes'] = true;

            $manager->addConnection($config, 'larso');

            return $manager;
        });

        $this->container->singleton(ConnectionResolverInterface::class, function (Container $container) {
            $manager = $container->make(Manager::class);
            $manager->setAsGlobal();
            $manager->bootEloquent();

            $dbManager = $manager->getDatabaseManager();
            $dbManager->setDefaultConnection('larso');

            return $dbManager;
        });

        $this->container->alias(ConnectionResolverInterface::class, 'db');

        $this->container->singleton(ConnectionInterface::class, function (Container $container) {
            $resolver = $container->make(ConnectionResolverInterface::class);

            return $resolver->connection();
        });

        $this->container->alias(ConnectionInterface::class, 'db.connection');
        $this->container->alias(ConnectionInterface::class, 'larso.db');
    }

    public function boot(Container $container)
    {
        LaravelModel::setConnectionResolver($container->make(ConnectionResolverInterface::class));
        LaravelModel::setEventDispatcher($container->make('events'));
    }
}
