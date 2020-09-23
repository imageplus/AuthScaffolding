<template>
    <auth-layout title="Confirm Password">
        <alert class="mb-2" v-if="session.status">{{session.status}}</alert>

        <subtext class="mb-2">Please Confirm Your Password</subtext>

        <form method="POST" @submit.prevent="confirmPassword">
            <form-input v-model="form.password" :error="form.error('password')" type="password" id="password" placeholder="Enter Password"></form-input>

            <button class="btn btn-primary w-100" type="submit" :disabled="form.isProcessing()">Confirm Password</button>
        </form>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";
import Subtext from "../../Partials/Auth/Subtext";
import Alert from "../../Partials/Auth/Alert";

export default {
    name: "ConfirmPassword",

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
                password: ''
            })
        }
    },

    methods: {
        confirmPassword(){
            this.form.post('/user/confirm-password');
        }
    }
}
</script>
