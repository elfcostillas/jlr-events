import { defineStore } from "pinia";
import { getFn, postFn } from "../transmit";
import { ref } from "vue";


export const useEventStore = defineStore('event', () => {
    const list = ref(null);
    const resp = ref(null);

    const collection = async() => {
        try {
            const collection = await getFn('events/list',null);
            list.value = collection;

        }catch(error){

        }

        return list.value;
    };
 
    const create = async (params) => {
        try {
            const response = await postFn('events/create', params);

            console.log('SUCCESS', response);

            return {
                severity: 'success',
                summary: 'Success',
                detail: response.data.message ?? 'Event created.',
                life: 3000,
            };

        } catch (error) {
            console.log('ERROR STATUS:', error.response?.status);
            console.log('ERROR DATA:', error.response?.data);

            let error_msg = '';

            if (error.response?.status === 422) {
                Object.values(error.response.data.errors).forEach(err => {
                    error_msg += err[0] + ' ';
                });
            }

            return {
                severity: 'error',
                summary: error.response?.data?.message ?? 'Validation Error',
                detail: error_msg.trim(),
                life: 3000,
            };
        } finally {
            console.log('mwuhehehehe');
        }

    };

    const update = async (params) => {
        /*
        try {
            const { data } = await postFn('events/update',params);
            resp.value = data;
        }catch(error){

        }

        return resp.value;
        */
       try {
            const response = await postFn('events/update', params);

            console.log('SUCCESS', response);

            return {
                severity: 'success',
                summary: 'Success',
                detail: response.data.message ?? 'Event updated.',
                life: 3000,
            };

        } catch (error) {
            console.log('ERROR STATUS:', error.response?.status);
            console.log('ERROR DATA:', error.response?.data);

            let error_msg = '';

            if (error.response?.status === 422) {
                Object.values(error.response.data.errors).forEach(err => {
                    error_msg += err[0] + ' ';
                });
            }

            return {
                severity: 'error',
                summary: error.response?.data?.message ?? 'Validation Error',
                detail: error_msg.trim(),
                life: 3000,
            };
        } finally {
            console.log('mwuhehehehe');
        }
    };

    const destroy = async (params) => {
        try {
            const { data } = await postFn('events/destroy',params);
            resp.value = data;
        }catch(error){

        }

        return resp.value;
    };

    return {
        collection,
        create,
        update,
        destroy
    };
}); 