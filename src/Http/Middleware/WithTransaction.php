<?php
namespace Chatbox\Laravel\Database\Http\Mideleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WithTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();

        try {
            $response = $next($request);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        if ($response instanceof Response && $response->getStatusCode() > 399) {
            \DB::rollBack();
        } else {
            \DB::commit();
        }

        return $response;
    }


}
