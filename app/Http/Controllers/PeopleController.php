<?php

namespace App\Http\Controllers;

use App\ActionLog;
use App\Http\Resources\Person as PersonResource;
use App\Person;
use App\Time;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    public function index(Time $time): View
    {
        if (!$time->isWorkingHours()) {
            return view('outside_working_hours');
        }

        ActionLog::logUsage(Auth::user());

        $all = Person::orderBy('name')->get();
        $people = PersonResource::collection($all);

        return view('people.index', compact('people'));
    }
}
