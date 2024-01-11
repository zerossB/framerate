<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (! $this->app->runningUnitTests()) {
            return;
        }

        AssertableInertia::macro('hasResource', function (string $key, JsonResource $value) {
            $this->has($key);

            expect($this->prop($key))
                ->toEqual($value->response()->getData(true));

            return $this;
        });

        AssertableInertia::macro('hasPaginatedResource', function (string $key, ResourceCollection $value) {
            $this->hasResource("{$key}.data", $value);

            expect($this->prop($key))
                ->toHaveKeys(['data', 'links', 'meta']);

            return $this;
        });

        TestResponse::macro('assertHasResource', function (string $key, JsonResource $value) {
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasResource($key, $value));
        });

        TestResponse::macro('assertHasPaginatedResource', function (string $key, JsonResource $value) {
            return $this->assertInertia(fn (AssertableInertia $inertia) => $inertia->hasPaginatedResource($key, $value));
        });
    }
}
