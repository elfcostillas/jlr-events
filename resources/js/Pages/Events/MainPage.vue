<template>
    <div>
        <AppLayout>
            <template v-slot:title > Events </template>

            <template v-slot:table>
                <DataTable :value="data" :loading="loading" :columns="columns" @edit="edit" />
            </template>
            <template v-slot:dialog >
                <Dialog v-model:visible="isVisible" modal header="Event Details" :style="{ width: '32rem' }">
                   
                    <div class="grid">
                        <div class="col-6 ">
                            <label for="first_name" class="block mb-2 font-medium">First Name</label>
                            <InputText id="first_name" class="w-full" />
                        </div>
                        <div class="col-6 ">
                            <label for="last_name" class="block mb-2 font-medium">Last Name</label>
                            <InputText id="last_name" class="w-full" />
                        </div>

                        <div class="col-12 md:col-6">
                            <label for="email" class="block mb-2 font-medium">Email</label>
                            <InputText id="email" class="w-full" />
                        </div>
                        <div class="col-12 md:col-6">
                            <label for="phone" class="block mb-2 font-medium">Phone</label>
                            <InputText id="phone" class="w-full" />
                        </div>
                    </div>
                </Dialog>
            </template>
            
        </AppLayout>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import AppLayout from '../AppLayout.vue';
    import DataTable from '@/Components/App/DataTable.vue';

    import { useEventStore } from '@/composables/stores/event-store';

    import { onMounted } from 'vue';
    
    const data = ref();
    const loading = ref(true);
    const store = useEventStore();
    const isVisible = ref(true);
    const columns = ref([
        { field : 'id', header : 'ID' },
        { field : 'event_date', header : 'Date', type : 'date' },
        { field : 'event_name', header : 'Event Name' },
        { field : 'event_location', header : 'Location' },
        {
            field : 'actions',
            header : 'Actions',
            type : 'actions',
            buttons : ['edit']
        }
    ]);

    const edit = (data) => {
        console.log(data);
    };

    onMounted(async () => {
        fetchData();
    });

    const fetchData = async () => {
        let  list  = await store.collection();
        // console.log(list.value);
        data.value = list.value;
        loading.value = false;
    };


</script>

<style lang="scss" scoped>

</style>