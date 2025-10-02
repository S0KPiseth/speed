<div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
</div>
@extends('home.index')
@section('layoutContent')

@switch($linkName)

@case('home')
@include('pages.home')
@break

@case('buy')
Your order is completed.
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