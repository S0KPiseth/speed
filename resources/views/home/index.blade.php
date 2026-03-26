{{-- TODO:Complete verification page --}}
@extends('layout.app')

@section('title', 'Prime Motor')
@section('content')
@php
$temp = null
@endphp
<x-nav-bar class="fixed" />
@yield('layoutContent')
<x-footer></x-footer>
@endsection