<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AddRequestContext
{
    /**
     * Add the request id and the authenticated user id to the log context.
     *
     * The context is added to every log entry and is also passed to the jobs dispatched during the request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        Context::add('request_id', (string) Str::uuid());

        if ($request->user()) {
            Context::add('user_id', $request->user()->id);
        }

        return $next($request);
    }
}
