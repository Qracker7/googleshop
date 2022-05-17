<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FileManager
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
        $urls = ['upload', 'delete', 'paste', 'rename', 'create-directory', 'create-file', 'zip', 'unzip'];  
        $result = 1;
        foreach($urls as $url) {
            if (str_contains($request->url(), $url)) $result = 0;
        }
        
        if ($result) {
            return $next($request);
        }
        else {
             return response()->json([
                'result' => [
                    'status'  => 'error',
                    'message' => 'aclError',
                ],
            ]);
        }
    }
}