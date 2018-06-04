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
        currentAccount: {},
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
        checkAccountAccess: checkAccountAccess
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
        } else {
            vm.checkAccountAccess();
        }
        function loadUserData(){
            vm.$store.dispatch('user/GET_USER').then(doneLoading);

            function doneLoading(){

                vm.checkAccountAccess();
                vm.loadingUser = false;
            }
        }
    }
    function checkAccountAccess(){
        const vm = this;

        Vue.appApi().authorized().checkAccountAccess().then(handleSuccess).catch(catchError);

        function handleSuccess(response){

            vm.currentAccount = response.data.current_account;
        }
        function catchError(){
            vm.currentAccount = {id: 'not set'};
        }
    }
}
