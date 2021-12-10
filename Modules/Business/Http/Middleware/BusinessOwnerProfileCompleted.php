<?php

namespace Modules\Business\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Business\Traits\ApiResponseHandler;

class BusinessOwnerProfileCompleted
{


    use ApiResponseHandler;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {

        // if the business owner profile is not completed
        if (! $request->user('business')->hasCompletedOwnerProfile()) {
            return $this->sendResponse([
                'status'=> false,
                'message'=> 'You have to complete business owner profile',
                'httpcode'=> 403
            ]);
        }


        return $next($request);
    }
}
