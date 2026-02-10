<template>
    <div style="margin:4px;">
        <NavMenubar/>
        <!-- <h3 class="text-xl font-semibold ml-2 mt-1 mb-4"> 
            <slot name="title" /> 
        </h3> -->

        <slot name="table" />
        <slot name="dialog" />

        <Toast />
    </div>
</template>

<script setup>
    import NavMenubar from './Nav/NavMenubar.vue';
</script>

<style lang="scss" scoped>

</style>