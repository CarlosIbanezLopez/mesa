<template>
    <AppLayout title="Mis Compras" card-title="Historial de Compras">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Mis Compras</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in ventas" :key="venta.id">
                                        <td>{{ new Date(venta.fecha).toLocaleDateString() }}</td>
                                        <td>${{ venta.total }}</td>
                                        <td>
                                            <Link :href="route('detalles_venta', venta.id)"
                                                  class="btn btn-info btn-sm">
                                                Ver Detalles
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
        ventas: Array
    }
}
</script>
