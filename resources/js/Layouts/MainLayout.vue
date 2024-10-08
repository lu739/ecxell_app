<script setup>

import Navigation from "@/Components/Navigation.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-300">

        <navigation/>

        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <slot />
        </div>
    </div>
</template>

<style scoped>

</style>
