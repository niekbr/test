<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- podman stack test routes ---
Route::get('/stack-test', function () {
    Cache::put('stack-test', now()->toIso8601String(), 60);

    return [
        'app' => config('app.name'),
        'container' => gethostname(),
        'database' => DB::selectOne('select version() as v')->v,
        'redis_cache' => Cache::get('stack-test'),
        'categories' => Category::query()->count(),
        'posts' => Post::query()->count(),
    ];
});

Route::get('/stack-test/queue', function () {
    dispatch(function () {
        logger()->info('Queue works for '.config('app.name'));
    });

    return ['queued' => true];
});
