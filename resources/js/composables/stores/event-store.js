import { defineStore } from "pinia";
import { getFn } from "../transmit";
import { ref } from "vue";


export const useEventStore = defineStore('event', () => {
    const list = ref(null);

    const collection = async() => {
        try {
            const collection = await getFn('events/list',null);

            // console.log(collection);
            // console.log(data.value); // null
            // console.log(data.data); unefined
            list.value = collection;

        }catch(error){

        }

        return list.value;
    };

    return {
        collection
    };
}); 