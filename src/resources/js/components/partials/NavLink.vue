<template>
    <a :href="href" class="flex items-center px-4 py-2 font-bold text-lg text-gray-700 hover:bg-gray-100 hover:text-violet-500">
        <slot name="icon"></slot>
        <span class="ml-2">{{ text }}</span>
    </a>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            required: true
        },
        text: {
            type: String,
            required: true
        }
    }
};
</script>
