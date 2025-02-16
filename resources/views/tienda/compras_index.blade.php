@extends('layouts.plantillabase')

@section('title','Home')
@section('h-title','Compras')
@section('card-title','QUALITY STORE')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->fecha }}</td>
                            <td>${{ number_format($venta->total, 2) }}</td>
                            <td>
                                <a href="{{ route('detalles_venta', $venta->id) }}" class="btn btn-primary">Detalle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
