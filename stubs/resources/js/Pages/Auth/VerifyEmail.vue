<template>
    <auth-layout title="Verify Email">
        <alert class="mb-2" v-if="session.status === 'verification-link-sent'">A new verification link has been sent to the email address you provided during registration.</alert>

        <subtext class="mb-2">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</subtext>

        <form method="POST" @submit.prevent="verify">
            <button class="btn btn-primary" type="submit" :disabled="form.isProcessing()">Resend Verification Email</button>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import Subtext from "../../Partials/Auth/Subtext";
import Alert from "../../Partials/Auth/Alert";

export default {
    name: "VerifyEmail",

    components: {
        Alert,
        Subtext,
        AuthLayout
    },

    props: {
        session: {
            type: Object
        }
    },

    data(){
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        verify(){
            this.form.post('/email/verification-notification');
        }
    }
}
</script>
