<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">QUALITY STORE</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-item" :class="{ active: $page.url === '/' }">
                    <Link class="sidebar-link" :href="route('home')">
                        <i class="align-middle" data-feather="home"></i>
                        <span class="align-middle">Home</span>
                    </Link>
                </li>



                <li class="sidebar-item" :class="{ active: route().current('tienda_home') }">
                    <Link class="sidebar-link" :href="route('tienda_home')">
                        <i class="fa fa-house"></i>
                        <span class="align-middle">Tienda</span>
                    </Link>
                </li>

                <li class="sidebar-item">
                    <Link class="sidebar-link" :href="route('compras_home')">
                        <i class="fa fa-user"></i>
                        <span class="align-middle">Mis compras</span>
                    </Link>
                </li>

                <template v-if="$page.props.auth.user && $page.props.auth.user.usertype_id === 1">
                    <li class="sidebar-header">
                        Backoffice
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#form-plugins" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="fa-solid fa-file-lines"></i>
                            <span class="align-middle">Productos</span>
                        </a>
                        <ul id="form-plugins" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <Link class="sidebar-link" :href="route('producto_home')">Productos</Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link" :href="route('promocion_home')">Promocion</Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link" :href="route('inventario_home')">Inventario</Link>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a data-bs-target="#datatables" data-bs-toggle="collapse" class="sidebar-link collapsed">
                            <i class="fa-solid fa-table-list"></i>
                            <span class="align-middle">Reportes y Usuarios</span>
                        </a>
                        <ul id="datatables" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <Link class="sidebar-link" :href="route('clientes_home')">Gestion de usuarios</Link>
                            </li>
                            <li class="sidebar-item">
                                <Link class="sidebar-link" :href="route('reporte_home')">Estadisticas</Link>
                            </li>
                        </ul>
                    </li>
                </template>
            </ul>
        </div>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link
    },
    mounted() {
        // Inicializar feather icons
        if (typeof feather !== 'undefined') {
            feather.replace()
        }
    }
}
</script>
