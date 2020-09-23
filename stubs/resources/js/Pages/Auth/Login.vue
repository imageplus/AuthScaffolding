<template>
    <auth-layout title="Login">
        <errors :errors="form.errors()" class="mb-2" v-if="form.hasErrors()"></errors>

        <form @submit.prevent="login">
            <form-input v-model="form.email" :hide-error-message="true" :error="form.error('email')" type="email" id="email" placeholder="Email Address"></form-input>

            <form-input v-model="form.password" :hide-error-message="true" :error="form.error('password')" type="password" id="password" placeholder="Password"></form-input>

            <div class="form-group">
                <div class="form-check">
                    <input v-model="form.remember" class="form-check-input" type="checkbox" name="remember" id="remember">

                    <label class="form-check-label text-muted" for="remember">Remember Me</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100" :disabled="form.isProcessing()">Sign In</button>

            <div class="d-flex text-muted" v-if="$page.features.registration">
                <hr class="flex-grow-1" />

                <div class="mx-3 d-flex align-items-center">
                    <span>or</span>
                </div>

                <hr class="flex-grow-1" />
            </div>

            <inertia-link class="btn btn-secondary w-100" href="/register" v-if="$page.features.registration">Register</inertia-link>

            <div class="text-center mt-2" v-if="$page.features['reset-password']">
                <inertia-link class="text-muted" href="/forgot-password">Forgot your password?</inertia-link>
            </div>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";
import Errors from "../../Partials/Auth/Errors";

export default {
    name: "Login",

    components: {
        Errors,
        FormInput,
        AuthLayout
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        login() {
            this.form.post('/login');
        },
    },
}
</script>
