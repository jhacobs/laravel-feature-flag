<?php

use Jhacobs\FeatureFlag\Http\Controllers\FeatureFlagController;
use Illuminate\Support\Facades\Route;

Route::get('api/feature-flags', [FeatureFlagController::class, 'index']);
