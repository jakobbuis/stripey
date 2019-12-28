@extends('layout')

@section('main')
    <div class="h-screen w-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
        <!-- Container -->
        <div class="container mx-auto">
            <div class="flex justify-center px-6 my-12">
                <!-- Row -->
                <div class="w-full xl:w-3/4 lg:w-11/12 flex">
                    <!-- Col -->
                    <div
                        class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
                        style="background-image: url('/images/dog.jpg'); height: 600px;"
                    ></div>
                    <!-- Col -->
                    <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none flex flex-col justify-between px-8 py-4">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
