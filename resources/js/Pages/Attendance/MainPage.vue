<template>
    <div>
        <AppLayout>
            <!-- <template v-slot:title > Attendance  </template> -->
            <template v-slot:header >
                <Message class="my-2 w-32rem" severity="success">
                    
                    <b>Ongoing Event : </b>{{ events.event_name }} <br>
                    <b>Event Location : </b>{{ events.event_location }}
                </Message>
            </template>
            <template v-slot:table>
                <FilterableDataTable :title="title" :value="data" :loading="loading" :columns="columns" @participate="participate" @withdraw="withdraw" @fetchData="fetchData">
                </FilterableDataTable>
                <ConfirmDialog></ConfirmDialog>
            </template>
        </AppLayout>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import AppLayout from '../AppLayout.vue';
    import FilterableDataTable from '@/Components/App/FilterableDataTable.vue';
    import { useAttendanceStore } from '@/composables/stores/attendance-store';
    import { useConfirm } from "primevue/useconfirm";
    import { useToast } from 'primevue';

    const title = 'Event Attendance';
    const data = ref();
    const loading = ref(true);
    const store = useAttendanceStore();
    const confirm = useConfirm();
    const toast = useToast();

    const props = defineProps([
        'events'
    ]); 

    const columns = ref([ 
        { field : 'biometric_id', header : 'Bio ID' },
        { field : 'employee_name', header : 'Employee Name' },
        { field : 'job_title_name', header : 'Position' },
        { field : 'div_code', header : 'Division' },
        { field : 'dept_name', header : 'Department' },
        { field : 'att_status_code', header : 'Status', type : 'status' },
        { 
            field : 'actions',
            header : 'Actions',
            type : 'actions',
            buttons : ['edit']
        }
       
       
    ]);

    onMounted(async() => {
        fetchData();
    });



    const fetchData = async () => {
        let  list  = await store.collection();
        // console.log(list.value);
        data.value = list.value;
        loading.value = false;
    };

    const participate = async (data) => {
        console.log(data);
        // let resp = await store.create(data);
        // fetchData();
        
        confirm.require({
            message: 'Are you sure you want to proceed?',
            header: 'Confirmation',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Join Event'
            },
            accept: async () => {
                let resp = await store.create(data);
                // console.log(resp);
                toast.add(resp);
                fetchData();
            },
            reject: () => {
                // toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
            }
        });

        console.log(confirm);

    };

    const withdraw = async (data) => {
        // let resp = await store.destroy(data);
        // fetchData();
        confirm.require({
            message: 'Are you sure you want to proceed?',
            header: 'Confirmation',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Cancel Attendance'
            },
            accept: async () => {
                let resp = await store.destroy(data);
                // console.log(resp);
                toast.add(resp);
                fetchData();

            },
            reject: () => {
                // toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
            }
        });
    };

    
</script>

<style lang="scss" scoped>

</style>