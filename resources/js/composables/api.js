import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const api  = axios.create({
    // baseURL : 'http://172.17.56.65/support-group-api/'    
    baseURL : '/jlr-event-att/public/api'
});

export default api;
/*
import { router } from "@inertiajs/vue3";

export const getFn = async (url,params) => {
    const baseUrl = 'api';
    /*
    return router.get(baseUrl + '/' + url,{

    },{
        onSuccess : (page) => {
            console.log(page)
        },onError : (errors) => {
            console.log(errors)
        }
    })
 
};
*/