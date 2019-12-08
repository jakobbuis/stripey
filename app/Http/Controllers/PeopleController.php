<?php

namespace App\Http\Controllers;

use App\Http\Resources\Person as PersonResource;
use App\Person;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    public function index(Time $time): View
    {
        $user = Session::get('oauth.user');

        if (!$time->isWorkingHours()) {
            return view('outside_working_hours', compact('user'));
        }

        $all = Person::orderBy('name')->get();
        $people = PersonResource::collection($all);


        return view('people.index', compact('people', 'user'));
    }
}
