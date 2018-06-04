import register from './register/register.store';
import login from './login/login.store';
import forgot_password from './forgot-password/forgot-password.store';
import reset_password from './reset-password/reset-password.store';

// initial state
const hasAccessToken = !!localStorage.getItem('access_token');
const state = {
    hasAccessToken: hasAccessToken,
    user: null,
};

export default {
    namespaced: true,
    state,
    mutations: getMutations(),
    actions: getActions(),
    modules: {
        register,
        login,
        forgot_password,
        reset_password
    }
};

function getActions(){

    return {
        LOGOUT: sendLogoutRequest,
        LOGOUT_FRONTEND: logoutFrontend,
        GET_USER: getUser
    };

    function sendLogoutRequest({ commit }){
        return Vue.appApi().guest().user().logout().then(logoutSuccess);

        function logoutSuccess(){
            commit('LOGOUT_SUCCESS');
        }
    }
    function logoutFrontend({ commit }){

        commit('LOGOUT_SUCCESS');
        return Promise.resolve();
    }
    function getUser({ commit }){

        return Vue.appApi().authorized().getUser().then(setUser);

        function setUser(response){
            commit('SET_USER', response.data);
            return Promise.resolve();
        }
    }
}

function getMutations(){

    return {
        REGISTER_USER_SUCCESS: setAuthenticationAndUser,
        LOGOUT_SUCCESS: destroyToken,
        REMEMBER_ME: storeUserEmail,
        SET_USER: setUserState
    };

    function setAuthenticationAndUser(state, payload, other){

        localStorage.setItem('access_token', payload.token.access_token);
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');
        state.user = payload.user;
        state.hasAccessToken = true;
    }
    function destroyToken(router){
        state.hasAccessToken = false;
        localStorage.removeItem('access_token');
        delete window.axios.defaults.headers.common['Authorization'];
    }
    function storeUserEmail(state, payload){
        if(payload.remember_me){
            localStorage.setItem('email', payload.email);
        } else {
            const removeSavedEmail = localStorage.getItem('email') === payload.email;
            if(removeSavedEmail){
                localStorage.removeItem('email');
            }
        }
    }
    function setUserState(state, payload){
        state.user = payload.user;
    }
}
