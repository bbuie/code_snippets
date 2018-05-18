export default {
    namespaced: true,
    actions: getActions()
};

function getActions(){

    return {
        RESET_PASSWORD: postResetPassword,
    };
    function postResetPassword({ commit }, credentials){

        return Vue.appApi().guest().user().resetPassword(credentials);
    }
}
