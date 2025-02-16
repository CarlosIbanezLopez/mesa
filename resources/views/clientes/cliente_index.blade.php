@extends('layouts.plantillabase')

@section('title', 'Home')
@section('h-title', 'Usuarios')
@section('card-title', 'Clientes')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- <div class="row">
        <div class="col-12">
            <a href="" class="btn btn-success mb-3">Crear Cliente</a>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Username</th>
                        <th>Correo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->name }}</td>
                            <td>{{ $cliente->username }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>
                                <form action="{{route('eliminar_cliente', $cliente->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <p>Esta página ha sido visitada <strong>{{ $count }}</strong> veces.</p>
        </div>

    </div>
@endsection
