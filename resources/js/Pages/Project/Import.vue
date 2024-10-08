<script>

    import MainLayout from "@/Layouts/MainLayout.vue";

    export default {
        name: 'Import',
        components: {MainLayout},
        layout: MainLayout,

        data() {
            return {
                file: null,
            }
        },

        methods: {
            selectExcell() {
                this.$refs.file.click();
            },
            setExcell(e) {
                this.file = e.target.files[0];
            },
            importExcell() {
                const formData = new FormData();
                formData.append('file', this.file);

                this.$inertia.post(this.route('projects.import.store'), formData)
            },
        }
    }

</script>

<template>
    <div>
        <h1 class="mt-3">
            Import
        </h1>
        <form action="" method="post" class="mt-3">
            <input @change="setExcell" type="file" ref="file" class="hidden">
            <button type="button"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    @click.prevent="selectExcell">Excell</button>
        </form>
        <div class="mt-3">
            <button type="button"
                    class="flex w-full justify-center rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    v-if="this.file" @click.prevent="importExcell">Import</button>
        </div>
    </div>
</template>

<style scoped>

</style>
