@extends('layout')

@section('main')
    <div class="m-4 max-w-md">
        <h1 class="font-bold text-2xl mb-4">
            Your colleagues aren't working
        </h1>
        <p class="mb-4">
            <em>And neither should you.</em> Its currently
            {{ Carbon\Carbon::now()->format('H:i') }} (outside of our regular
            working hours). We are ethically unable to determine the
            whereabouts of your colleagues.
        </p>
        <p>
            Go, and enjoy your time outside of work!
        </p>
    </div>
@endsection
