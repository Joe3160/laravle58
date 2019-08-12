<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Monolog\Handler\RotatingFileHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        //
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $log = $query->sql . ' [ RunTime:' . $query->time . 'ms ]';
                // $bindings = $query->bindings;
                $bindings = array_map(function ($item) {
                    return is_string($item) ? "\"" . $item . "\"" : $item;
                }, $query->bindings);
                $log = Str::replaceArray('?', $bindings, $log);
                info($log);
                // (new \Monolog\Logger('sql'))->pushHandler(new RotatingFileHandler(storage_path('logs/sql/sql.log')))->info($log);
                // info($log);
            });
        }

    }
}
