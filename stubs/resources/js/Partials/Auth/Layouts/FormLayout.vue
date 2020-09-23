<template>
    <div class="form-layout row my-3">
        <div class="form-layout--label col-12 col-md-5">
            <h3 class="form-layout--title">{{title}}</h3>

            <subtext v-if="subtext != null">{{subtext}}</subtext>
        </div>

        <div class="form-layout--content col-12 col-md-7">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Subtext from "../Subtext";
export default {
    name: "FormLayout",
    components: {Subtext},
    props: {
        title: {
            type: String,
            required: true
        },

        subtext: {
            type: String,
            required: false,
            default: null
        }
    }
}
</script>
