<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * The locales the application can be displayed in.
     *
     * @var array<int, string>
     */
    public const SUPPORTED_LOCALES = ['pt_PT', 'en_GB'];

    /**
     * Apply the locale chosen by the user in a previous request, if any.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (in_array($locale, self::SUPPORTED_LOCALES, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
