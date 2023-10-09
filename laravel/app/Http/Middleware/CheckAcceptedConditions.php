<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAcceptedConditions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checkRoles = [config('constants.ROLES.COMPANY.ID'), config('constants.ROLES.EXTERNAL.ID'), config('constants.ROLES.CONSTRUCTION_MANAGER.ID')];
        $currentRoleUser = Auth::user()
            ->roles->pluck('id')
            ->first();
        $accepted_condition = Auth::user()->accepted_condition;

        if (in_array($currentRoleUser, $checkRoles) && !$accepted_condition) {
            $request->request->add(['accepted_condition' => $accepted_condition]); //add request
            return $next($request);
        } else {
            $request->request->add(['accepted_condition' => 1]); //add request
            return $next($request);
        }
    }
}
