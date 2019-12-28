@extends('layouts/master')

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
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
