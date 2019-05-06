import axios from 'axios';
import router from 'vue_root/router';
import store from '../app.store';

export default appApi();

function appApi(){

    return {
        install: install,
    };

    function install(Vue, options){

        const appHttp = axios.create({
            baseURL: window.appEnv.baseURL
        });

        let refreshAuthenticationPromise = null;

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
                    getClientEnv
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
                        return appHttp.put(`/v1/user/register`, payload);
                    }
                    // Vue.appApi().guest().user().login()
                    function login(payload){
                        return appHttp.post(`/v1/user/login`, payload);
                    }
                    // Vue.appApi().guest().user().logout()
                    function logout(){
                        return appHttp.post(`/api/v1/logout`);
                    }
                    // Vue.appApi().guest().user().forgotPassword()
                    function forgotPassword(payload){
                        return appHttp.post(`/v1/user/forgot-password`, payload);
                    }
                    // Vue.appApi().guest().user().resetPassword()
                    function resetPassword(payload){
                        return appHttp.post(`/v1/user/reset`, payload);
                    }
                }
                // Vue.appApi().guest().getClientEnv()
                function getClientEnv(){
                    return appHttp.get(`/api/v1/credentials`);
                }
            }
            // Vue.appApi().authorized()
            function authorized(){

                return {
                    user: user,
                    checkAccountAccess: checkAccountAccess,
                };

                function user(){
                    return {
                        store: store,
                        changePassword: changePassword,
                        changeEmail: changeEmail,
                        getUser: getUser
                    };

                    // Vue.appApi().authorized().user().store(payload)
                    function store(payload){
                        return appHttp.put('/api/v1/user/', payload);
                    }

                    // Vue.appApi().authorized().user().changePassword(payload)
                    function changePassword(payload){
                        return appHttp.put(`/api/v1/user/change-password`, payload);
                    }

                    // Vue.appApi().authorized().user().changeEmail(payload)
                    function changeEmail(payload){
                        return appHttp.put(`/api/v1/user/change-email`, payload);
                    }

                    // Vue.appApi().authorized().user().getUser()
                    function getUser(){
                        return appHttp.get(`/api/v1/user`);
                    }
                }

                // Vue.appApi().authorized().checkAccountAccess()
                function checkAccountAccess(){
                    return appHttp.get(`/api/v1/account/test`);
                }
            }
        }
        function modifyAllRequestConfigs(config){

            if(store.state.guest.user.user && store.state.guest.user.user.current_account && store.state.guest.user.user.current_account.id){
                config.headers['current-account-id'] = store.state.guest.user.user.current_account.id;
            }

            return config;
        }
        function catchAllResponseFailures(error){

            var originalRequest = error.config;
            var endpointNotSupported = error.response && error.response.status === 410 && error.response.data && error.response.data.slug === 'endpoint_obsolete';
            if(endpointNotSupported){
                return router.push({ name: 'upgrade-required' });
            }
            var errorStatusIsUnauthorized = error.response && error.response.status === 401;
            var requestHasNotBeenTriedAgain = !originalRequest._triedAgain;

            if(errorStatusIsUnauthorized && requestHasNotBeenTriedAgain){
                originalRequest._triedAgain = true;

                if(!refreshAuthenticationPromise){
                    refreshAuthenticationPromise = Vue.clientStorage.getItem('refresh_token').then(refreshAuthToken);
                }
                return refreshAuthenticationPromise.then(getTokenSuccess).catch(getTokenError);
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

            function refreshAuthToken(refreshToken){
                return appHttp.post('/v1/user/login/refresh', { refreshToken }).then(storeTokens);

                function storeTokens(response){
                    refreshAuthenticationPromise = null;
                    return Promise.all([
                        Vue.clientStorage.setItem('access_token', response.data.access_token),
                        Vue.clientStorage.setItem('refresh_token', response.data.refresh_token)
                    ]).then(returnResponse);
                    function returnResponse(){
                        return response;
                    }
                }
            }

            function getTokenSuccess(response){
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.access_token;
                originalRequest.headers['Authorization'] = 'Bearer ' + response.data.access_token;
                return window.axios(originalRequest);
            }
            function getTokenError(){

                store.dispatch('user/LOGOUT_FRONTEND').then(logoutSuccess);

                function logoutSuccess(){
                    router.go();
                }
            }
        }
    }
}
