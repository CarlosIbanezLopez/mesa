<template>
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <!-- Buscador -->
                <li class="nav-item me-3">
                    <form id="search-form" @submit.prevent="handleSearch">
                        <div class="input-group">
                            <select v-model="selectedOption" class="form-select" style="width: auto;">
                                <option value="tienda">Tienda</option>
                                <option value="producto">Productos</option>
                                <option value="promocion">Promociones</option>
                                <option value="inventario">Inventario</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Ir</button>
                        </div>
                    </form>
                </li>

                <!-- Dark Mode Toggle -->
                <li class="nav-item">
                    <DarkModeToggle />
                </li>

                <!-- Dropdown de Usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                        <i class="align-middle" data-feather="settings"></i>
                    </a>

                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                        <i class="align-middle me-1" data-feather="user"></i>
                        <span class="text-dark">{{ $page.props.auth.user.name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                            <i class="align-middle me-1" data-feather="user"></i> Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <Link
                            class="dropdown-item text-danger"
                            :href="route('logout')"
                            method="post"
                            as="button"
                            preserve-scroll
                        >
                            <i class="align-middle me-1" data-feather="log-out"></i>
                            Cerrar Sesión
                        </Link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import DarkModeToggle from './DarkModeToggle.vue'
import { Link } from '@inertiajs/vue3'

export default {
    name: 'UserNav',
    components: {
        DarkModeToggle,
        Link
    },
    data() {
        return {
            selectedOption: 'tienda'
        }
    },
    methods: {
        handleSearch() {
            this.$inertia.visit(`/inf513/grupo16sa/proyecto2/public/${this.selectedOption}`)
        }
    },
    mounted() {
        // Inicializar feather icons
        if (typeof feather !== 'undefined') {
            feather.replace()
        }
    }
}
</script>

<style scoped>
.dropdown-item {
    cursor: pointer;
}

.dropdown-item.text-danger:hover {
    background-color: #dc354522;
}

/* Estilo para el botón de logout cuando está dentro de un dropdown-item */
.dropdown-item[type="button"] {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 0.25rem 1rem;
}
</style>
