<template>
    <AppLayout title="Productos" card-title="Inventario">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <Link :href="route('inventario_create')" class="btn btn-success mb-3">
                        Crear Inventario
                    </Link>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Lista de Inventario</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Stock</th>
                                        <th>Fecha Actualización</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="inventario in inventarios" :key="inventario.id">
                                        <td>{{ inventario.id }}</td>
                                        <td>{{ inventario.stock }}</td>
                                        <td>{{ inventario.fecha_actualizacion }}</td>
                                        <td>
                                            <Link :href="route('inventario_edit', inventario.id)"
                                                  class="btn btn-warning">
                                                Editar
                                            </Link>
                                            <button @click="eliminarInventario(inventario.id)"
                                                    class="btn btn-danger ms-2">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p>Esta página ha sido visitada <strong>{{ count }}</strong> veces.</p>
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
        inventarios: Array,
        count: Number
    },
    methods: {
        eliminarInventario(id) {
            if (confirm('¿Estás seguro de eliminar este inventario?')) {
                this.$inertia.delete(route('inventario_delete', id))
            }
        }
    }
}
</script>
