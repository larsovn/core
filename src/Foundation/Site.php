<?php

namespace Larso\Foundation;

class Site
{
    /**
     * @return void
     */
    public static function bootApp(string $basePath)
    {
        (new static())->bootLaravel($basePath);

        (new static())->createDirMissing();
    }

    /**
     * @return void
     */
    public function bootLaravel(string $basePath)
    {
        /**
         * @var \Larso\Foundation\Application $app
         */
        $app = new \Larso\Foundation\Application($basePath);

        $this->bootstrapApp($app);
    }

    /**
     * @return void
     */
    protected function bootstrapApp($app)
    {
        $app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \Larso\Foundation\Kernel::class
        );

        $app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Illuminate\Foundation\Exceptions\Handler::class
        );

        /**
         * @var \Larso\Foundation\Kernel $kernel
         */
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        $response = $kernel->handle(
            $request = \Illuminate\Http\Request::capture()
        )->send();

        $kernel->terminate($request, $response);
    }

    /**
     * Create Dir if missing
     *
     * @return void
     */
    protected function createDirMissing()
    {
        $dirs = [
            base_path('/bootstrap/cache'),
            config('cache.stores.file.path'),
            storage_path('framework/views'),
            config('cache.stores.file.path'),
            config('session.files'),
        ];

        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                continue;
            }

            mkdir($dir, 0777, true);
        }
    }
}
