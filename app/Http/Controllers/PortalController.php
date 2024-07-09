<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    public function portal_home()
    {
        if(Auth::user()) {
            //Show home portal only if the user is authenticated.
            return view('portal.portal_home');
        }
        else {
            return redirect()->route('login');
        }
    }
}
