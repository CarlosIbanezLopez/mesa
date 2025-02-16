<template>
    <AppLayout title="Productos" card-title="Productos">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Editar Producto</h5>
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
                                           ref="foto"
                                           @change="handleFileChange">
                                    <img v-if="producto.foto_url"
                                         :src="producto.foto_url"
                                         alt="Imagen actual"
                                         class="mt-2"
                                         style="max-width: 200px">
                                </div>
                                <button type="submit"
                                        class="btn btn-primary"
                                        :disabled="form.processing">
                                    Actualizar
                                </button>
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
        producto: Object,
        inventarios: Array,
        promociones: Array
    },
    setup(props) {
        const form = useForm({
            nombre: props.producto.nombre,
            descripcion: props.producto.descripcion,
            precio: props.producto.precio,
            inventario: props.producto.id_inventario,
            promocion: props.producto.id_promocion,
            foto: null,
            _method: 'PUT'
        })

        return { form }
    },
    methods: {
        handleFileChange(e) {
            if (e.target.files.length > 0) {
                this.form.foto = e.target.files[0]
            }
        },
        submit() {
            this.form.post(route('producto_update', this.producto.id), {
                preserveScroll: true,
                preserveState: true,
                onError: (errors) => {
                    console.error('Errores:', errors)
                },
                onSuccess: () => {
                    console.log('Actualización exitosa')
                }
            })
        }
    }
}
</script>
