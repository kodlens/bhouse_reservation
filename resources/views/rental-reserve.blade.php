@extends('layouts.main-navbar')


@section('content')
    <rental-reserve :prop-rental='@json($rental)'></rental-reserve>

@endsection
