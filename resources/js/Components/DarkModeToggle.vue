<template>
    <button
        id="toggle-dark-mode"
        @click="toggleDarkMode"
        class="nav-link"
    >
        {{ buttonText }}
    </button>
</template>

<script>
export default {
    name: 'DarkModeToggle',
    data() {
        return {
            isDarkMode: false
        }
    },
    computed: {
        buttonText() {
            return this.isDarkMode ? 'Modo Claro' : 'Modo Oscuro'
        }
    },
    mounted() {
        // Verifica si el usuario ya tiene una preferencia guardada
        const darkMode = localStorage.getItem('darkMode')
        if (darkMode === 'enabled') {
            document.body.classList.add('dark-mode')
            this.isDarkMode = true
        }
    },
    methods: {
        toggleDarkMode() {
            document.body.classList.toggle('dark-mode')
            this.isDarkMode = !this.isDarkMode

            // Guarda la preferencia en el almacenamiento local
            localStorage.setItem('darkMode', this.isDarkMode ? 'enabled' : 'disabled')
        }
    }
}
</script>
