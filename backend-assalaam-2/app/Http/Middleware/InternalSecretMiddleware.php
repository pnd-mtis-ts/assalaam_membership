<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class InternalSecretMiddleware
{
    public function handle($request, Closure $next)
    {
        $headerSecret = $request->header('X-Internal-Secret');
        $configSecret = config('services.backend1.secret'); // ✅ ambil dari config/services.php

        if ($headerSecret !== $configSecret) {
            Log::error('Secret mismatch', [
                'header' => $headerSecret,
                'expected' => $configSecret,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized - Invalid Secret',
            ], 401);
        }

        return $next($request);
    }
}
