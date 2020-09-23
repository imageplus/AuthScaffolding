<template>
    <auth-layout title="Reset Password">
        <alert class="mb-2" v-if="session.status">Your password was successfully updated.</alert>

        <form @submit.prevent="updatePassword">
            <form-input v-model="form.email" :error="form.error('email')" type="email" id="email" placeholder="Email Address"></form-input>

            <form-input v-model="form.password" :error="form.error('password')" type="password" id="new-password" placeholder="New Password"></form-input>
            <form-input v-model="form.password_confirmation" :error="form.error('password_confirmation')" type="password" id="confirm-password" placeholder="Confirm Password"></form-input>

            <button class="btn btn-primary w-100" type="submit" :disabled="form.isProcessing()">Save</button>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";
import Alert from "../../Partials/Auth/Alert";

export default {
    name: "ResetPassword",

    components: {
        Alert,
        AuthLayout,
        FormInput
    },

    props: {
        session: {
            type: Object
        },

        token: {
            type: String
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: '',
                password: '',
                password_confirmation: '',
            }),
        }
    },

    methods: {
        updatePassword() {
            this.form.post('/reset-password');
        },
    },
}
</script>
