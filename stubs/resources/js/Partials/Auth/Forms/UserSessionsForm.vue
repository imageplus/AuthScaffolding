<template>
    <form-layout title="Browser Sessions" subtext="Manage all other active sessions">
        <subtext class="mb-2">
            If necessary, you may logout of all of your other browser sessions across all of your devices. If you feel your account has been compromised, you should also update your password.
        </subtext>

        <!-- Other Browser Sessions -->
        <div class="my-3" v-if="$page.sessions.length > 0">
            <div class="d-flex align-items-center mb-1" :class="{'font-weight-bold' : session.current_device}" v-for="session in $page.sessions">
                <div class="mr-2">
                    {{ session.agent.platform }} - {{ session.agent.browser }}
                </div>

                <div class="mr-2">{{ session.ip_address }}</div>

                <subtext v-if="!session.current_device">Last active {{ session.last_active }}</subtext>
                <subtext v-else>This Device</subtext>
            </div>
        </div>

        <confirms-password @confirmed="logoutOtherBrowserSessions" @input="form.password = $event" :must-input-password="true" button="Logout Other Sessions">
            <button class="mr-3 btn btn-danger" :disabled="form.isProcessing()">
                Logout Other Sessions
            </button>
        </confirms-password>
    </form-layout>
</template>

<script>
import FormLayout from "../Layouts/FormLayout";
import Subtext from "../Subtext";
import ConfirmsPassword from "../ConfirmsPassword";

export default {
    name: "UserSessionsForm",

    components: {
        ConfirmsPassword,
        Subtext,
        FormLayout,
    },

    data() {
        return {
            confirmingLogout: false,

            form: this.$inertia.form({
                '_method': 'DELETE',
                password: '',
            }, {
                bag: 'logoutOtherBrowserSessions'
            })
        }
    },

    methods: {
        logoutOtherBrowserSessions() {
            this.form.post('/user/other-sessions')
                .then(response => {
                    if (!this.form.hasErrors()) {
                        this.confirmingLogout = false
                    }
                })
        },
    }
}
</script>
