<?php

namespace App\Http\Controllers;

use App\Http\Resources\Person as PersonResource;
use App\Person;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    public function index() : View
    {
        $user = Session::get('oauth.user');

        if (!$this->workingHours()) {
            return view('outside_working_hours', compact('user'));
        }

        $all = Person::orderBy('name')->get();
        $people = PersonResource::collection($all);


        return view('people.index', compact('people', 'user'));
    }

    /**
     * Determine if we are current inside working hours (9AM - 17:30)
     */
    public function workingHours() : bool
    {
        $now = Carbon::now();
        $start = new Carbon('09:00');
        $end = new Carbon('17:30');

        return $now >= $start && $now <= $end;
    }
}
