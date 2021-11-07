<?php

namespace Jhacobs\FeatureFlag\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class FeatureFlag
{
    public function handle(Request $request, Closure $next, string $flag, string $redirect = null)
    {
        $featureFlag = Arr::get(config('feature-flag.' . app()->environment()), $flag);

        if ($featureFlag !== false) {
            return $next($request);
        }

        if ($redirect) {
            return redirect()->route($redirect);
        }

        return response()->json([
            'data' => [
                'message' => 'This feature is unavailable',
            ],
        ], Response::HTTP_NOT_FOUND);
    }
}
