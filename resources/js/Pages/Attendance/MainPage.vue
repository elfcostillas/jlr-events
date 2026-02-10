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
                <FilterableDataTable :title="title" :value="data" :loading="loading" :columns="columns" >

                </FilterableDataTable>
            </template>
        </AppLayout>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import AppLayout from '../AppLayout.vue';
    import FilterableDataTable from '@/Components/App/FilterableDataTable.vue';
    import { useAttendanceStore } from '@/composables/stores/attendance-store';

    const title = 'Event Attendance';
    const data = ref();
    const loading = ref(true);
    const store = useAttendanceStore();

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
    
</script>

<style lang="scss" scoped>

</style>