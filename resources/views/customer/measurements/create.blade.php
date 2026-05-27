@extends('layouts.customer')

@section('title', 'Tambah Ukuran')
@section('page-title', 'Tambah Ukuran')
@section('page-subtitle', 'Simpan profil ukuran untuk pesanan custom')

@section('content')
<form action="{{ route('customer.measurements.store') }}" method="POST">
    @include('customer.measurements._form')
</form>
@endsection
