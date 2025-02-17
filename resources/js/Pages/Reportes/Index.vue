<template>
    <AppLayout title="Reportes" card-title="QUALITY STORE">
        <div class="container-fluid p-0">
            <h1 class="mb-4 text-center">Reportes KPI - Quality Store</h1>

            <div class="row">
                <!-- Gráfico de Productos Más Vendidos -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white text-center">
                            <h5>Productos Más Vendidos</h5>
                        </div>
                        <div class="card-body">
                            <canvas ref="barChart"></canvas>
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
                            <canvas ref="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <p>Esta página ha sido visitada <strong>{{ count }}</strong> veces.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { onMounted, ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Chart from 'chart.js/auto'

export default {
    components: {
        AppLayout
    },
    props: {
        productosMasVendidos: Array,
        ventasPorMes: Array,
        count: Number
    },
    setup(props) {
        const barChart = ref(null)
        const lineChart = ref(null)
        let barChartInstance = null
        let lineChartInstance = null

        onMounted(() => {
            // Configuración del gráfico de barras
            const barCtx = barChart.value.getContext('2d')
            barChartInstance = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: props.productosMasVendidos.map(p => p.nombre),
                    datasets: [{
                        label: 'Cantidad Vendida',
                        data: props.productosMasVendidos.map(p => p.total_vendido),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            })

            // Configuración del gráfico de líneas
            const lineCtx = lineChart.value.getContext('2d')
            lineChartInstance = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: props.ventasPorMes.map(v => `Mes ${v.mes}`),
                    datasets: [{
                        label: 'Ventas ($)',
                        data: props.ventasPorMes.map(v => v.total_ventas),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            })
        })

        return {
            barChart,
            lineChart
        }
    }
}
</script>

<style scoped>
.card-body {
    height: 400px;
    position: relative;
}
canvas {
    width: 100% !important;
    height: 100% !important;
}
</style>
