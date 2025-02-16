<template>
    <AppLayout title="Productos" card-title="Inventario">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Inventario</h5>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="mb-3 col-2">
                                    <label for="stock" class="form-label">Stock</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="stock"
                                        v-model="form.stock"
                                        required
                                    />
                                </div>
                                <div class="mb-3 col-2">
                                    <label for="fecha_actualizacion" class="form-label">
                                        Fecha Actualización
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="fecha_actualizacion"
                                        v-model="form.fecha_actualizacion"
                                        readonly
                                    />
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Crear
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
import { useForm } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout
    },
    setup() {
        const form = useForm({
            stock: "",
            fecha_actualizacion: new Date().toISOString().split("T")[0],
        });

        return { form };
    },
    computed: {
        currentDate() {
            return new Date().toISOString().split("T")[0];
        },
    },
    methods: {
        submit() {
            this.form.post(route("inventario_store"));
        },
    },
};
</script>
