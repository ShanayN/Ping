<template>
    <button
        :disabled="disabled"
        @click="$emit('click')"
        class="mt-2 w-full py-2 bg-violet-600 text-white font-semibold rounded-lg hover:bg-violet-700 transition"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    props: {
        disabled: {
            type: Boolean,
            default: false
        }
    }
}
</script>
