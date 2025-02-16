<template>
    <AppLayout title="Productos" card-title="Productos">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <Link :href="route('producto_create')" class="btn btn-success mb-3">
                        Crear Producto
                    </Link>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Lista de Productos</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in productos" :key="producto.id">
                                        <td>{{ producto.id }}</td>
                                        <td>{{ producto.nombre }}</td>
                                        <td>{{ producto.descripcion }}</td>
                                        <td>{{ producto.precio }}</td>
                                        <td>{{ producto.stock }}</td>
                                        <td>
                                            <img v-if="producto.foto_url"
                                                 :src="producto.foto_url"
                                                 alt="Imagen del producto"
                                                 width="50"
                                                 height="50"
                                                 @error="handleImageError(producto)"
                                                 class="product-image">
                                            <span v-else>Sin imagen</span>
                                        </td>
                                        <td>
                                            <Link :href="route('producto_edit', producto.id)"
                                                  class="btn btn-warning">
                                                Editar
                                            </Link>
                                            <button @click="eliminarProducto(producto.id)"
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
        productos: Array,
        count: Number
    },
    methods: {
        handleImageError(producto) {
            producto.foto_url = null;
        },
        eliminarProducto(id) {
            if (confirm('¿Estás seguro de eliminar este producto?')) {
                this.$inertia.delete(route('producto_delete', id))
            }
        }
    }
}
</script>

<style>
.product-image {
    object-fit: cover;
    border-radius: 4px;
}
</style>
