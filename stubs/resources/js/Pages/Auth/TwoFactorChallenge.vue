<template>
    <auth-layout title="Two Factor Authentication">
        <div>
            <subtext class="mb-2" v-show="!recovery">Please confirm access to your account by entering the authentication code provided by your authenticator application.</subtext>

            <subtext class="mb-2" v-show="recovery">Please confirm access to your account by entering one of your emergency recovery codes.</subtext>

            <errors :errors="$page.errors" class="mb-2" v-if="$page.errors"></errors>

            <form @submit.prevent="verifyTwoFactorAuthentication">

                <div class="mt-4" v-show="!recovery">
                    <form-input v-model="form.code" id="code" name="code" placeholder="Enter Code"></form-input>
                </div>

                <div class="mt-4" v-show="recovery">
                    <form-input v-model="form.recovery_code" id="recovery_code" name="recovery_code" placeholder="Enter Recovery Code"></form-input>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="btn btn-secondary" type="button" v-show="!recovery" @click="recovery = true">Use a recovery code</button>

                    <button class="btn btn-secondary" type="button" v-show="recovery" @click="recovery = false">Use an authentication code</button>

                    <button class="btn btn-primary" type="submit">Verify</button>
                </div>
            </form>
        </div>
    </auth-layout>
</template>

<script>
import AuthLayout from "../../Partials/Auth/Layouts/AuthLayout";
import FormInput from "../../Partials/Auth/FormInput";
import Subtext from "../../Partials/Auth/Subtext";
import Errors from "../../Partials/Auth/Errors";

export default {
    name: "TwoFactorChallenge",

    components: {
        Errors,
        Subtext,
        FormInput,
        AuthLayout
    },

    data(){
        return {
            recovery: false,

            form: this.$inertia.form({
                code: '',
                recovery_code: ''
            })
        }
    },

    methods: {
        verifyTwoFactorAuthentication(){
            if(this.recovery) {
                this.form.code = '';
            } else {
                this.form.recovery_code = '';
            }

            this.form.post('/two-factor-challenge');
        }
    }
}
</script>
