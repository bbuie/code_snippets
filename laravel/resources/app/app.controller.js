export default {
    created,
    data,
    methods: getMethods()
};

function data(){
    return {
        settingEnv: true,
    };
}

function created(){
    const vm = this;
    if(!window.appEnv.initialized){
        vm.initializeEnv();
    } else {
        vm.settingEnv = false;
    }

}

function getMethods(){
    return {
        initializeEnv
    };

    function initializeEnv(){
        const vm = this;
        vm.settingEnv = true;
        Vue.appApi().guest().getClientEnv().then(addCredentialsToEnv).catch(displayError);

        function addCredentialsToEnv(response){
            window.appEnv = window.appEnv || {};
            Object.keys(response.data).map(key => {
                window.appEnv[key] = response.data[key];
            });
            vm.settingEnv = false;
        }

        function displayError(response){
            vm.settingEnv = false;
        }
    }
}