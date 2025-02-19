<template>
    <AppLayout title="Tienda" card-title="QUALITY STORE">
        <div class="container-fluid p-0">
            <!-- Mensajes de error -->
            <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ error }}
                <button type="button" class="btn-close" @click="error = null" aria-label="Close"></button>
            </div>

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
                            <p class="card-text">
                                Stock disponible:
                                <span :class="{'text-danger': producto.stock === 0, 'text-success': producto.stock > 0}">
                                    {{ producto.stock === 0 ? 'AGOTADO' : producto.stock }}
                                </span>
                            </p>
                            <div class="d-flex align-items-center">
                                <input type="number"
                                       v-model.number="cantidades[producto.id]"
                                       class="form-control me-2"
                                       style="width: 100px"
                                       min="1"
                                       :max="producto.stock"
                                       :placeholder="1"
                                       :disabled="producto.stock === 0"
                                       @input="validarCantidad(producto)">
                                <button class="btn btn-primary"
                                        @click="agregarAlCarrito(producto)"
                                        :disabled="producto.stock === 0 ||
                                                  (cantidades[producto.id] && !cantidadValida(producto.id))">
                                    {{ producto.stock === 0 ? 'Agotado' : 'Añadir al carrito' }}
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
        const error = ref(null)

        return {
            cantidades,
            carrito,
            error
        }
    },
    created() {
        // Inicializar las cantidades para cada producto
        this.productos.forEach(producto => {
            this.cantidades[producto.id] = 1
        })
    },
    methods: {
        handleImageError(producto) {
            producto.foto_url = null
        },
        validarCantidad(producto) {
            const cantidad = this.cantidades[producto.id]
            if (cantidad && cantidad > producto.stock) {
                this.cantidades[producto.id] = producto.stock
            }
        },
        cantidadValida(productoId) {
            const cantidad = this.cantidades[productoId]
            const producto = this.productos.find(p => p.id === productoId)
            // Permitir que la cantidad sea undefined o vacía
            return !cantidad || (cantidad > 0 && cantidad <= producto.stock)
        },
        agregarAlCarrito(producto) {
            // Si no hay cantidad especificada, usar 1
            const cantidad = parseInt(this.cantidades[producto.id]) || 1

            if (cantidad > producto.stock) {
                this.error = `Solo hay ${producto.stock} unidades disponibles de ${producto.nombre}`
                return
            }

            // Verificar si ya existe en el carrito
            const itemExistente = this.carrito.find(item => item.id === producto.id)
            if (itemExistente) {
                itemExistente.cantidad = cantidad
                itemExistente.subtotal = cantidad * (producto.precio_descuento || producto.precio)
            } else {
                const precio = producto.precio_descuento || producto.precio
                this.carrito.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    cantidad: cantidad,
                    precio: precio,
                    subtotal: cantidad * precio
                })
            }

            // Limpiar el input después de agregar al carrito
            this.cantidades[producto.id] = ''
            this.error = null
        },
        eliminarDelCarrito(item) {
            const index = this.carrito.indexOf(item)
            if (index > -1) {
                this.carrito.splice(index, 1)
            }
        },
        procesarCompra() {
            // Validar stock antes de procesar
            for (const item of this.carrito) {
                const producto = this.productos.find(p => p.id === item.id)
                if (item.cantidad > producto.stock) {
                    this.error = `No hay suficiente stock de ${item.nombre}`
                    return
                }
            }

            this.$inertia.post(route('tienda_store'), {
                productos: this.carrito
            })
        }
    }
}
</script>

<style scoped>
.card-img-top {
    margin: 0 auto;
    padding: 1rem;
}

.text-danger {
    color: #dc3545;
}

.text-success {
    color: #28a745;
}
</style>
