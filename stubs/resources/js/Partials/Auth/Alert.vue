<template>
    <div class="alert" :class="`alert-${type}`">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "Alert",

    props: {
        type: {
            type: String,
            default: 'success'
        }
    }
}
</script>
