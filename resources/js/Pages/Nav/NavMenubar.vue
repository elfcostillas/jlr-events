<template>
    <div style="">      
        <Menubar :model="items">
            <!-- <template #item="{ item, props, hasSubmenu }">
                <router-link v-if="item.route" v-slot="{ href, navigate }" :to="item.route" custom>
                    <a v-ripple :href="href" v-bind="props.action" @click="navigate">
                        <span :class="item.icon" />
                        <span>{{ item.label }}</span>
                    </a>
                </router-link>
                <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                    <span :class="item.icon" />
                    <span>{{ item.label }}</span>
                    <span v-if="hasSubmenu" class="pi pi-fw pi-angle-down" />
                </a>
            </template> -->
            <template #end>
                <Button
                    text
                    icon="pi pi-user"
                    :label="user.name"
                    severity="contrast"
                    @click="toggle"
                />
                <Menu ref="menu" :model="userMenu" popup />
            </template>
        </Menubar>
    </div>
</template>

<script setup>

import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const menu = ref();

const page = usePage();
const user = page.props.auth.user;

const toggle = (event) => {
    menu.value.toggle(event);
};

const logout = () => {
    router.post(route('logout'));
};

const items = ref([
    {
        label : 'Events',
        icon : 'pi pi-calendar',
        // route : '/events'
        command : () => {
            router.visit('/events');
        }
    },
    {
        label : 'Attendance',
        icon : 'pi pi-user',
        // route : '/attendance'
        command : () => {
            router.visit('/attendance');
        }
    }
]);

const userMenu = [{
    label : 'Logout',
    icon : 'pi pi-sign-out',
    command: logout,
}];

/*
const userMenu = [
    {
        label : user.name,
        icon : 'pi pi-user',
        items : [
            {
                label: 'Logout',
                icon: 'pi pi-sign-out',
                command: logout,
            },
        ]
    }
];
*/

</script>

<style lang="scss" scoped>

</style>