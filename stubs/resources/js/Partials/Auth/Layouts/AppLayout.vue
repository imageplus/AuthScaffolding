<template>
    <div class="app">
        <header v-if="!hideHeader">
            <navbar></navbar>
        </header>

        <main>
            <hero v-if="heroTitle !== null" :title="heroTitle">
                <slot name="hero"></slot>
            </hero>

            <div :class="{container: !hideContainer}">
                <slot></slot>
            </div>
        </main>

        <footer v-if="!hideFooter">

        </footer>
    </div>
</template>

<script>
import Navbar from "../Navbar";
import Hero from "../Hero";
export default {
    name: "AppLayout",

    components: {
        Hero,
        Navbar
    },

    props: {
        hideContainer: {
            type: Boolean,
            default: false
        },

        hideHeader: {
            type: Boolean,
            default: false
        },

        hideFooter: {
            type: Boolean,
            default: false
        },

        heroTitle: {
            type: String,
            default: null
        }
    }
}
</script>
