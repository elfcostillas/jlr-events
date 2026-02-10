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

    return {
        collection,
        // create,
        // update,
        // destroy
    };
});