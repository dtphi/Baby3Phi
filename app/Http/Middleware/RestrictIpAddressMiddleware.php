<?php
/**
 * Restrict ip address middleware.
 */

namespace App\Http\Middleware;

use Log;
use Closure;
use App\Models\RestrictIp;
use Illuminate\Http\Request;

class RestrictIpAddressMiddleware
{
    /**
     * @var array
     */
    private $__restrictedIp = [];

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $clientIp = $request->ip();
        $this->getIps($clientIp);
        if (!empty($this->__restrictedIp)) {
            if (in_array($clientIp, $this->__restrictedIp)) {
                return $next($request);
            }

            abort(404);
        } else {
            if (fn_is_prod_env()) 
                abort(404);
        }

        return $next($request);
    }

    /**
     * get sec ips
     */
    public function getIps($dbClientIp = null)
    {
        $ips = config('app.sec_ips');
        
        if (!empty($ips)) {
            $this->__restrictedIp = explode(',', $ips);
        }

        $model = null;
        if ($dbClientIp) {
            $model = RestrictIp::where('ip', '=', $dbClientIp)
            ->where('active', '1')->first();
        }
        
        if ($model && isset($model->ip)) {
            array_push($this->__restrictedIp, $model->ip);
        }
       
        return $ips; 
    }
}
