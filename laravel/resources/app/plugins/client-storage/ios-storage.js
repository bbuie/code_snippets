import { Plugins } from '@capacitor/core';
const { Storage } = Plugins;

export default {
    setItem(key, value){
        return Storage.set({ key, value });
    },
    getItem(key){
        return Storage.get({ key }).then(returnValue);
        function returnValue(storedObject){
            return storedObject.value;
        }
    },
    removeItem(key){
        return Storage.remove({ key });
    },
    clear(){
        return Storage.clear();
    }
};