import Vue from 'vue';
import Vuex from 'vuex';
import guest from './guest/guest.store';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        guest,
    },
    getters: getGetters(),
    strict: debug,
});

function getGetters(){
    return {
        user
    };

    function user(state){
        return state.guest.user.user;
    }
}
