<template>
    <AppLayout title="Clientes" card-title="Gestión de Clientes">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-black">Lista de Clientes</h5>
                        </div>
                        <div class="card-body">
                            <div v-if="$page.props.flash.success"
                                 class="alert alert-success"
                                 role="alert">
                                {{ $page.props.flash.success }}
                            </div>

                            <div v-if="$page.props.flash.error"
                                 class="alert alert-danger"
                                 role="alert">
                                {{ $page.props.flash.error }}
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Username</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cliente in clientes" :key="cliente.id">
                                        <td>{{ cliente.name }}</td>
                                        <td>{{ cliente.username }}</td>
                                        <td>{{ cliente.email }}</td>
                                        <td>
                                            <button @click="eliminarCliente(cliente.id)"
                                                    class="btn btn-danger">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-4">
                                <p>Esta página ha sido visitada <strong>{{ count }}</strong> veces.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout
    },
    props: {
        clientes: Array,
        count: Number
    },
    methods: {
        eliminarCliente(id) {
            if (confirm('¿Estás seguro de eliminar este cliente?')) {
                this.$inertia.delete(route('eliminar_cliente', id))
            }
        }
    }
}
</script>
