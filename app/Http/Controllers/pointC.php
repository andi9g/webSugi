<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class pointC extends Controller
{
    public function point(Request $request) {
        if($request->session()->get('point') == true) {
            $request->session()->put('point', false);
        }else {
            $request->session()->put('point', true);
        }
        return redirect()->back()->withInput();

    }
}
