export default {
    data,
    computed: getComputed(),
    created,
    methods: getMethods()
};

function data(){
    return {
        loadingUser: false,
    };
}

function getComputed(){
    return {
        user(){
            const vm = this;
            return vm.$store.state.guest.user.user;
        }
    };
}

function created(){
    const vm = this;
    vm.getUser();
}

function getMethods(){
    return {
        getUser
    };

    function getUser(){
        const vm = this;
        const userDataLoaded = vm.user;

        if(!userDataLoaded){
            vm.loadingUser = true;
            loadUserData();
        }

        function loadUserData(){
            vm.$store.dispatch('user/GET_USER').then(displayView);
            function displayView(){
                vm.loadingUser = false;
            }
        }
    }
}
