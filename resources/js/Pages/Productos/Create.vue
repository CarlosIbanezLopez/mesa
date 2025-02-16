<template>
    <AppLayout title="Productos" card-title="Productos">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Crear Producto</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="mb-3 col-4">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text"
                                           class="form-control"
                                           id="nombre"
                                           v-model="form.nombre"
                                           required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control"
                                              id="descripcion"
                                              v-model="form.descripcion"
                                              required></textarea>
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number"
                                           class="form-control"
                                           id="precio"
                                           v-model="form.precio"
                                           required
                                           step="0.01">
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="inventario" class="form-label">Inventario</label>
                                    <select class="form-control"
                                            id="inventario"
                                            v-model="form.inventario"
                                            required>
                                        <option value="">Seleccione</option>
                                        <option v-for="inventario in inventarios"
                                                :key="inventario.id"
                                                :value="inventario.id">
                                            {{ inventario.stock }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="promocion" class="form-label">Promoción</label>
                                    <select class="form-control"
                                            id="promocion"
                                            v-model="form.promocion"
                                            required>
                                        <option value="">Seleccione</option>
                                        <option v-for="promocion in promociones"
                                                :key="promocion.id"
                                                :value="promocion.id">
                                            {{ promocion.descuento }}%
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file"
                                           class="form-control"
                                           id="foto"
                                           @input="form.foto = $event.target.files[0]">
                                </div>
                                <button type="submit" class="btn btn-primary">Crear</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout
    },
    props: {
        inventarios: Array,
        promociones: Array
    },
    setup() {
        const form = useForm({
            nombre: '',
            descripcion: '',
            precio: '',
            inventario: '',
            promocion: '',
            foto: null
        })

        return { form }
    },
    methods: {
        submit() {
            this.form.post(route('producto_store'), {
                preserveScroll: true,
                onSuccess: () => {
                    // Opcional: Mostrar mensaje de éxito
                }
            })
        }
    }
}
</script>
