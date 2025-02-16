<template>
    <AppLayout title="Productos" card-title="Promociones">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <Link :href="route('promocion_create')" class="btn btn-success mb-3">
                        Crear Promoción
                    </Link>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Lista de Promociones</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Descuento</th>
                                        <th>Fecha Final</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="promocion in promociones" :key="promocion.id">
                                        <td>{{ promocion.id }}</td>
                                        <td>{{ promocion.descuento }}%</td>
                                        <td>{{ promocion.fecha_final }}</td>
                                        <td>
                                            <Link :href="route('promocion_edit', promocion.id)"
                                                  class="btn btn-warning">
                                                Editar
                                            </Link>
                                            <button @click="eliminarPromocion(promocion.id)"
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
        promociones: Array,
        count: Number
    },
    methods: {
        eliminarPromocion(id) {
            if (confirm('¿Estás seguro de eliminar esta promoción?')) {
                this.$inertia.delete(route('promocion_delete', id))
            }
        }
    }
}
</script>
