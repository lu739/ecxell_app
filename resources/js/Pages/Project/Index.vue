<script>
    import MainLayout from "@/Layouts/MainLayout.vue";
    import Pagination from "@/Components/Pagination.vue";

    export default {
        name: 'Index',
        components: {Pagination, MainLayout},
        layout: MainLayout,

        props: {
            projects: {
                type: Object
            },
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
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Дата создания
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Комментарий
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Эффективность
                    </th>
                </tr>
                </thead>
                <tbody v-if="projects" >
                <tr v-for="project in projects.data" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ project['id'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ project['type_id'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ project['title'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ project['date_created'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ project['comment'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ project['efficiency'] }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="relative overflow-x-auto mt-2">
            <pagination :meta="projects.meta" :links="projects.links"></pagination>
        </div>
    </div>
</template>

<style scoped>

</style>
