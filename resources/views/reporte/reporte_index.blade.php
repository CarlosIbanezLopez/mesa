@extends('layouts.plantillabase')

@section('title', 'Home')
@section('h-title', 'Reporte')
@section('card-title', 'QUALITY STORE')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <h1 class="mb-4 text-center">Reportes KPI - Quality Store</h1>

        <div class="row">
            <!-- Gráfico de Productos Más Vendidos -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>Productos Más Vendidos</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productosMasVendidos"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Ventas por Mes -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h5>Ventas por Mes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ventasPorMes"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <p>Esta página ha sido visitada <strong>{{ $count }}</strong> veces.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos proporcionados por el controlador
        const productos = @json($productosMasVendidos);
        const ventas = @json($ventasPorMes);

        // Gráfico de Productos Más Vendidos
        const productosCtx = document.getElementById('productosMasVendidos').getContext('2d');
        new Chart(productosCtx, {
            type: 'bar',
            data: {
                labels: productos.map(p => p.nombre),
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: productos.map(p => p.total_vendido),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Productos Más Vendidos'
                    }
                }
            }
        });

        // Gráfico de Ventas por Mes
        const ventasCtx = document.getElementById('ventasPorMes').getContext('2d');
        new Chart(ventasCtx, {
            type: 'line',
            data: {
                labels: ventas.map(v => `Mes ${v.mes}`),
                datasets: [{
                    label: 'Ventas ($)',
                    data: ventas.map(v => v.total_ventas),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Ventas por Mes'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Ventas ($)'
                        }
                    }
                }
            }
        });
    </script>
@endsection
