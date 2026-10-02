<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// --- podman stack test routes ---
Route::get('/stack-test', function () {
    \Illuminate\Support\Facades\Cache::put('stack-test', now()->toIso8601String(), 60);

    return [
        'app'         => config('app.name'),
        'container'   => gethostname(),
        'database'    => \Illuminate\Support\Facades\DB::selectOne('select version() as v')->v,
        'redis_cache' => \Illuminate\Support\Facades\Cache::get('stack-test'),
    ];
});

Route::get('/stack-test/queue', function () {
    dispatch(function () {
        logger()->info('Queue works for '.config('app.name'));
    });

    return ['queued' => true];
});
