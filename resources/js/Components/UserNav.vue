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
            </ul>
        </div>
    </nav>
</template>

<script>
import DarkModeToggle from './DarkModeToggle.vue'

export default {
    name: 'UserNav',
    components: {
        DarkModeToggle
    },
    data() {
        return {
            selectedOption: 'tienda'
        }
    },
    methods: {
        handleSearch() {
            this.$inertia.visit(`/${this.selectedOption}`)
        }
    }
}
</script>
