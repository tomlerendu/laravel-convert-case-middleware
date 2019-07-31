<?php

namespace TomLerendu\LaravelConvertCaseMiddleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConvertResponseToCamelCase extends ConvertToCase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $response->setData(
                $this->convertKeysToCase(
                    self::CASE_CAMEL,
                    json_decode($response->content(), true)
                )
            );
        }

        return $response;
    }
}
