

<template>
    <div style="margin: 1rem auto;width : 80%">
        <DataTable :value="props.value" :loading="loading" >
            <template #header> 
                <Button 
                    severity="primary" raised
                    icon="pi pi-plus" 
                    label="Create"  
                    class="p-button-sm"
                    @click="$emit('create',null)">
                    
                </Button>
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
                            v-if="col.buttons?.includes('edit')"
                            severity="secondary" raised
                            icon="pi pi-pencil"
                            label="Edit"
                            class="p-button-sm"
                            @click="$emit('edit', data)"
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

    const props = defineProps([
        'value',
        'loading',
        'columns'
    ]);

    const formatDate = (date) => {
        if (!date) return '-'
        return new Date(date).toLocaleDateString('en-PH', {
            year: 'numeric',
            month: 'long',
            day: '2-digit',
        })
    }

    const getSeverity = (status) => {
        switch (status.toLowerCase()) {
            case 'ongoing':
                    return 'success';  
                case 'concluded':
                    return 'secondary';  
                case 'upcoming':
                    return 'warn';   
                default:
                    return 'info';   
        }
    };
</script>

<style lang="scss" scoped>

</style>