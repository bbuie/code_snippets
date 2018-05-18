export default {
    data: data,
    methods: getMethods(),
    computed: getComputed(),
};

function data(){
    return {
        credentials: {
            name: 'Ben Buie 2',
            email: 'testapp2@buink.biz ',
            password: 'buinkinc',
            password_confirmation: 'buinkinc',
        },
        apiErrors: [],
        validationErrors: {},
        registeringUser: false,
    };
}

function getComputed(){
    return {};
}

function getMethods(){

    return {
        attemptRegisterUser: attemptRegisterUser,
    };

    function attemptRegisterUser(credentials){

        var vm = this;

        vm.registeringUser = true;
        vm.apiErrors = [];
        vm.validationErrors = {};

        if(credentials.password !== vm.credentials.password_confirmation){
            vm.apiErrors.push('Your passwords do not match.');
            vm.registeringUser = false;
            return false;
        }

        vm.$store.dispatch('user/register/REGISTER_USER', credentials).then(registerSuccess, registerError);

        function registerSuccess(response){
            vm.$router.redirectAfterLogin();
            vm.registeringUser = false;
        }
        function registerError(response){
            vm.apiErrors.push(response.appMessage || response.data.message);
            vm.registeringUser = false;
            vm.validationErrors = response.data.errors;
        }
    }
}
