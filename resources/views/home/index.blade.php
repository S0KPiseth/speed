@extends('layout.app')

@section('title', 'Speed')
@section('content')
@php
$temp = null
@endphp
<x-nav-bar class="fixed" />
@yield('layoutContent')
<x-footer></x-footer>
@endsection