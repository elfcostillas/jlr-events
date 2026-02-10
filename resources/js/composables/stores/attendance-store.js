import { defineStore } from "pinia";
import { getFn, postFn } from "../transmit";
import { ref } from "vue";

export const useAttendanceStore = defineStore('attendace', () => {
    const list = ref(null);
    const resp = ref(null);

    const collection = async() => {
        try {
            const collection = await getFn('attendance/list',null);
            list.value = collection;

        }catch(error){

        }

        return list.value;
    };

    const create = async (params) => {
        try {
            const response = await postFn('attendance/create', params);

            return {
                severity: 'success',
                summary: 'Success',
                detail: response.data.message ?? 'Attendance created.',
                life: 3000,
                group: 'br',
            };

        }catch(error){
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
        }finally{
            console.log('mwuhehehehe');
        }
    };

    const update = async (params) => {
        try {
            const response = await postFn('attendance/update', params);

            return {
                severity: 'success',
                summary: 'Success',
                detail: response.data.message ?? 'Attendance withdrawn.',
                life: 3000,
                group: 'br'
            };

        }catch(error){
             let error_msg = '';

            if (error.response?.status === 422) {
                Object.values(error.response.data.errors).forEach(err => {
                    error_msg += err[0] + ' ';
                });
            }

            return {
                severity: 'success',
                summary: error.response?.data?.message ?? 'Validation Error',
                detail: error_msg.trim(),
                life: 3000,
              
            };
        }finally{
            console.log('mwuhehehehe');
        }
    };

    const destroy = async (params) => {
        try {
            const response = await postFn('attendance/destroy', params);

            return {
                severity: 'warn',
                summary: 'Warning',
                detail: response.data.message ?? 'Attendance withdrawn successfully.',
                life: 3000,
                group: 'br'
            };

        }catch(error){
             let error_msg = '';

            if (error.response?.status === 422) {
                Object.values(error.response.data.errors).forEach(err => {
                    error_msg += err[0] + ' ';
                });
            }

            return {
                severity: 'sucess',
                summary: error.response?.data?.message ?? 'Validation Error',
                detail: error_msg.trim(),
                life: 3000,
                
            };
        }finally{
            console.log('mwuhehehehe');
        }
    };



    return {
        collection,
        create,
        update,
        destroy
    };
});