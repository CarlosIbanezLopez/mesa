@extends('layouts.plantillalogin')

@section('bodystyle')
login-page
@endsection

@section('boxstyle')
login-box
@endsection

@section('content')
    <!-- Card Principal -->
    <div class="card card-outline card-primary">
        <!-- Encabezado -->
        <div class="card-header text-center">
            <a href="{{ route('login') }}" class="h1">
                <strong style="color: #007bff;">QUALITY</strong><span style="color: #28a745;"> STORE</span>
            </a>
        </div>
        <!-- Contenido -->
        <div class="card-body">
            <p class="login-box-msg"><strong>Accede a tu cuenta para continuar</strong></p>

            <!-- Formulario de Inicio de Sesión -->
            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <!-- Campo Usuario -->
                <div class="input-group mb-3">
                    <input id="username" type="text" 
                           class="form-control @error('username') is-invalid @enderror" 
                           name="username" value="{{ old('username') }}" 
                           placeholder="Nombre de usuario" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!-- Campo Contraseña -->
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
                <!-- Recordarme -->
                <div class="row mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Botón Iniciar Sesión -->
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-block btn-success">
                        <strong>Ingresar</strong> <i class="fas fa-sign-in-alt"></i>
                    </button>
                </div>
                <!-- Registro -->
                <div class="text-center">
                    <p class="mb-1">
                        <a href="{{ route('register') }}">Registrar nuevo usuario</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
