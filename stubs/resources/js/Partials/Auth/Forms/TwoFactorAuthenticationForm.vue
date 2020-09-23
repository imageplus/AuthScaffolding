<template>
    <form-layout title="Two Factor Authentication" subtext="Add additional security to your account using two factor authentication.">
        <alert class="mb-2" v-if="$page.session.status == 'two-factor-authentication-enabled'">Two Factor Authentication Enabled</alert>

        <div v-if="twoFactorEnabled">
            <div class="mb-2" v-if="qrCode">
                <subtext class="mb-2">Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.</subtext>

                <div class="mt-4" v-html="qrCode"></div>
            </div>

            <div v-if="recoveryCodes.length > 0">
                <subtext class="mb-2">Store these recovery codes somewhere secure. If your device with 2FA on it is lost or stolen they can be used to recover access to your account.</subtext>

                <ul class="list-unstyled">
                    <li v-for="code in recoveryCodes">
                        {{ code }}
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <div v-if="!twoFactorEnabled">
                <confirms-password @confirmed="enableTwoFactorAuthentication">
                    <button class="btn btn-primary" :disabled="enabling">Enable</button>
                </confirms-password>
            </div>

            <div v-else>
                <confirms-password @confirmed="regenerateRecoveryCodes">
                    <button class="mr-3 btn btn-secondary" v-if="recoveryCodes.length > 0">
                        Regenerate Recovery Codes
                    </button>
                </confirms-password>

                <confirms-password @confirmed="showRecoveryCodes">
                    <button class="mr-3 btn btn-secondary" v-if="recoveryCodes.length == 0">
                        Show Recovery Codes
                    </button>
                </confirms-password>

                <confirms-password @confirmed="disableTwoFactorAuthentication">
                    <button class="btn btn-danger" :disabled="disabling">
                        Disable
                    </button>
                </confirms-password>
            </div>
        </div>
    </form-layout>
</template>

<script>
import ConfirmsPassword from "../ConfirmsPassword";
import FormLayout from "../Layouts/FormLayout";
import Subtext from "../Subtext";
import Alert from "../Alert";

export default {
    name: "TwoFactorAuthenticationForm",

    components: {
        Alert,
        Subtext,
        FormLayout,
        ConfirmsPassword
    },

    data() {
        return {
            enabling: false,
            disabling: false,

            qrCode: null,
            recoveryCodes: [],
        }
    },

    methods: {
        enableTwoFactorAuthentication() {
            this.enabling = true

            this.$inertia.post('/user/two-factor-authentication')
                .then(() => {
                    return Promise.all([
                        this.showQrCode(),
                        this.showRecoveryCodes()
                    ])
                }).then(() => {
                    this.enabling = false
                })
        },

        showQrCode() {
            return axios.get('/user/two-factor-qr-code')
                        .then(response => {
                            this.qrCode = response.data.svg
                        });
        },

        showRecoveryCodes() {
            return axios.get('/user/two-factor-recovery-codes')
                        .then(response => {
                            this.recoveryCodes = response.data
                        });
        },

        regenerateRecoveryCodes() {
            this.$inertia.post('/user/two-factor-recovery-codes')
                .then(response => {
                    this.showRecoveryCodes()
                })
        },

        disableTwoFactorAuthentication() {
            this.disabling = true

            this.$inertia.delete('/user/two-factor-authentication')
                .then(() => {
                    this.disabling = false
                })
        },
    },

    computed: {
        twoFactorEnabled() {
            return !this.enabling && this.$page.user.two_factor_secret != null
        }
    }
}
</script>
