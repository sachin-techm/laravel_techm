<?php

namespace App\Http\Middleware;

use Closure;

class Secure {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if ( env('APP_ENV') !== 'local' && env('IS_SSL') && !$request->secure()) {

            return redirect()->secure($request->getRequestUri());
        }

        $response = $next($request);

        /**
         * This middleware was created to prevent OWASP warnings, like:
         *
         * The X-Frame-Options header is not set in the HTTP response, meaning the page can potentially be loaded into
         * an attacker-controlled frame. This could lead to clickjacking, where an attacker adds an invisible layer on
         * top of the legitimate page to trick users into clicking on a malicious link or taking a harmful action.
         *
         * The X-Frame-Options allows three values: DENY, SAMEORIGIN and ALLOW-FROM. It is recommended to use DENY,
         * which prevents all domains from framing the page or SAMEORIGIN, which allows framing only by the same site.
         * DENY and SAMEORGIN are supported by all browsers. Using ALLOW-FROM is not recommended because not all browsers support it.
         *
         * For more information, access: https://cheatsheetseries.owasp.org/cheatsheets/Clickjacking_Defense_Cheat_Sheet.html
         *
         */

        // $response->headers->set('X-Frame-Options', 'ALLOW', true);
        // $response->headers->set('X-Frame-Options', 'DENY', true);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN', true);
        // $response->headers->set('X-Frame-Options', 'ALLOW', true);
        // $response->headers->set('X-Frame-Options', 'ALLOW-FROM https://www.example.com/', true);

        // <IfModule mod_headers.c> Header set X-Frame-Options ALLOW </IfModule>
        // <IfModule mod_headers.c> Header unset X-Frame-Options "SAMEORIGIN" </IfModule>
        return $response;
    }

}
