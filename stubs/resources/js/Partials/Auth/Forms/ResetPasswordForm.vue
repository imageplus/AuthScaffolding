<template>
    <form-layout title="Reset Password" subtext="Use a long, random password for additional security">
        <alert class="mb-2" v-if="$page.session.status == 'password-updated'">Your password was successfully updated.</alert>

        <form @submit.prevent="updatePassword">
            <form-input v-model="form.current_password" :error="form.error('current_password')" ref="current_password" type="password" id="password" placeholder="Current Password"></form-input>

            <form-input v-model="form.password" :error="form.error('password')" type="password" id="new-password" placeholder="New Password"></form-input>
            <form-input v-model="form.password_confirmation" :error="form.error('password_confirmation')" type="password" id="password-confirmation" placeholder="Confirm Password"></form-input>

            <button class="btn btn-primary" type="submit" :disabled="form.isProcessing()">Save</button>
        </form>
    </form-layout>
</template>

<script>
import AuthLayout from "../Layouts/AuthLayout";
import FormInput from "../FormInput";
import FormLayout from "../Layouts/FormLayout";
import Alert from "../Alert";

export default {
    name: "ResetPasswordForm",

    components: {
        Alert,
        FormLayout,
        AuthLayout,
        FormInput
    },

    data() {
        return {
            form: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: '',
            }, {
                bag: 'updatePassword',
            }),
        }
    },

    methods: {
        updatePassword() {
            this.form.put('/user/password');
        },
    },
}
</script>
