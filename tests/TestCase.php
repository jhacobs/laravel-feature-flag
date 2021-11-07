<?php

namespace Jhacobs\FeatureFlag\Tests;

use Jhacobs\FeatureFlag\FeatureFlagServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [FeatureFlagServiceProvider::class];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('feature-flag.testing', [
            'feature-1' => true,
            'feature-2' => false,
            'feature-3' => true,
        ]);

        $app['config']->set('feature-flag.production', [
            'feature-1' => false,
        ]);
    }
}
