@extends('layout')

@section('nav')
    <search @update:query="(q) => this.query = q"></search>
@endsection

@section('main')
    <people :people="{{ json_encode($people) }}" :query="query"></people>
@endsection
