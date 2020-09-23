<template>
    <app-layout>

    </app-layout>
</template>

<script>
import AppLayout from "../Partials/Auth/Layouts/AppLayout";

export default {
    name: "Dashboard",

    components: {
        AppLayout
    },

    methods: {
        logout(){
            this.$inertia.post('/logout')
        }
    }
}
</script>
