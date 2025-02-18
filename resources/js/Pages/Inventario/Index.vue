<template>
    <AppLayout title="Productos" card-title="Inventario">
        <div class="container-fluid p-0">
            <!-- Mensajes de éxito y error -->
            <div v-if="$page.props.flash.success"
                 class="alert alert-success alert-dismissible fade show"
                 role="alert">
                {{ $page.props.flash.success }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div v-if="$page.props.flash.error"
                 class="alert alert-danger alert-dismissible fade show"
                 role="alert">
                {{ $page.props.flash.error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

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
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="inventario in inventarios" :key="inventario.id">
                                        <td>{{ inventario.id }}</td>
                                        <td>{{ inventario.stock }}</td>
                                        <td>{{ inventario.fecha_actualizacion }}</td>
                                        <td>
                                            <span :class="{'text-success': !inventario.en_uso, 'text-danger': inventario.en_uso}">
                                                {{ inventario.en_uso ? 'En uso' : 'Disponible' }}
                                            </span>
                                        </td>
                                        <td>
                                            <Link :href="route('inventario_edit', inventario.id)"
                                                  class="btn btn-warning">
                                                Editar
                                            </Link>
                                            <button v-if="!inventario.en_uso"
                                                    @click="eliminarInventario(inventario.id)"
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
                this.$inertia.delete(route('inventario_delete', id), {
                    preserveScroll: true,
                    onError: (errors) => {
                        console.error('Error al eliminar:', errors)
                    }
                })
            }
        }
    }
}
</script>
