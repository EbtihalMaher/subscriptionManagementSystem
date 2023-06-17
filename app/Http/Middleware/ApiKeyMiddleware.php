<?php

namespace App\Http\Middleware;

use App\Models\Enterprise;
use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $apiKey = $request->header('api_key');

        $enterprise = Enterprise::where('api_key', $apiKey)->first();

        if (!$enterprise) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        session()->put('enterprise_id', $enterprise->id);

        return $next($request);
    
    }
}
