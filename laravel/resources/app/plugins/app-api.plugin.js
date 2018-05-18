import axios from 'axios';
import router from 'vue_root/router';
import store from '../app.store';

export default appApi();

function appApi(){

    return {
        install: install,
    };

    function install(Vue, options){

        const appHttp = axios.create({});

        appHttp.interceptors.response.use(response => response, catchAllResponseFailures);
        appHttp.interceptors.request.use(modifyAllRequestConfigs, error => error);

        Vue.appApi = _appApi;

        function _appApi(){

            return {
                guest: guest,
                authorized: authorized,
            };
            // Vue.appApi().guest()
            function guest(){

                return {
                    user: user,
                };

                // Vue.appApi().guest().user()
                function user(){

                    return {
                        register: register,
                        logout: logout,
                        login: login,
                        forgotPassword: forgotPassword,
                        resetPassword: resetPassword
                    };

                    // Vue.appApi().guest().user().register()
                    function register(payload){
                        return appHttp.put(`/user/register`, payload);
                    }
                    // Vue.appApi().guest().user().login()
                    function login(payload){
                        return appHttp.post(`/user/login`, payload);
                    }
                    // Vue.appApi().guest().user().logout()
                    function logout(){
                        return appHttp.post(`/api/v1/logout`);
                    }
                    // Vue.appApi().guest().user().forgotPassword()
                    function forgotPassword(payload){
                        return appHttp.post(`/user/forgot-password`, payload);
                    }
                    // Vue.appApi().guest().user().resetPassword()
                    function resetPassword(payload){
                        return appHttp.post(`/user/reset`, payload);
                    }
                }
            }
            // Vue.appApi().authorized()
            function authorized(){

                return {
                    getUser: getUser
                };

                // Vue.appApi().authorized().getUser()
                function getUser(){
                    return appHttp.get(`/api/v1/get-user`);
                }
            }
        }
        function modifyAllRequestConfigs(config){

            const access_token = localStorage.getItem('access_token');

            if(access_token !== null){
                config.headers['Authorization'] = 'Bearer ' + access_token;
            }

            return config;
        }
        function catchAllResponseFailures(error){

            var originalRequest = error.config;
            var errorStatusIsUnauthorized = error.response.status === 401;
            var requestHasNotBeenTriedAgain = !originalRequest._triedAgain;

            if(errorStatusIsUnauthorized && requestHasNotBeenTriedAgain){
                originalRequest._triedAgain = true;
                return window.axios.post('/user/login/refresh', null).then(getTokenSuccess).catch(getTokenError);
            }

            if(error.response && error.response.statusText){
                error.response.appMessage = error.response.statusText;
            }

            var errorHasMessageProperty = error.response && error.response.data && error.response.data.message;
            if(errorHasMessageProperty && error.response.data.message !== ''){
                error.response.appMessage += ': ' + error.response.data.message;
            }

            var errorIsValidationError = error.response.status === 422 && error.response.data.errors;
            if(errorIsValidationError){
                error.response.appMessage = 'Validation Error: Check above and try again.';
            }

            return Promise.reject(error.response);

            function getTokenSuccess(response){
                originalRequest.headers['Authorization'] = 'Bearer ' + response.data.access_token;
                localStorage.setItem('access_token', response.data.access_token);
                return window.axios(originalRequest);
            }
            function getTokenError(error){

                var errorIsOauthInvalid = error.response.status === 419;

                if(errorIsOauthInvalid){
                    store.dispatch('user/LOGOUT_FRONTEND').then(logoutSuccess);
                }
                function logoutSuccess(){
                    router.go();
                }
            }
        }
    }
}
