@extends('layouts.plantillalogin')

@section('bodystyle')
register-page
@endsection

@section('boxstyle')
register-box
@endsection

@section('content')
<div class="card card-outline card-success">
    <!-- Encabezado -->
    <div class="card-header text-center">
        <a href="{{ route('login') }}" class="h1">
            <strong style="color: #007bff;">QUALITY</strong><span style="color: #28a745;"> STORE</span>
        </a>
    </div>
    <!-- Contenido -->
    <div class="card-body">
        <p class="login-box-msg"><strong>Registra un nuevo usuario para comenzar</strong></p>

        <!-- Formulario de Registro -->
        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            <!-- Nombre -->
            <div class="input-group mb-3">
                <input id="name" type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       name="name" value="{{ old('name') }}" 
                       placeholder="Nombre completo" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Nombre de Usuario -->
            <div class="input-group mb-3">
                <input id="username" type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       name="username" value="{{ old('username') }}" 
                       placeholder="Nombre de usuario" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-user-tag"></i>
                    </div>
                </div>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Tipo de Usuario -->
            <div class="input-group mb-3">
                <select id="usertype_id" class="form-control @error('usertype_id') is-invalid @enderror" 
                        name="usertype_id" required>
                    <option value="">Seleccione el tipo de usuario</option>
                    @foreach($usertype as $usert)
                        @if($usert->id == 2)
                            <option value="{{ $usert->id }}" 
                                    @if(old('usertype_id') == $usert->id) selected @endif>
                                {{ $usert->type }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                @error('usertype_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div class="input-group mb-3">
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" 
                       placeholder="Correo electrónico" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="input-group mb-3">
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" placeholder="Contraseña" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="input-group mb-3">
                <input id="password-confirm" type="password" 
                       class="form-control" name="password_confirmation" 
                       placeholder="Confirmar contraseña" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
            </div>

            <!-- Botón Registrar -->
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-block btn-success">
                    <strong>Registrar</strong> <i class="fas fa-user-plus"></i>
                </button>
            </div>
        </form>

        <!-- Ya Registrado -->
        <div class="text-center mt-2">
            <a href="{{ route('login') }}" class="btn btn-link">
                Ya tengo usuario registrado
            </a>
        </div>
    </div>
</div>
@endsection
