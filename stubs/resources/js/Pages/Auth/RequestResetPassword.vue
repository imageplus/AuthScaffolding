<template>
    <auth-layout title="Forgot Password">
        <alert class="mb-2" v-if="session.status">{{session.status}}</alert>

        <subtext class="mb-2">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</subtext>

        <form method="POST" @submit.prevent="requestPasswordReset">
            <form-input v-model="form.email" :error="form.error('email')" type="email" id="email" placeholder="Email Address"></form-input>

            <button class="btn btn-danger w-100" type="submit" :disabled="form.isProcessing()">Request Password Reset</button>

            <div class="d-flex text-muted">
                <hr class="flex-grow-1" />

                <div class="mx-3 d-flex align-items-center">
                    <span>or</span>
                </div>

                <hr class="flex-grow-1" />
            </div>

            <inertia-link class="btn btn-secondary w-100" href="/login">Sign In</inertia-link>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";
import Subtext from "../../Partials/Auth/Subtext";
import Alert from "../../Partials/Auth/Alert";

export default {
    name: "RequestResetPassword",

    components: {
        Alert,
        Subtext,
        FormInput,
        AuthLayout
    },

    props: {
        session: {
            type: Object
        }
    },

    data(){
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        requestPasswordReset(){
            this.form.post('/forgot-password');
        }
    }
}
</script>
