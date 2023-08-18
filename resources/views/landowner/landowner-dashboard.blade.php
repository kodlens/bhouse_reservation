@extends('layouts.landowner-app')

@section('content')
    <landowner-dashboard prop-user='@json($user)'></landowner-dashboard>
@endsection

