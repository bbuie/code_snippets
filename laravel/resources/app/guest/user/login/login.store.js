export default {
    namespaced: true,
    actions: getActions(),
    mutations: getMutations(),
};

function getActions(){

    return {
        LOGIN: postLogin,
    };
    function postLogin({ commit }, credentials){

        return new Promise(postLoginPromise);

        function postLoginPromise(postLoginResolve, postLoginReject){

            Vue.appApi().guest().user().login(credentials).then(loginSuccess, loginError);

            function loginSuccess(response){
                commit('user/REMEMBER_ME', credentials, { root: true });
                commit('user/REGISTER_USER_SUCCESS', response.data, { root: true });
                postLoginResolve(response);
            }
            function loginError(error){
                postLoginReject(error);
            }
        }
    }
}

function getMutations(){

    return {};
}
