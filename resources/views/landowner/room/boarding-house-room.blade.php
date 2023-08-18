@extends('layouts.landowner-app')



@section('content')

    <boarding-house-room :prop-boarding-house='@json($bhouse)' prop-route-back="{{url()->previous()}}"></boarding-house-room>


@endsection

