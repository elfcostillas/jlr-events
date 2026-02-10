

<template>
    <div style="margin: 1rem auto;width : 80%">
        <DataTable v-model:filters="filters" paginator :rows="12" paginatorTemplate="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
                currentPageReportTemplate="{first} to {last} of {totalRecords}" :value="props.value" :loading="loading" :globalFilterFields="['employee_name', 'div_code', 'dept_name', 'job_title_name']" >

            <template #header>
                <Toolbar>
                    <template #start>
                        <IconField>
                            <InputIcon class="p-inputicon pi pi-search" />
                            <InputText v-model="filters['global'].value" class=" w-80" placeholder="Employee Search" />
                        </IconField>
                        <Button icon="pi pi-filter-slash" severity="secondary" @click="filters['global'].value=''" class="ml-2"> </Button>
                       
                    </template>
                    <template #center>
                        <Button icon="pi pi-sync" severity="contrast" @click="$emit('fetchData')"  class="ml-2"> </Button>
                    </template>
                    <template #end>
                        <Button icon="pi pi-print" label="Print" ></Button>
                    </template>
                </Toolbar>
                
            </template>
            <Column v-for="col of columns" :key="col.field" :field="col.field" :header="col.header">
                <template #body="{ data }">
                    <!-- Date column -->
                    <span v-if="col.type === 'date'">
                        {{ formatDate(data[col.field]) }}
                    </span>
                    <span v-else-if="col.type === 'status'">
                        <Tag :severity="getSeverity(data[col.field])"> {{ data[col.field] }} </Tag>
                    </span>
                    <span v-else-if="col.type === 'actions'">
                        <Button
                            v-if="data.att_status==3"
                            severity="danger" raised
                            icon="pi pi-sign-out"
                            label="Withdraw"
                            class="p-button-sm"
                            @click="$emit('withdraw', data)"
                        />
                        <Button v-else
                            severity="success" raised
                            icon="pi pi-file-check"
                            label="Participate"
                            class="p-button-sm"
                            @click="$emit('participate', data)"
                        />
                        
                    </span>
                    <span v-else>
                        {{ data[col.field] }}
                    </span>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { FilterMatchMode, FilterOperator } from '@primevue/core/api';

    const props = defineProps([
        'value',
        'loading',
        'columns',
        'title'
    ]);
    const filters = ref(
        {
            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            // name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
            // 'country.name': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
            // representative: { value: null, matchMode: FilterMatchMode.IN },
            // status: { operator: FilterOperator.OR, constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }] }
        }
    );

    const formatDate = (date) => {
        if (!date) return '-'
        return new Date(date).toLocaleDateString('en-PH', {
            year: 'numeric',
            month: 'long',
            day: '2-digit',
        })
    }

    const getSeverity = (status) => {
        if (!status || typeof status !== 'string') {
            return '';
        }

        switch (status.toLowerCase().trim()) {
            case 'present':
                    return 'success';  
            case 'absent':
                    return 'warn';   
            default:
                return '';   
        }
    };
</script>

<style lang="scss" scoped>

</style>