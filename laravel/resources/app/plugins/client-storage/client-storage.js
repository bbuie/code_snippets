import IosStorage from './ios-storage';
import WebStorage from './web-storage';

export default { install };

function install(Vue, options){
    Vue.clientStorage = getMethods();
}

function getMethods(){
    // all clientStorage methods should return Promises
    let methods = null;
    initializeMethods();

    return {
        setItem,
        getItem,
        removeItem,
        clear
    };

    function initializeMethods(){
        const platform = window.appEnv.clientPlatform;
        switch (platform){
            case 'web':
                methods = WebStorage;
                break;
            case 'ios':
                methods = IosStorage;
                break;
            default:
                throw new Error('Device Platform not recognized, client-storage plugin not available for platform: ' + platform);
        }
    }

    function setItem(key, value){
        if(!methods){
            initializeMethods();
        }
        return methods.setItem(key, value);
    }

    function getItem(key){
        if(!methods){
            initializeMethods();
        }
        return methods.getItem(key);
    }

    function removeItem(key){
        if(!methods){
            initializeMethods();
        }
        return methods.removeItem(key);
    }

    function clear(){
        if(!methods){
            initializeMethods();
        }
        return methods.clear();
    }
}