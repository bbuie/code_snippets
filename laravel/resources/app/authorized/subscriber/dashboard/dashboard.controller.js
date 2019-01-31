export default {
    created: created,
    data: data
};

function created(){
    const vm = this;
    // reload user data to update most_recent_defense
    vm.$store.dispatch('user/GET_USER');
}

function data(){
    return {
        errorMessages: [],
    };
}
