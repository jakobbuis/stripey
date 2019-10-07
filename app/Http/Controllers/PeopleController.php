<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    public function index() : View
    {
        $people = Cache::get('people');
        $user = Session::get('oauth.user');
        return view('people.index', compact('people', 'user'));
    }
}
