<template>
    <div class="dropdown" :class="{show: open}">
        <a class="nav-link dropdown-toggle" role="button" @click="toggle">
            <slot name="title">{{title}} <span class="caret"></span></slot>
        </a>

        <div class="dropdown-menu dropdown-menu-right" :class="{'show': open, 'dropdown-open-mobile': alwaysOpenMobile}">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dropdown",

    props: {
        title: {
            type: String
        },

        alwaysOpenMobile: {
            type: Boolean,
            default: false
        }
    },

    data(){
        return {
            open: false
        }
    },

    methods: {
        toggle(){
            this.open = !this.open;
        }
    }

}
</script>
