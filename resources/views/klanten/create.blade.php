@extends('layouts.app')

@section('content')
<form action="{{ route('klanten.store') }}" method="POST">
    @csrf

    @include('klanten._form')
</form>
@endsection