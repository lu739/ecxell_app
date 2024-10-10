<script>
    import MainLayout from "@/Layouts/MainLayout.vue";
    import {Link} from "@inertiajs/vue3";
    import ApplicationLogo from "@/Components/ApplicationLogo.vue";
    import Pagination from "@/Components/Pagination.vue";

    export default {
        name: 'FailedRows',
        components: {Pagination, ApplicationLogo, Link, MainLayout},
        layout: MainLayout,

        props: {
            failedRows: {
                type: Object
            }
        }
    }
</script>

<template>
    <div class="mt-4 w-2/3 mx-auto">
        <div class="my-3">
            <Link
                class="px-3 py-2 rounded-md text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                :href="route('tasks.index')">Вернуться в список тасков</Link>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Task
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Key
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Message
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created
                    </th>
                </tr>
                </thead>
                <tbody v-if="failedRows" >
                    <tr v-for="row in failedRows.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{ row['id'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ row['task_id'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ row['key'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ row['message'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ row['created_at'] }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="relative overflow-x-auto mt-2">
            <pagination :meta="failedRows.meta" :links="failedRows.links"></pagination>
        </div>
    </div>
</template>

<style scoped>

</style>
