import api from "./api";
import { ref } from "vue";

export const getFn = async (url,params) => {
    const collection = ref(null );
    const status = ref(null );
    const message = ref(null );
    const count = ref(null );

    try {
        const { data } = await api.get(url);
        // console.log(data);
        // console.log(data); // object { data : xxx, total : xxx } 
        // console.log(data.data);
        collection.value = data.data;
    }catch(error){
        collection.value = null;
    };

    return collection;
};

export const postFn = async (url,params) => {
    return await api.post(url,params);

};
/*
  const collection = ref(null );
    const status = ref(null );
    const message = ref(null );
    const count = ref(null );

    try {
        const { data } = await api.post(url,params);
        // console.log(data);
        // console.log(data); // object { data : xxx, total : xxx } 
        // console.log(data.data);
        collection.value = data.data;
    }catch(error){
        console.log(error);
        // return {
        //     status : 'error',
        //     message

        // };
    };

    return collection;

*/