<template>
    <AppLayout title="Detalle de Venta" card-title="Detalle de Compra">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Detalle de la Compra</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6>Información de la Venta:</h6>
                                <p>Fecha: {{ new Date(venta.fecha).toLocaleDateString() }}</p>
                                <p>Total: ${{ venta.total }}</p>
                            </div>

                            <h6>Productos Comprados:</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detalle in detalles" :key="detalle.id">
                                        <td>{{ detalle.nombre }}</td>
                                        <td>{{ detalle.cantidad }}</td>
                                        <td>${{ detalle.precio }}</td>
                                        <td>${{ detalle.subtotal }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <Link :href="route('compras_home')" class="btn btn-primary">
                                    Volver a Mis Compras
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        Link,
        AppLayout
    },
    props: {
        venta: Object,
        detalles: Array
    }
}
</script>
