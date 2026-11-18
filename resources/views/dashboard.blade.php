@extends('layout.user')

@section('title', 'Roti Wonosari')

@push('styles')
    <link rel="stylesheet" href="/css/home.css">
@endpush

@section('content')
    <div class="alert alert-success">
        Selamat datang, {{ auth()->user()->name }}!
        Kamu berhasil login.
    </div>
@endsection