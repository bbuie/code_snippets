export default {
    data: data,
    methods: getMethods(),
};

function data(){
    return {
        credentials: {
            email: 'testapp@buink.biz',
        },
        apiErrors: [],
        validationErrors: {},
        requestingResetPasswordEmail: false,
        successMessages: [],
    };
}

function getMethods(){

    return {
        requestResetPasswordEmail: requestResetPasswordEmail,
    };

    function requestResetPasswordEmail(credentials){

        var vm = this;

        vm.requestingResetPasswordEmail = true;
        vm.apiErrors = [];
        vm.validationErrors = {};

        vm.$store.dispatch('user/forgot_password/FORGOT_PASSWORD', credentials).then(handleEmailSent, handleRequestError);

        function handleEmailSent(response){
            vm.requestingResetPasswordEmail = false;
            vm.successMessages.push('Please check your inbox and follow the link provided.');
        }
        function handleRequestError(response){
            vm.apiErrors.push(response.appMessage || response.data.message);
            vm.requestingResetPasswordEmail = false;
            if(response.data.validation_errors){
                vm.validationErrors = response.data.validation_errors;
            }
        }
    }
}
