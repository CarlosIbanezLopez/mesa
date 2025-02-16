<template>
    <AppLayout title="Productos" card-title="Promociones">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Editar Promoción</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="mb-3 col-2">
                                    <label for="descuento" class="form-label">Descuento</label>
                                    <input type="number"
                                           class="form-control"
                                           id="descuento"
                                           v-model="form.descuento"
                                           max="100"
                                           required>
                                    <div v-if="form.errors.descuento" class="invalid-feedback">
                                        El descuento no puede ser mayor a 100
                                    </div>
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="fecha_final" class="form-label">Fecha Final</label>
                                    <input type="date"
                                           class="form-control"
                                           id="fecha_final"
                                           v-model="form.fecha_final"
                                           :min="currentDate"
                                           required>
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
        promocion: Object
    },
    setup(props) {
        const form = useForm({
            descuento: props.promocion.descuento,
            fecha_final: props.promocion.fecha_final
        })

        return { form }
    },
    computed: {
        currentDate() {
            return new Date().toISOString().split('T')[0]
        }
    },
    methods: {
        submit() {
            this.form.put(route('promocion_update', this.promocion.id))
        }
    }
}
</script>
