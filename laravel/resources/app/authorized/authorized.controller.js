export default {
    data: data,
    computed: getComputed(),
    methods: getMethods(),
    created: created,
};

function created(){
    const vm = this;
    vm.getUser();
}

function data(){
    return {
        loadingUser: false,
    };
}

function getComputed(){
    return {
        user(){
            return this.$store.state.guest.user.user;
        }
    };
}

function getMethods(){
    return {
        logout: logout,
        getUser: getUser,
    };

    function logout(){
        const vm = this;
        vm.$store.dispatch('user/LOGOUT').then(logoutSuccess);

        function logoutSuccess(){
            vm.$router.go();
        }
    }
    function getUser(){
        const vm = this;
        const userDataLoaded = vm.$store.state.guest.user.user;
        if(!userDataLoaded){
            vm.loadingUser = true;
            loadUserData();
        }
        function loadUserData(){
            vm.$store.dispatch('user/GET_USER').then(doneLoading);

            function doneLoading(){

                vm.loadingUser = false;
            }
        }
    }
}
