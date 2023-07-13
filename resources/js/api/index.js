//setup axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.baseURL = `${import.meta.env.VITE_API_URL}`
window.axios.defaults.withCredentials = true

import { useAuthStore } from "@/store/auth.store";
import { useToast } from "vue-toastification";

//set interceptors
axios.interceptors.response.use(
    //if all good continue
    (response)=> response,
    //if not
    (error) => {
        if ([401, 419].includes(error.response.status)){
            const auth = useAuthStore()
            auth.clearUserCache()

            //check if we're just refreshing the token or logging out
            let responseURL = error.request.responseURL
            if(responseURL.endsWith('/auth/refresh-token')
            || responseURL.endsWith('/auth/logout')){
                return Promise.reject(error)
                
            }

            const toast = useToast()
            toast.warning("You are unauthenticated, please login to continue.");
            return Promise.reject(error)
        }
        else{
            return Promise.reject(error)
        }
        
    }
)

// setup query builder
import { Model } from 'vue-api-query'

// inject global axios instance as http client to Model
Model.$http = axios