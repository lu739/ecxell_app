<script>
    import MainLayout from "@/Layouts/MainLayout.vue";
    import Pagination from "@/Components/Pagination.vue";

    export default {
        name: 'Index',
        components: {Pagination, MainLayout},
        layout: MainLayout,

        props: {
            tasks: {
                type: Object
            }
        }
    }
</script>

<template>
    <div class="mt-4 w-2/3 mx-auto">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3">
                        File
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ошибки при импорте
                    </th>
                </tr>
                </thead>
                <tbody v-if="tasks" >
                    <tr v-for="task in tasks.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{ task['id'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ task['user_id'] }}
                        </td>
                        <td class="px-6 py-4">
                            <a download :href="task['file_path']" target="_blank">
                                {{ task['file_title'] }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            {{ task['status'] }}
                        </td>
                        <td class="px-6 py-4">
                            <a v-if="task['failedRows']"
                               :href="task['failedRows']">Нажмите для просмотра</a>
                            <span v-else>Нет</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="relative overflow-x-auto mt-2">
            <pagination :meta="tasks.meta" :links="tasks.links"></pagination>
        </div>
    </div>
</template>

<style scoped>

</style>
