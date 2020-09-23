<template>
    <div class="text-sm text-danger">
        <ul class="list-unstyled">
            <li class="text-center" v-for="error in errors">{{typeof error == 'string' ? error : error[0]}}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Errors",

    props: {
        errors: {
            type: Object,
            required: true
        }
    }
}
</script>
