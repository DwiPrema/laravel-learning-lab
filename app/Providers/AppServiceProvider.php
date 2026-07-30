<?php

namespace App\Providers;

use App\Services\SayHello;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SayHello::class, function () {
            return new SayHello();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::listen(function (QueryExecuted $query){
            Log::info($query->sql);
        });

        Blade::directive("hello", function ($expression) {
            return "<?php echo 'Hello ' . $expression; ?>";
        });
    }
}
