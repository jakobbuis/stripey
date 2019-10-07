<?php

namespace App\Http\Controllers;

use App\Http\Resources\Person as PersonResource;
use App\Person;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    public function index() : View
    {
        $all = Person::orderBy('name')->get();
        $people = PersonResource::collection($all);

        $user = Session::get('oauth.user');

        return view('people.index', compact('people', 'user'));
    }
}
