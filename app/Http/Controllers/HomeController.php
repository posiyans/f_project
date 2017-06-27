<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use Auth;
use App\User;
use App\Model\Medical\Med_Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $med_roles= Med_Role::all();
        //dump($med_roles[0]->name);
        $roles=User::find(1);
        $r=$roles->med_roles;
        //dump($r->all()[0]->name);
        return view('home');
    }
}
