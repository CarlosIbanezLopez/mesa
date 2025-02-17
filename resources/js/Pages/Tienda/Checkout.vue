<template>
    <AppLayout title="Checkout" card-title="Detalles de la Compra">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Resumen de Compra</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                ¡Carrito listo para pagar!
                            </div>

                            <div class="mb-4">
                                <h6>Detalles de la Venta:</h6>
                                <p>Fecha: {{ new Date(venta.fecha).toLocaleDateString() }}</p>
                                <p>Total: ${{ venta.total }}</p>
                            </div>

                            <h6>Productos:</h6>
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
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Generar QR para Pago</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="generarQr">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" v-model="form.telefono" required>
                                </div>

                                <div class="mb-3">
                                    <label for="razon_social" class="form-label">Razón Social</label>
                                    <input type="text" class="form-control" v-model="form.razon_social" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nit" class="form-label">NIT</label>
                                    <input type="text" class="form-control" v-model="form.nit" required>
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo</label>
                                    <input type="email" class="form-control" v-model="form.correo" required>
                                </div>

                                <button type="submit" class="btn btn-primary" :disabled="procesando">
                                    Generar QR
                                </button>
                            </form>

                            <div v-if="qrImage" class="mt-4 text-center">
                                <img :src="'data:image/png;base64,' + qrImage"
                                     alt="QR Code"
                                     style="width: 200px; height: 200px;">
                                <div class="mt-3">
                                    <Link :href="route('compras_home')" class="btn btn-success">
                                        Confirmar Pago
                                    </Link>
                                </div>
                            </div>

                            <div v-if="error" class="alert alert-danger mt-3">
                                {{ error }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { ref } from 'vue'
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
    },
    setup(props) {
        const form = ref({
            telefono: '',
            razon_social: '',
            nit: '',
            correo: '',
            total: props.venta.total
        })
        const qrImage = ref(null)
        const error = ref(null)
        const procesando = ref(false)

        const generarQr = async () => {
            procesando.value = true
            error.value = null

            try {
                const response = await fetch(route('generar_qr'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(form.value)
                })

                const data = await response.json()

                if (data.success) {
                    qrImage.value = data.qrImage
                } else {
                    error.value = data.message || 'Error al generar el QR'
                }
            } catch (e) {
                error.value = 'Error al procesar la solicitud'
                console.error(e)
            } finally {
                procesando.value = false
            }
        }

        return {
            form,
            qrImage,
            error,
            procesando,
            generarQr
        }
    }
}
</script>
