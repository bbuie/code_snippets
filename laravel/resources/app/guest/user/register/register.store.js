export default {
    namespaced: true,
    actions: getActions(),
    mutations: getMutations(),
};

function getActions(){

    return {
        REGISTER_USER: registerUser,
    };
    function registerUser({ commit }, credentials){

        return new Promise(registerUserPromise);

        function registerUserPromise(registerUserResolve, registerUserReject){

            Vue.appApi().guest().user().register(credentials).then(registerUserSuccess, registerUserReject);

            function registerUserSuccess(response){

                commit('user/REGISTER_USER_SUCCESS', response.data, { root: true });
                registerUserResolve(response);
            }
        }
    }
}

function getMutations(){

    return {};
}
