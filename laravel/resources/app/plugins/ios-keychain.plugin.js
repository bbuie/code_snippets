//need to add "cordova-plugin-ios-keychain": "^3.0.1", to package.json file

import { Plugins } from '@capacitor/core';
import router from 'vue_root/router';
import store from 'vue_root/app.store';

export default iosKeychainPlugin();

function iosKeychainPlugin(){
    return {
        install
    };

    function install(Vue, options){
        const { Keychain } = window;
        const { SplashScreen } = Plugins;

        const platform = window.appEnv.clientPlatform;

        Vue.iosKeychainPlugin = {
            storeCredentials,
            removeCredentials,
            loginViaStoredCredentials
        };
        hideSplashscreen().then(loginViaStoredCredentials);

        function loginViaStoredCredentials(){
            return displayIosLoginOverlay().then(fetchCredentialsForIos).then(login).then(continueToApp).catch(logoutIos).finally(hideIosLoginOverlay);

            function fetchCredentialsForIos(){
                return new Promise(authenticateForCredentials);

                function authenticateForCredentials(resolve, reject){
                    const canAccessKeychain = platform === 'ios' && Keychain;
                    if(canAccessKeychain){
                        const touchIdMessage = 'Authenticate to access your DYM account.';
                        Keychain.getJson(resolve, reject, 'dym-credentials', touchIdMessage);
                    } else {
                        reject();
                    }
                }
            }
            function login(credentials){
                if(credentials){
                    return store.dispatch('user/login/LOGIN', credentials);
                } else {
                    return Promise.reject();
                }
            }
            function continueToApp(response){
                const currentRouteRequiresAuth = router.history.current.matched.some(({ meta }) => meta.requiresAuth);
                if(!currentRouteRequiresAuth){
                    return router.push({ name: 'dashboard' });
                }
            }
            function logoutIos(){
                if(platform === 'ios'){
                    return store.dispatch('user/LOGOUT_FRONTEND').then(logoutSuccess);
                }

                function logoutSuccess(){
                    return router.push({ name: 'login' });
                }
            }
            function displayIosLoginOverlay(){
                if(platform === 'ios'){
                    store.commit('SET_SHOW_IOS_OVERLAY', true);
                }
                return Promise.resolve();
            }
            function hideIosLoginOverlay(){
                return new Promise(function(resolve, reject){
                    if(platform === 'ios'){
                        store.commit('SET_SHOW_IOS_OVERLAY', false);
                    }
                    Vue.nextTick(resolve);
                });
            }
        }
        function hideSplashscreen(){
            if(platform === 'ios'){
                return SplashScreen.hide();
            } else {
                return Promise.resolve();
            }
        }
        function storeCredentials(credentials){
            return new Promise(setCredentialsInKeychain);

            function setCredentialsInKeychain(resolve, reject){
                if(platform === 'ios'){
                    const secureCredentialsViaTouchId = true;
                    Keychain.setJson(resolve, reject, 'dym-credentials', credentials, secureCredentialsViaTouchId);
                } else {
                    resolve();
                }
            }
        }
        function removeCredentials(){
            return new Promise(removeCredentialsFromKeychain);

            function removeCredentialsFromKeychain(resolve, reject){
                if(platform === 'ios'){
                    Keychain.remove(resolve, reject, 'dym-credentials');
                } else {
                    resolve();
                }
            }
        }
    }
}