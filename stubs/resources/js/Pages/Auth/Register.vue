<template>
    <auth-layout title="Register">
        <form @submit.prevent="register">
            <form-input v-model="form.name" :error="form.error('name')" type="text" id="name" placeholder="Username"></form-input>

            <form-input v-model="form.email" :error="form.error('email')" type="email" id="email" placeholder="Email Address"></form-input>

            <form-input v-model="form.password" :error="form.error('password')" type="password" id="password" placeholder="Password"></form-input>

            <form-input v-model="form.password_confirmation" :error="form.error('password_confirmation')" type="password" id="password_confirmation" placeholder="Confirm Password"></form-input>

            <button type="submit" class="btn btn-primary w-100" :disabled="form.isProcessing()">Register</button>

            <div class="d-flex text-muted">
                <hr class="flex-grow-1" />

                <div class="mx-3 d-flex align-items-center">
                    <span>or</span>
                </div>

                <hr class="flex-grow-1" />
            </div>

            <inertia-link class="btn btn-secondary w-100" href="/login">Sign In</inertia-link>

            <div class="text-center mt-2" v-if="$page.features['reset-password']">
                <inertia-link class="text-muted" href="/forgot-password">Forgot your password?</inertia-link>
            </div>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";

export default {
    name: "Register",

    components: {
        FormInput,
        AuthLayout
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }
    },

    methods: {
        register() {
            this.form.post('/register');
        },
    }
}
</script>
