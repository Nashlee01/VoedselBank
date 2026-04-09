@extends('layouts.app')

@section('content')
<form action="{{ route('klanten.update', ['klanten' => $klant->klant_id]) }}" method="POST">
    @csrf
    @method('PUT')

    @include('klanten._form', ['klant' => $klant])
</form>
@endsection