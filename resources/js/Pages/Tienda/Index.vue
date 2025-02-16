<template>
    <AppLayout title="Tienda" card-title="QUALITY STORE">
        <div class="container-fluid p-0">
            <div class="row">
                <div v-for="producto in productos" :key="producto.id" class="col-md-4">
                    <div class="card mb-4">
                        <img v-if="producto.foto_url"
                             :src="producto.foto_url"
                             :alt="producto.nombre"
                             class="card-img-top"
                             style="width: 250px; height: 250px; object-fit: cover"
                             @error="handleImageError(producto)">
                        <div class="card-body">
                            <h5 class="card-title">{{ producto.nombre }}</h5>
                            <p class="card-text">{{ producto.descripcion }}</p>
                            <p class="card-text">Precio: ${{ producto.precio }}</p>
                            <template v-if="producto.descuento">
                                <p class="card-text">Descuento: {{ producto.descuento }}%</p>
                                <p class="card-text">Precio con descuento: ${{ producto.precio_descuento }}</p>
                            </template>
                            <div class="d-flex align-items-center">
                                <input type="number"
                                       v-model="cantidades[producto.id]"
                                       class="form-control me-2"
                                       style="width: 100px"
                                       min="1"
                                       max="100">
                                <button class="btn btn-primary"
                                        @click="agregarAlCarrito(producto)">
                                    Añadir al carrito
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form @submit.prevent="procesarCompra" v-if="carrito.length > 0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in carrito" :key="item.id">
                            <td>{{ item.nombre }}</td>
                            <td>{{ item.cantidad }}</td>
                            <td>${{ item.precio }}</td>
                            <td>${{ item.subtotal }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-danger"
                                        @click="eliminarDelCarrito(item)">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>

            <div class="mt-4">
                <p>Esta página ha sido visitada <strong>{{ count }}</strong> veces.</p>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout
    },
    props: {
        productos: Array,
        count: Number
    },
    setup() {
        const cantidades = ref({})
        const carrito = ref([])

        return {
            cantidades,
            carrito
        }
    },
    methods: {
        handleImageError(producto) {
            producto.foto_url = null
        },
        agregarAlCarrito(producto) {
            const cantidad = this.cantidades[producto.id] || 1
            const precio = producto.precio_descuento || producto.precio
            const subtotal = cantidad * precio

            const itemExistente = this.carrito.find(item => item.id === producto.id)
            if (itemExistente) {
                itemExistente.cantidad = cantidad
                itemExistente.subtotal = subtotal
            } else {
                this.carrito.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    cantidad: cantidad,
                    precio: precio,
                    subtotal: subtotal
                })
            }
        },
        eliminarDelCarrito(item) {
            const index = this.carrito.indexOf(item)
            if (index > -1) {
                this.carrito.splice(index, 1)
            }
        },
        procesarCompra() {
            this.$inertia.post(route('tienda_store'), {
                productos: this.carrito
            })
        }
    }
}
</script>
