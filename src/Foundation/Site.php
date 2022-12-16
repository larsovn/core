<?php

namespace Larso\Foundation;

use Illuminate\Support\Arr;

class Site
{
    /**
     * @return void
     */
    public static function bootApp(string $basePath)
    {
        // Create cache folder because laravel require it for boot app
        $cacheDir = $basePath . '/bootstrap/cache';
        if (! is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        (new static())->bootLaravel($basePath);
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
        );

        $kernel->terminate($request, $response);
    }

    /**
     * Appends to config database - ['username', 'password', 'database']
     *
     * @param array $values
     * @return void
     */
    public static function setDatabase(array $values)
    {
        if (! is_array($values) && blank($values)) {
            throw new \RuntimeException('values require is array and not blank');
        }

        if (Arr::isList($values)) {
            throw new \InvalidArgumentException(
                '[values] is array Assoc'
            );
        }

        foreach ($values as $key => $value) {
            config([
                "database.connections.mysql.$key" => $value,
            ]);
        }
    }
}
