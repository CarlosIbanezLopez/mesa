<template>
    <div class="wrapper">
        <Sidebar />
        <div class="main">
            <UserNav />
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">{{ title }}</h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ cardTitle }}</h5>
                                </div>
                                <div class="card-body">
                                    <slot />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <Footer />
        </div>
    </div>
</template>

<script>
import Sidebar from '@/Components/Sidebar.vue'
import UserNav from '@/Components/UserNav.vue'
import Footer from '@/Components/Footer.vue'

export default {
    components: {
        Sidebar,
        UserNav,
        Footer
    },
    props: {
        title: {
            type: String,
            required: true
        },
        cardTitle: {
            type: String,
            required: true
        }
    }
}
</script>
