@extends('layout.app')

@section('title', 'Speed')
@section('content')
@php
$temp = null
@endphp
<x-nav-bar :$linkName class="fixed" :$user />
@yield('layoutContent')
<x-footer></x-footer>
@endsection