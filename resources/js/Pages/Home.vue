<template>
    <AppLayout :title="title" :card-title="cardTitle">
        <div v-if="$page.props.flash.status" class="alert alert-success" role="alert">
            {{ $page.props.flash.status }}
        </div>

        {{ welcomeMessage }}

        <div class="mt-4">
            <p>Esta página ha sido visitada <strong>{{ count }}</strong> veces.</p>
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
        count: Number
    },
    data() {
        return {
            title: 'Bienvenido',
            cardTitle: 'QUALITY STORE'
        }
    },
    computed: {
        welcomeMessage() {
            return `Bienvenido, ${this.$page.props.auth.user.name}`
        }
    }
}
</script>
