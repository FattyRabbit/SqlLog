<?php

namespace FattyRabbit\SqlLog;


use FattyRabbit\SqlLog\Utils\NetUtils;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Monolog\Logger;

class SqlLogProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/../config/sqllog.php') ?: $raw;
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('sqllog.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('sqllog');
        }
        if ($this->app instanceof LaravelApplication && ! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom($source, 'sqllog');
        }

        $logLevel = Logger::toMonologLevel(config('app.log_level'));
        $startLevel = Logger::toMonologLevel(config('sqllog.base_level'));
        $ignoreIps = config('sqllog.ignore.ip');
        $ignoreUris = config('sqllog.ignore.uri');

        // app.debugがtrueの場合クエリをログに出力する。
        if ($logLevel <= $startLevel) {
            DB::listen(function($query) use ($ignoreIps, $ignoreUris, $startLevel) {
                foreach ($ignoreIps as $ignoreIp) {
                    if (NetUtils::isIn(\Request::ip(), $ignoreIp)) {
                        return;
                    }
                }
                foreach ($ignoreUris as $ignoreUri) {
                    if (Request::is($ignoreUri)) {
                        return;
                    }
                }

                Log::{$startLevel}('QUERY:[' . $query->sql . '] BINDINGS:' . json_encode($query->bindings), ['TIME' => $query->time]);
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}