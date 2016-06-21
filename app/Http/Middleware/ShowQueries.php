<?php
namespace App\Http\Middleware;

use Illuminate\Http\Response;

class ShowQueries
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        /* @var Response */
        $response = $next($request);
        $content = $response->getContent();
        $content .= sprintf('<script type="application/javascript">sql = %s;console.log(sql)</script>', app('queries')->toJson());
        $response->setContent($content);

        return $response;
    }
}
