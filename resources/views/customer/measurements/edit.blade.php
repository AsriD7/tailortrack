@extends('layouts.customer')

@section('title', 'Edit Ukuran')
@section('page-title', 'Edit Ukuran')
@section('page-subtitle', 'Perbarui profil ukuran custom')

@section('content')
<form action="{{ route('customer.measurements.update', $measurement) }}" method="POST">
    @method('PUT')
    @include('customer.measurements._form')
</form>
@endsection
