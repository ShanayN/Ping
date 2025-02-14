@extends('layouts.app')

@section('content')
    <profile
        :user='@json($user)'
        :is-current-user='@json($isCurrentUser)'
        :is-following='@json($isFollowing)'
    >
    </profile>
@endsection
