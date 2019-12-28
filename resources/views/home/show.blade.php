@extends('layouts/landing')

@section('content')
    <h3 class="pt-4 text-2xl text-center">Welcome to Stripey</h3>
    <div>
        <p class="mb-4">
            Looking for someone? Stripey helps you find your colleagues during work hours. Through meticulous analysis of their agendas, Stripey can determine whether the person you're looking for is likely in a meeting, working from home, or on vacation.
        </p>
        <p>
            Stripey needs access to read your Google Calendar to work. The information is only be stored temporarily, and is regularly discarded.
        </p>
    </div>

    <div class="text-center my-8">
        <a class="w-full px-4 py-4 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline hover:underline" href="{{ route('login') }}">
            Sign in with your Google-account
        </a>
    </div>

    <div class="text-center">
        <hr class="mb-4 border-t" />
        <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
           href="https://www.jakobbuis.nl">
            Created by Jakob Buis
        </a>
    </div>
@endsection
