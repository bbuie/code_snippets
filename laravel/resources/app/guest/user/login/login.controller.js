export default {
    data: data,
    methods: getMethods(),
};

function data(){
    const savedEmail = localStorage.getItem('email');
    return {
        apiErrors: [],
        validationErrors: {},
        credentials: {
            email: savedEmail || 'testApp@buink.biz',
            password: 'buinkinc',
            remember_me: !!savedEmail
        },
        loggingIn: false,
    };
}

function getMethods(){

    return {
        login: login,
    };

    function login(){

        var vm = this;
        vm.apiErrors = [];
        vm.validationErrors = {};
        vm.loggingIn = true;

        vm.$store.dispatch('user/login/LOGIN', vm.credentials).then(getUserSuccess, getUserError);

        function getUserSuccess(response){
            vm.$router.redirectAfterLogin();
        }
        function getUserError(response){
            vm.loggingIn = false;
            if(response.data.validation_errors){
                vm.validationErrors = response.data.validation_errors;
            }
            vm.apiErrors.push('Username or password is incorrect.');
        }
    }
}
