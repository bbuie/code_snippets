export default {
    data: data,
    methods: getMethods(),
    computed: getComputed(),
};

function data(){
    return {
        credentials: {
            email: 'testapp@buink.biz',
            password: 'buink111',
            password_confirmation: 'buink111'
        },
        apiErrors: [],
        successMessages: [],
        validationErrors: {},
        requestingPasswordReset: false,
    };
}

function getComputed(){
    return {};
}

function getMethods(){

    return {
        requestPasswordReset: requestPasswordReset,
    };

    function requestPasswordReset(credentials){

        var vm = this;

        vm.requestingPasswordReset = true;
        vm.apiErrors = [];
        vm.validationErrors = {};

        if(credentials.password !== credentials.password_confirmation){
            vm.apiErrors = ['Passwords must match'];
            vm.requestingPasswordReset = false;
            return;
        }

        vm.credentials.token = Object.keys(vm.$route.query)[0];

        vm.$store.dispatch('user/reset_password/RESET_PASSWORD', credentials).then(handleReset, handleRequestError);

        function handleReset(response){
            vm.requestingPasswordReset = false;
            vm.successMessages.push('Your password has been reset.');
        }
        function handleRequestError(response){
            vm.apiErrors.push(response.appMessage);
            vm.requestingPasswordReset = false;
            if(response.data.validation_errors){
                vm.validationErrors = response.data.validation_errors;
            }
        }
    }
}
