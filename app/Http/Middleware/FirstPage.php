<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FirstPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            /** @var User $user */
            $user = Auth::user();

            // if user is not admin take him to his dashboard
            // allow admin to proceed with request
            if ($user->role == "Sponsor" ) {
                return redirect()->route('sponsor');
            }
            else if ( $user->role == "Student" ) {
                return redirect()->route('student');
                // return view('student.index');
            }
            else if ($user->role == "Admin") {
                return $next($request);
            }
        }

        abort(403);  // permission denied error
    }


}
