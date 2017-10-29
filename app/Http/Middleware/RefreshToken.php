<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshToken
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
        try {
//            $old_token = JWTAuth::getToken();
           $old_token_data = JWTAuth::parseToken()->authenticate();
//            if($old_token_data->login_time >= $old_token_data->login_time + 3600){
//                $token = JWTAuth::refresh($old_token);
//                JWTAuth::invalidate($old_token);
//                $request->add($token);
//            }
        } catch (TokenExpiredException $e) {
            $old_token = JWTAuth::getToken();
            $token = JWTAuth::refresh($old_token);
            JWTAuth::invalidate($old_token);
            return response()->json(['code' => $e->getCode(),'msg' => 'token已过期','newToken' => $token]);
        } catch (JWTException $e) {
            return response()->json( ['code' => -1,'msg' => 'token异常','errmsg' => $e->getMessage()] );
        }
        return $next($request);
    }
}
