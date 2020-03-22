<?php
namespace Chatbox\Laravel\Database;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class QuerylogServiceProvider extends ServiceProvider {

    public function boot()
    {
        if (env("APP_ENABLED_QUERYLOG",false)) {

            DB::listen(function (QueryExecuted $query) {
                logger()->debug($query->sql);
                logger()->debug(json_encode($query->bindings));
            });
        }
    }
}
