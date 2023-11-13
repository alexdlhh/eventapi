<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Labels\Lang;

class Authenticate {
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * The Lang instance.
     * 
     * @var \App\Labels\Lang
     */
    protected $lang;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, Lang $lang)
    {
        $this->auth = $auth;
        $this->lang = $lang;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!empty($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'en';
        }
        if ($this->auth->guard($guard)->guest()) {
            return response($this->lang->_t('Unauthorized access. ',$lang), 401);
        }else{
            $user = $this->auth->guard($guard)->user();
        }
        $request->header('Access-Control-Allow-Origin', '*');
        $request->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $request->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        return $next($request);
    }
}
