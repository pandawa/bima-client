<?php

declare(strict_types=1);

namespace Pandawa\Bima\Client\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class BimaAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() === config('bima.secret')) {
            return $next($request);
        }

        throw new Exception('Invalid bima secret', 401);
    }
}
