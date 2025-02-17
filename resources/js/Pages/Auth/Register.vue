<template>
    <Head title="Registro" />

    <div class="register-page">
        <div class="register-box">
            <div class="card card-outline card-success">
                <!-- Encabezado -->
                <div class="card-header text-center">
                    <Link :href="route('login')" class="h1">
                        <strong style="color: #007bff;">QUALITY</strong>
                        <span style="color: #28a745;"> STORE</span>
                    </Link>
                </div>

                <!-- Contenido -->
                <div class="card-body">
                    <p class="login-box-msg">
                        <strong>Registra un nuevo usuario para comenzar</strong>
                    </p>

                    <form @submit.prevent="submit">
                        <!-- Nombre -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.name }"
                                placeholder="Nombre completo"
                                required
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div v-if="form.errors.name" class="invalid-feedback">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.username"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.username }"
                                placeholder="Nombre de usuario"
                                required
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                            </div>
                            <div v-if="form.errors.username" class="invalid-feedback">
                                {{ form.errors.username }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.email }"
                                placeholder="Email"
                                required
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <div v-if="form.errors.email" class="invalid-feedback">
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.password"
                                type="password"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.password }"
                                placeholder="Contraseña"
                                required
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <div v-if="form.errors.password" class="invalid-feedback">
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="form-control"
                                placeholder="Confirmar contraseña"
                                required
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Botón Registrar -->
                        <div class="text-center mb-3">
                            <button
                                type="submit"
                                class="btn btn-block btn-success"
                                :disabled="form.processing"
                            >
                                <strong>Registrar</strong>
                                <i class="fas fa-user-plus ms-1"></i>
                            </button>
                        </div>

                        <!-- Ya tengo cuenta -->
                        <div class="text-center">
                            <Link :href="route('login')" class="text-center">
                                Ya tengo una cuenta
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

defineProps({
    errors: Object,
    auth: Object,
    flash: Object,
    userTypes: Array
})

const form = useForm({
    name: '',
    username: '',
    email: '',
    usertype_id: 2, // valor por defecto para cliente
    password: '',
    password_confirmation: ''
})

const submit = () => {
    form.post(route('register'))
}
</script>

<style scoped>
.register-page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f4f6f9;
}

.register-box {
    width: 400px;
}

.btn-block {
    width: 100%;
}

.input-group-text {
    background-color: transparent;
}
</style>
