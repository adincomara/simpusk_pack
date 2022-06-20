<?php

namespace App\Http\Middleware;

use App\Models\Simpusk\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class CheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = $_SERVER['HTTP_X_USERNAME'];
        // $token = $_SERVER['HTTP_X_TOKEN'];
        // if($user != 'apiantreanbpjsjepang123' || $token != JWTAuth::parseToken()->authenticate()){
            // abort(response()->json(['error' => 'Unauthenticated!']), 401);
        // }
        // return $next($request);

        $credentials = array(
            'username' => 'apiantreanbpjsjepang123',
            'password' => 'antreanbpjs@2021'
        );
        $X_token = $_SERVER['HTTP_X_TOKEN'];
        $user = $_SERVER['HTTP_X_USERNAME'];

        // $users = JWTAuth::toUser($X_token);
        // $usersss = User::where('id', Auth::id())->first();
        // // $userdata = JWTAuth::fromUser($users);
        // abort(response()->json(['error' => 'Unauthenticated!', 'message' => JWTAuth::user()]), 401);
        try{
            $users = JWTAuth::setToken($X_token)->toUser();
            if(Auth::id() != 5){
                abort(response()->json(['error' => 'Unauthenticated!']), 401);
            }else{
                if($user != 'apiantreanbpjsjepang123'){
                    abort(response()->json(['error' => 'Unauthenticated!']), 401);
                }
                return $next($request);
            }

        }catch(Exception $e){
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    abort(response()->json(['error' => 'Token Invalid!']), 401);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    abort(response()->json(['error' => 'Token Expired!']), 401);
                } else if ( $e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                    abort(response()->json(['error' => 'Unauthenticated!']), 401);
                }else{
                    abort(response()->json(['error' => 'Unauthenticated!']), 401);
                }

        }
    }
}
