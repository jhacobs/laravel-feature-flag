<?php

namespace Jhacobs\FeatureFlag\Http\Controllers;

use Illuminate\Http\JsonResponse;

class FeatureFlagController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => config('feature-flag.' . config('app.env')),
        ]);
    }
}
