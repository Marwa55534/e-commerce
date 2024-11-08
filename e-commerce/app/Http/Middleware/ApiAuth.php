<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $access_token = $request->header("access_token");
        if($access_token != null){
            $user = User::where("access_token",$access_token)->first();
            if($user){
                if($user->role == "admin"){
                    return $next($request);

                }else{
                    return response()->json([
                    "msg"=>"user type not admin",
                    ],301);
                }

            }else{
                return response()->json([
                "msg"=>"access token not correct",
                ],404);
            }
        }else{
            return response()->json([
            "msg"=>"access token not found",
            ],404);
        }
    }
}
