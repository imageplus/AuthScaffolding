<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <logo />
            </a>
            <button class="navbar-toggler" type="button" @click="toggle">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-md-block" :class="{show: open, 'd-block': open}">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <inertia-link class="nav-link" href="/dashboard">Dashboard</inertia-link>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item" v-if="!$page.user">
                        <inertia-link href="/login" class="nav-link">Login</inertia-link>
                    </li>
                    <li class="nav-item" v-if="!$page.user">
                        <inertia-link href="/register" class="nav-link" v-if="$page.features.registration">Register</inertia-link>
                    </li>

                    <li class="nav-item" v-else>
                        <dropdown :title="$page.user.name" :always-open-mobile="true">
                            <inertia-link class="dropdown-item" href="/user/profile" v-if="$page.features['manage-profile']">Profile</inertia-link>
                            <button class="dropdown-item" @click="logout">Logout</button>
                        </dropdown>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import Dropdown from "./Dropdown";
    import Logo from "./Logo";
    export default {
        name: "Navbar",

        components: {
            Logo,
            Dropdown
        },

        data(){
            return {
                open: false
            }
        },

        methods: {
            toggle(){
                this.open = !this.open;
            },

            logout(){
                this.$inertia.post('/logout');
            }
        }
    }
</script>
