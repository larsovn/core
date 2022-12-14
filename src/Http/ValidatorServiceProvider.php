<?php

namespace Larso\Http;

use Illuminate\Translation\Translator;
use Illuminate\Translation\ArrayLoader;

use Larso\Foundation\AbstractServiceProvider;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ValidatorServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton('validator', function () {
            $translator = new Translator(new ArrayLoader(), 'vi_VN');

            return new ValidatorFactory($translator);
        });
    }

    public function boot()
    {
        ValidatorFacade::setFacadeApplication($this->container);
    }
}
