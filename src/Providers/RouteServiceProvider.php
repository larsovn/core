<?php

namespace Larso\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @var string
         */
        $routeFile = config('app.route_file', base_path('web.php'));

        $dir = Str::beforeLast($routeFile, '/');

        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (! is_file($routeFile)) {
            file_put_contents($routeFile, $this->routeStubs());
        } else {
            $this->routes(function () use ($routeFile) {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group($routeFile);
            });
        }
    }

    public function routeStubs()
    {
        return <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return '<h1>View Here</h1>';
});
PHP;
    }
}
