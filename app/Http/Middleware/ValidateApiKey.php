<?php

namespace App\Http\Middleware;

use Closure;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $defaultApiKey = 7838224947;

        $apiKey = $request->ApiKey;

        if ($apiKey == $defaultApiKey)
        {
            $request->validationDone = true;
        }
        else
        {
            $request->validationDone = false;
        }

        return $next($request);
    }
}
