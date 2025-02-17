<template>
    <Head title="Login" />

    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <!-- Encabezado -->
                <div class="card-header text-center">
                    <Link :href="route('login')" class="h1">
                        <strong style="color: #007bff;">QUALITY</strong>
                        <span style="color: #28a745;"> STORE</span>
                    </Link>
                </div>
                <!-- Contenido -->
                <div class="card-body">
                    <p class="login-box-msg"><strong>Accede a tu cuenta para continuar</strong></p>

                    <form @submit.prevent="submit">
                        <!-- Campo Usuario -->
                        <div class="input-group mb-3">
                            <input
                                v-model="form.username"
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.username }"
                                placeholder="Nombre de usuario"
                                required
                                autofocus
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div v-if="form.errors.username" class="invalid-feedback">
                                {{ form.errors.username }}
                            </div>
                        </div>

                        <!-- Campo Contraseña -->
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

                        <!-- Recordarme -->
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input
                                        v-model="form.remember"
                                        type="checkbox"
                                        id="remember"
                                    >
                                    <label for="remember">Recordarme</label>
                                </div>
                            </div>
                        </div>

                        <!-- Botón Iniciar Sesión -->
                        <div class="text-center mb-3">
                            <button
                                type="submit"
                                class="btn btn-block btn-success"
                                :disabled="form.processing"
                            >
                                <strong>Ingresar</strong>
                                <i class="fas fa-sign-in-alt ms-1"></i>
                            </button>
                        </div>

                        <!-- Registro -->
                        <div class="text-center">
                            <p class="mb-1">
                                <Link :href="route('register')">
                                    Registrar nuevo usuario
                                </Link>
                            </p>
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
    flash: Object
})

const form = useForm({
    username: '',
    password: '',
    remember: false
})

const submit = () => {
    form.post(route('login'))
}
</script>

<style>
.login-page {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f4f6f9;
}

.login-box {
    width: 400px;
}

.btn-block {
    width: 100%;
}

.input-group-text {
    background-color: transparent;
}
</style>
