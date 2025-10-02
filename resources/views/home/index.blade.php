@extends('layout.app')

@section('title', 'Speed')
@section('content')

<x-nav-bar :$linkName class="fixed" />
@yield('layoutContent')
<x-footer></x-footer>
@endsection