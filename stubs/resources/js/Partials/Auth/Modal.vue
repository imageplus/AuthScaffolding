<template>
    <div class="modal fade" :class="{'show': show, 'd-block': show}" tabindex="-1" @click="close($event, true)">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" @click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="content"></slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Modal',

    props: {
        title: {
            type: String,
            required: true
        },

        show: {
            type: Boolean,
            default: false
        },

        closeable: {
            type: Boolean,
            default: true
        },
    },

    methods: {
        close(e, checkElement = false) {
            if(checkElement && e && !e.target.classList.contains('modal')){
                return;
            }

            if (this.closeable) {
                this.$emit('close')
            }
        }
    },

    watch: {
        show: {
            immediate: true,
            handler: (show) => {
                if (show) {
                    document.body.style.overflow = 'hidden'
                } else {
                    document.body.style.overflow = null
                }
            }
        }
    },

    created() {
        const closeOnEscape = (e) => {
            if (e.key === 'Escape' && this.show) {
                this.close()
            }
        }

        document.addEventListener('keydown', closeOnEscape)

        this.$once('hook:destroyed', () => {
            document.removeEventListener('keydown', closeOnEscape)
        })
    },
}
</script>
