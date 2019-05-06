import register from './register/register.store';
import login from './login/login.store';
import forgot_password from './forgot-password/forgot-password.store';
import reset_password from './reset-password/reset-password.store';

const state = {
    hasAccessToken: 'pending',
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
        LOGOUT_SUCCESS: logoutSuccess,
        GET_USER: getUser,
        REGISTER_USER_SUCCESS: setAuthenticationAndUser,
        REMEMBER_ME: storeUserEmail,
        GET_STORED_ACCESS_TOKEN: getStoredAccessToken
    };

    function sendLogoutRequest({ commit }){
        return Vue.appApi().guest().user().logout().then(logoutSuccess);

        function logoutSuccess(){
            commit('LOGOUT_SUCCESS');
        }
    }
    function logoutFrontend({ commit, dispatch }){
        return dispatch('LOGOUT_SUCCESS');
    }
    function logoutSuccess({ commit }){
        commit('SET_HAS_ACCESS_TOKEN', false);
        delete window.axios.defaults.headers.common['Authorization'];
        return Vue.clientStorage.removeItem('access_token');
    }
    function getUser({ commit }){

        return Vue.appApi().authorized().getUser().then(setUser);

        function setUser(response){
            commit('SET_USER', response.data);
            return Promise.resolve();
        }
    }
    function setAuthenticationAndUser({ commit }, payload){
        const storagePromises = [
            Vue.clientStorage.setItem('access_token', payload.token.access_token),
            Vue.clientStorage.setItem('refresh_token', payload.token.refresh_token),
        ];
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.token.access_token;
        commit('SET_USER', payload.user);
        commit('SET_HAS_ACCESS_TOKEN', true);
        return Promise.all(storagePromises);
    }
    function storeUserEmail(state, payload){
        const promises = [];
        if(payload.remember_me){
            promises.push(Vue.clientStorage.setItem('email', payload.email));
        } else {
            promises.push(Vue.clientStorage.getItem('email').then(removeSavedEmail));
        }
        return Promise.all(promises);
        function removeSavedEmail(storedEmail){
            const removeSavedEmail = storedEmail === payload.email;
            if(removeSavedEmail){
                return Vue.clientStorage.removeItem('email');
            }
        }
    }
    function getStoredAccessToken({ commit }){
        return Vue.clientStorage.getItem('access_token').then(updateState).catch(handleError);
        function updateState(storedToken){
            commit('SET_HAS_ACCESS_TOKEN', (!!storedToken));
        }
        function handleError(caughtError){
            commit('SET_HAS_ACCESS_TOKEN', false);
        }
    }
}

function getMutations(){

    return {
        SET_USER: setUserState,
        SET_CURRENT_ACCOUNT_STATUS: setCurrentAccountStatus,
        SET_HAS_ACCESS_TOKEN: setHasAccessToken
    };

    function setUserState(state, payload){
        state.user = payload.user;
    }
    function setCurrentAccountStatus(state, status){
        state.user.current_account.status = status;
    }
    function setHasAccessToken(state, payload){
        state.hasAccessToken = payload;
    }
}
