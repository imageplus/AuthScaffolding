<template>
    <div class="form-label-group">
        <input :value="value" @input="inputChange" :type="type" :id="id" :class="[inputClass, {'is-invalid': error}]" :placeholder="placeholder">
        <label :for="id">
            {{placeholder}}
        </label>

        <div class="invalid-feedback" v-if="error && !hideErrorMessage">{{error}}</div>
    </div>
</template>

<script>
export default {
    name: "FormInput",

    props: {
        value: {
            type: String
        },

        id: {
            type: String,
            default: Math.random().toString(36).substring(7)
        },

        inputClass: {
            type: String,
            default: 'form-control'
        },

        name: {
            type: String
        },

        placeholder: {
            type: String
        },

        type: {
            type: String,
            default: 'text'
        },

        error: {
            type: String
        },

        hideErrorMessage: {
            type: Boolean,
            default: false
        }

    },

    methods: {
        inputChange(e){
            this.$emit('input', e.target.value);
        }
    }
}
</script>
