<template>
    <form-layout title="Profile Information" subtext="Update your email address and name">
        <alert class="mb-2" v-if="$page.session.status == 'profile-information-updated'">Your information was successfully updated.</alert>

        <form @submit.prevent="updatePassword">
            <form-input v-model="form.name" :error="form.error('name')" id="name" placeholder="Name"></form-input>

            <form-input v-model="form.email" :error="form.error('email')" type="email" id="email" placeholder="Email Address"></form-input>

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
    name: "UserProfileForm",

    components: {
        Alert,
        FormLayout,
        AuthLayout,
        FormInput
    },

    data() {
        return {
            form: this.$inertia.form({
                name: this.$page.user.name,
                email: this.$page.user.email,
            }),
        }
    },

    methods: {
        updatePassword() {
            this.form.put('/user/profile-information');
        },
    },
}
</script>
