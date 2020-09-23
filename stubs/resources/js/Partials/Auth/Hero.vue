<template>
    <div class="shadow-sm bg-white">
        <div class="container py-4 d-flex justify-content-between">
            <h1 class="text-title mr-2 mb-0">{{title}}</h1>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "Hero",

    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>
