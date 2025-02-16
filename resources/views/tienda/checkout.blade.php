@extends('layouts.plantillabase')

@section('title', 'Checkout')
@section('h-title', 'Resumen de Compra')
@section('card-title', 'Confirmar Compra')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h3>Detalles de la Venta</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        {{-- <th>Precio</th> --}}
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            {{-- <td>${{ number_format($detalle->precio, 2) }}</td> --}}
                            <td>${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <h3>Total de la Compra</h3>
            <p><strong>Total: ${{ number_format($venta->total, 2) }}</strong></p>

            <!-- Contenedor del QR y Spinner -->
            <div id="qr-container" style="margin-top: 20px; text-align: center;">
                <!-- Spinner visible cuando se active -->
                <div id="loading-spinner" class="spinner" style="display: none;">
                    <p>Cargando...</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h3>Confirmación</h3>
            <form id="form-generar-qr" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>

                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razón Social</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                </div>

                <div class="mb-3">
                    <label for="nit" class="form-label">NIT</label>
                    <input type="text" class="form-control" id="nit" name="nit" required>
                </div>

                <div class="mb-3">
                    <label for="total" class="form-label">Total</label>
                    <input type="number" class="form-control" id="total" name="total" value="{{ $venta->total }}"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>

                <button type="button" class="btn btn-primary" onclick="generarQr()">Generar QR</button>
            </form>
        </div>
    </div>

    <script>
        function generarQr() {
            const form = document.getElementById('form-generar-qr');
            const formData = new FormData(form);

            // Muestra el spinner antes de hacer la solicitud
            const spinner = document.getElementById('loading-spinner');
            spinner.style.display = 'block'; // Asegúrate de que el spinner sea visible

            const qrContainer = document.getElementById('qr-container');
            qrContainer.innerHTML = ''; // Limpiar el contenedor antes de mostrar el QR

            console.log("Generando QR...");

            // Inicia el fetch para generar el QR
            fetch('{{ route('generar_qr') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta recibida:", data);
                    // Oculta el spinner tan pronto como se reciba la respuesta
                    spinner.style.display = 'none';

                    if (data.success) {
                        qrContainer.innerHTML = `
                        <h4>Código QR</h4>
                        <img src="data:image/png;base64,${data.qrImage}" alt="QR Code" style="width: 250px; height: 250px;">
                        <a href="{{route('compras_home')}}" class="btn btn-primary">Confirmado</a>
                    `;
                    } else {
                        qrContainer.innerHTML = `
                        <div class="alert alert-danger">${data.message}</div>
                    `;
                    }
                })
                .catch(error => {
                    console.log("Error al generar el QR:", error);
                    // Oculta el spinner en caso de error
                    spinner.style.display = 'none';
                    qrContainer.innerHTML = `
                    <div class="alert alert-danger">Error al generar el QR.</div>
                `;
                });
        }
    </script>

    <style>
        /* Estilo para el spinner (CSS puro) */
        .spinner {
            border: 4px solid #f3f3f3;
            /* Gris claro */
            border-top: 4px solid #3498db;
            /* Azul */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1.5s linear infinite;
            /* Animación de giro */
        }

        /* Animación para el spinner */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
