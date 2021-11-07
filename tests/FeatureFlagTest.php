<?php

namespace Jhacobs\FeatureFlag\Tests;

use Jhacobs\FeatureFlag\Http\Middleware\FeatureFlag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class FeatureFlagTest extends TestCase
{
    /** @test */
    public function it_can_get_all_feature_flags(): void
    {
        $this->getJson('api/feature-flags')
            ->assertJson([
                'data' => [
                    'feature-1' => true,
                    'feature-2' => false,
                    'feature-3' => true,
                ],
            ]);
    }

    /** @test */
    public function it_can_get_all_feature_flags_for_an_environment(): void
    {
        config(['app.env' => 'production']);
        $this->getJson('api/feature-flags')
            ->assertJson([
                'data' => [
                    'feature-1' => false,
                ],
            ]);
    }

    /** @test */
    public function routes_can_be_accessed_if_the_feature_flag_is_turned_on(): void
    {
        config(['feature-flag.testing' => [
            'feature-1' => true,
        ]]);

        $request = Request::create('/feature', 'GET');

        $middleware = new FeatureFlag();

        $response = $middleware->handle($request, static function () {
        }, 'feature-1');

        $this->assertNull($response);
    }

    /** @test */
    public function routes_cannot_be_accessed_if_the_feature_flag_is_turned_off(): void
    {
        config(['feature-flag.testing' => [
            'feature-1' => false,
        ]]);

        $request = Request::create('/feature', 'GET');

        $middleware = new FeatureFlag();

        $response = $middleware->handle($request, static function () {
        }, 'feature-1');

        $this->assertSame([
            'data' => [
                'message' => 'This feature is unavailable',
            ],
        ], $response->getOriginalContent());

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->status());
    }

    /** @test */
    public function it_can_redirect_to_another_route_if_the_feature_flag_is_turned_off(): void
    {
        config(['feature-flag.testing' => [
            'feature-1' => false,
        ]]);

        Route::get('test-route', static function () {
        })->name('test-route');

        $request = Request::create('/feature', 'GET');

        $middleware = new FeatureFlag();

        $response = $middleware->handle($request, static function () {
        }, 'feature-1', 'test-route');

        $this->assertSame(Response::HTTP_FOUND, $response->status());
    }
}
