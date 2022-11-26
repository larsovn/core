<?php

namespace Larso\Filesystem;

use Illuminate\Filesystem\Filesystem;
use Larso\Foundation\AbstractServiceProvider;

class FilesystemServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton('files', function () {
            return new Filesystem();
        });
    }
}
