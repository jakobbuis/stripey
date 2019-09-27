<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PeopleController extends Controller
{
    public function index() : View
    {
        $people = Cache::get('people');
        return view('people.index', ['people' => $people]);
    }
}
