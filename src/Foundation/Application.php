<?php

namespace Larso\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    protected function registerBaseServiceProviders()
    {
        $this->register(new \Illuminate\Events\EventServiceProvider($this));
        $this->register(new \Illuminate\Log\LogServiceProvider($this));
        $this->register(new \Illuminate\Routing\RoutingServiceProvider($this));
    }
}
