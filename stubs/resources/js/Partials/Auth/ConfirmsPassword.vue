<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot></slot>
        </span>

        <modal :show="confirmingPassword" @close="confirmingPassword = false" :title="title">
            <template #content>
                {{ content }}

                <div class="mt-4">
                    <form-input type="password" :error="form.error" placeholder="Password" id="confirm-password" v-model="form.password"  @keyup.enter.native="confirmPassword"></form-input>
                </div>
            </template>

            <template #footer>
                <button class="btn btn-secondary" @click="confirmingPassword = false">
                    Cancel
                </button>

                <button class="ml-2 btn btn-primary" @click="confirmPassword" :disabled="form.isProcessing()">
                    {{ button }}
                </button>
            </template>
        </modal>
    </span>
</template>

<script>
import FormInput from "./FormInput";
import Modal from "./Modal";

export default {
    name: 'ConfirmsPassword',

    components: {
        Modal,
        FormInput
    },

    props: {
        title: {
            type: String,
            default: 'Confirm Password'
        },

        content: {
            type: String,
            default: 'For your security, please confirm your password to continue.'
        },

        button: {
            type: String,
            default: 'Confirm'
        },

        mustInputPassword: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            confirmingPassword: false,

            form: this.$inertia.form({
                password: '',
                error: '',
            }, {
                bag: 'confirmPassword',
            })
        }
    },

    methods: {
        startConfirmingPassword() {
            this.form.error = '';

            if(this.mustInputPassword){
                this.confirmingPassword = true;
                this.form.password = '';
                return;
            }

            axios.get('/user/confirmed-password-status').then(response => {
                if (response.data.confirmed) {
                    this.$emit('confirmed');
                } else {
                    this.confirmingPassword = true;
                    this.form.password = '';
                }
            })
        },

        confirmPassword() {
            this.form.processing = true;

            //this needs to be axios as otherwise this would redirect
            axios.post('/user/confirm-password', {
                password: this.form.password,
            }).then(response => {
                this.confirmingPassword = false;
                this.form.error = '';
                this.form.processing = false;

                this.$nextTick(() => {
                    this.$emit('input', this.form.password);
                    this.$emit('confirmed');

                    this.form.password = '';
                });
            }).catch(error => {
                this.form.processing = false;
                this.form.error = error.response.data.errors.password[0];
            });
        }
    }
}
</script>
