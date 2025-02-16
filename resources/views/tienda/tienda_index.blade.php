@extends('layouts.plantillabase')

@section('title', 'Home')
@section('h-title', 'Tienda')
@section('card-title', 'QUALITY STORE')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        @foreach ($productos as $producto)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $producto->foto) }}" class="card-img-top" alt="{{ $producto->nombre }}"
                        style="width: 250px; height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <p class="card-text">Precio: ${{ $producto->precio }}</p>
                        @foreach ($promociones as $promocion)
                            @if ($promocion->id == $producto->id_promocion)
                                <p class="card-text">Descuento: {{ $promocion->descuento }}%</p>
                                <p class="card-text">Precio con descuento:
                                    ${{ $producto->precio - $producto->precio * ($promocion->descuento / 100) }}</p>
                                @php
                                    $precioConDescuento =
                                        $producto->precio - $producto->precio * ($promocion->descuento / 100);
                                @endphp
                            @endif
                        @endforeach
                        <input type="number" id="cantidad-{{ $producto->id }}" name="cantidad" min="1"
                            max="100" value="1">
                        <button type="button" class="btn btn-primary"
                            onclick="agregarAlCarrito('{{ $producto->id }}', '{{ $producto->nombre }}', {{ $precioConDescuento }}, document.getElementById('cantidad-{{ $producto->id }}').value)">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <form action="{{ route('tienda_store') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-carrito">
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Checkout</button>
        </form>

        <script>
            function agregarAlCarrito(productoId, nombre, precio, cantidad) {
                const tbody = document.getElementById('tbody-carrito');

                // Buscar si el producto ya existe en el carrito
                const filaExistente = document.querySelector(`tr[data-id="${productoId}"]`);

                if (filaExistente) {
                    // // Actualizar cantidad y subtotal
                    // const cantidadCell = filaExistente.querySelector('.cantidad');
                    // const subtotalCell = filaExistente.querySelector('.subtotal');
                    // const nuevaCantidad = parseInt(cantidadCell.textContent) + parseInt(cantidad);

                    // cantidadCell.textContent = nuevaCantidad;
                    // subtotalCell.textContent = (nuevaCantidad * precio).toFixed(2);

                    // // Actualizar inputs ocultos
                    // filaExistente.querySelector('.input-cantidad').value = nuevaCantidad;
                    // filaExistente.querySelector('.input-subtotal').value = nuevaCantidad * precio;
                } else {
                    // Crear una nueva fila para el producto
                    const fila = document.createElement('tr');
                    fila.setAttribute('data-id', productoId);
                    fila.innerHTML = `
                        <td>
                            ${nombre}
                            <input type="hidden" name="productos[${productoId}][id]" value="${productoId}">
                            <input type="hidden" name="productos[${productoId}][nombre]" value="${nombre}">
                        </td>
                        <td class="cantidad">
                            ${cantidad}
                            <input type="hidden" name="productos[${productoId}][cantidad]" value="${cantidad}">
                        </td>
                        <td>
                            ${precio.toFixed(2)}
                            <input type="hidden" name="productos[${productoId}][precio]" value="${precio}">
                        </td>
                        <td class="subtotal">
                            ${(cantidad * precio).toFixed(2)}
                            <input type="hidden" name="productos[${productoId}][subtotal]" value="${(cantidad * precio).toFixed(2)}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="eliminarDelCarrito(this)">Eliminar</button>
                        </td>
                    `;
                    tbody.appendChild(fila);
                }
            }

            function eliminarDelCarrito(button) {
                const fila = button.closest('tr');
                fila.remove();
            }
        </script>
        <div class="mt-4">
            <p>Esta página ha sido visitada <strong>{{ $count }}</strong> veces.</p>
        </div>
    </div>
@endsection
