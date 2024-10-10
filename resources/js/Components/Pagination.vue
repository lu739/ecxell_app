<script>
    export default {
        name: 'Pagination',

        props: {
            meta: {
                type: Object
            },
            links: {
                type: Object
            }
        }
    }
</script>

<template>
    <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px text-sm">
            <li :class="{ 'opacity-50': !links.prev }">
                <a :href="links.prev"
                   class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    Previous
                </a>
            </li>
            <li v-if="links.first && meta.current_page !== 1">
                <a :href="links.first"
                   class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
            </li>

            <li class="flex items-center justify-center h-8">
                <span v-if="meta.current_page > 2" class="px-2">...</span>
                <span aria-current="page"
                   class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                >
                    {{ meta.current_page }}
                </span>
                <span v-if="meta.current_page < meta.last_page - 2" class="px-2">...</span>
            </li>

            <li v-if="links.last && meta.current_page !== meta.last_page">
                <a :href="links.last"
                   class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    {{ meta.last_page }}
                </a>
            </li>

            <li :class="{ 'opacity-50': !links.next }">
                <a :href="links.next"
                   class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    Next
                </a>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
