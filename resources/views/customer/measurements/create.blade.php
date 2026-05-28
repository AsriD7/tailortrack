@extends('layouts.customer')

@section('title', 'Tambah Ukuran')

@section('content')
<section class="mb-6 rounded-[2rem] bg-tailor-cream p-5 shadow-sm ring-1 ring-tailor-purple/10 sm:p-7">
    <span class="inline-flex rounded-full bg-white px-4 py-2 text-xs font-black text-tailor-purple shadow-sm ring-1 ring-tailor-purple/10">Ukuran Custom</span>
    <h1 class="mt-5 text-3xl font-black text-tailor-deep">Tambah Ukuran</h1>
    <p class="mt-2 text-sm leading-7 text-slate-600">Simpan profil ukuran agar bisa dipilih saat membuat pesanan custom.</p>
</section>

<form action="{{ route('customer.measurements.store') }}" method="POST">
    @include('customer.measurements._form')
</form>
@endsection
