export default {
    namespaced: true,
    actions: getActions()
};

function getActions(){

    return {
        FORGOT_PASSWORD: postForgotPassword,
    };
    function postForgotPassword({ commit }, credentials){

        return Vue.appApi().guest().user().forgotPassword(credentials);

    }
}
