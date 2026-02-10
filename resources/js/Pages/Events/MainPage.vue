<template>
    <div>
        <AppLayout>
            <template v-slot:title > Events </template>

            <template v-slot:table>
                <DataTable :value="data" :loading="loading" :columns="columns" @edit="edit" @create="create" />
            </template>
            <template v-slot:dialog >
                <Dialog v-model:visible="isVisible" modal header="Event Details" :style="{ width: '32rem' }">
                   
                    <div class="grid">
                        <div class="col-12 ">
                            <label for="event_date" class="block mb-2 font-medium">Date</label>
                            <DatePicker v-model="form.event_date" showIcon  id="event_date" class="w-full" />
                        </div>
                        <div class="col-12 ">
                            <label for="event_name" class="block mb-2 font-medium">Event Name</label>
                            <InputText v-model="form.event_name" id="event_name" class="w-full" />
                        </div>

                        <div class="col-12">
                            <label for="event_location" class="block mb-2 font-medium">Location</label>
                            <InputText v-model="form.event_location" id="event_location" class="w-full" />
                        </div>
                        
                        <div class="col-6 flex justify-content-center">
                            <Button class="w-10rem" icon="pi pi-save" v-model:disabled="isDisabled" label="Save"  @click="save"></Button>
                        </div>
                        <div class="col-6 flex justify-content-center">
                            <Button class="w-10rem" severity="danger" icon="pi pi-times-circle" label="Cancel" @click="cancel"></Button>
                        </div>
                    </div>
                </Dialog>
            </template>
            
        </AppLayout>
    </div>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import AppLayout from '../AppLayout.vue';
    import DataTable from '@/Components/App/DataTable.vue';

    import { useEventStore } from '@/composables/stores/event-store';

    import { onMounted } from 'vue';
    import { useToast } from 'primevue';
    
    const toast = useToast();
    const data = ref();
    const loading = ref(true);
    const store = useEventStore();

    const isVisible = ref(false);
    const isDisabled = ref(false);

    const columns = ref([
        { field : 'id', header : 'ID' },
        { field : 'event_date', header : 'Date', type : 'date' },
        { field : 'event_name', header : 'Event Name' },
        { field : 'event_location', header : 'Location' },
        { field : 'event_status', header : 'Status', type :'status' },
        {
            field : 'actions',
            header : 'Actions',
            type : 'actions',
            buttons : ['edit']
        }
    ]);

    const convertDate = () => {
        form.value.event_date =  form.value.event_date.toISOString().split('T')[0];
    };

    const create = async () => {
        form_reset();  
        await showDialog();
        
    };

    const edit = async (data) => {
        form_reset();
        await toggleDialog();

        form.value = {
            id : data.id,
            event_name : data.event_name,
            event_location : data.event_location,
            event_date : new Date(data.event_date),
        };

    };

    const showDialog = () => {
        isVisible.value = true;
    }

    const toggleDialog = () => {
        isVisible.value = !isVisible.value;
    }

    const save = async () => {
        delay();
        let resp;
        
        if(form.value.id == null || form.value.id == undefined){
            resp = await store.create(form.value);
        }else{
            resp = await store.update(form.value);
        }

        if(resp.severity == 'success'){
            fetchData();
        }

        toast.add(resp);

    };

    const cancel = async () => {
        await toggleDialog();
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

    const delay = () => {
        isDisabled.value = true;
        setTimeout(()=>{
            isDisabled.value = false;
        },3000);
    }

    const form = ref({
        id : null,
        event_name : null,
        event_location : null,
        event_date : null,
    });

    const form_reset = () => {
        form.value = {
            id : null,
            event_name : null,
            event_location : null,
            event_date : null,
        };
    }


</script>

<style lang="scss" scoped>

</style>