<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct( Auth $auth )
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle( $request, Closure $next, $guard = null )
    {
        // เช็คถถ้า api key ถูก กับยืนยัน userid ที่ตรวจสอบแล้ว มากับ request
        // ถ้าไม่ได้รับการตรวจสอบจะ return Unauth
        if ( $this->auth->guard( $guard )->guest() )
        {
            return response()->json( ['error' => 'Unauthorized'], 401 );
        }

        return $next( $request );
    }
}
