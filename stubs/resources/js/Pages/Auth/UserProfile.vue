<template>
    <app-layout hero-title="Edit Profile">
        <user-profile-form v-if="$page.features['update-profile']"></user-profile-form>

        <hr v-if="$page.features['update-profile']" />

        <reset-password-form v-if="$page.features['change-password']"></reset-password-form>

        <hr v-if="$page.features['two-factor-auth']" />

        <two-factor-authentication-form v-if="$page.features['two-factor-auth']"></two-factor-authentication-form>

        <hr v-if="$page.features['logout-other-sessions']" />

        <user-sessions-form v-if="$page.features['logout-other-sessions']"></user-sessions-form>
    </app-layout>
</template>

<script>
import AppLayout from "../../Partials/Auth/Layouts/AppLayout";
import ResetPasswordForm from "../../Partials/Auth/Forms/ResetPasswordForm";
import TwoFactorAuthenticationForm from "../../Partials/Auth/Forms/TwoFactorAuthenticationForm";
import UserProfileForm from "../../Partials/Auth/Forms/UserProfileForm";
import Hero from "../../Partials/Auth/Hero";
import UserSessionsForm from "../../Partials/Auth/Forms/UserSessionsForm";

export default {
    name: "UserProfile",

    components: {
        UserSessionsForm,
        Hero,
        UserProfileForm,
        TwoFactorAuthenticationForm,
        ResetPasswordForm,
        AppLayout
    }
}
</script>
