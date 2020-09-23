<template>
    <app-layout :hide-container="true" :hide-header="true" :hide-footer="true">
        <div class="vh-100 vw-100 d-flex flex-column justify-content-center align-items-center">
            <logo class="mb-2" v-if="showLogo" />

            <div class="card shadow-sm border-0 auth-card">
                <div class="card-body">
                    <h1 class="auth-card--title card-title text-center">{{title}}</h1>

                    <slot></slot>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "./AppLayout";
import Logo from "../Logo";

export default {
    name: "AuthLayout",

    components: {
        Logo,
        AppLayout
    },

    props: {
        title: {
            type: String,
            required: true
        },

        showLogo: {
            type: Boolean,
            default: true
        }
    }
}
</script>
