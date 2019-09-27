@extends('layout')

@section('content')
    <people :people="{{ json_encode($people) }}"></people>
@endsection
