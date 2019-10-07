@extends('layout')

@section('content')
    <header>
        <div class="bg-blue-800 p-4 flex justify-between">
            <div class="flex w-3/4 max-w-lg">
                <h1 class="text-white font-bold mr-4 mt-2 text-xl">Stripey</h1>
                <search @update:query="(q) => this.query = q"></search>
            </div>

            <div class="ml-4 rounded p-2 text-white flex" style="background-color:rgba(255, 255, 255, 0.1);">
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" heigth="24" width="24"
                     class="rounded-full">
                <a href="{{ route('logout') }}" class="ml-2 align-baseline my-auto hover:underline">
                    Sign&nbsp;out
                </a>
            </div>

        </div>
    </header>

    <main>
        <people :people="{{ json_encode($people) }}" :query="query"></people>
    </main>
@endsection
