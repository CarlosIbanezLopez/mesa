@extends('layouts.plantillabase')

@section('title', 'Home')
@section('h-title', 'Bienvenido')
@section('card-title', 'QUALITY STORE')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    {{ __('Bienvenido, :name', ['name' => Auth::user()->name]) }}
    <div class="mt-4">
        <p>Esta página ha sido visitada <strong>{{ $count }}</strong> veces.</p>
    </div>
    
@endsection
