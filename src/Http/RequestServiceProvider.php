<?php

namespace Larso\Http;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Larso\Foundation\AbstractServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Request as FacadesRequest;

class RequestServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton('request', function () {
            return Request::capture();
        });
    }

    public function boot()
    {
        FacadesRequest::setFacadeApplication($this->container);
    }
}
