@extends('home.index')
@section('layoutContent')

@switch($linkName)

@case('home')
@include('pages.home')
@break

@case('buy')
@include('pages.buy-car')
@break

@case('sell')
Your order is completed.
@break

@case('finance')
Your order is completed.
@break

@case('about')
Your order is completed.
@break

@default
Invalid status.
@endswitch

@endsection