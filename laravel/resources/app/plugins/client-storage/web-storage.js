export default {
    setItem(key, value){
        return new Promise(function(resolve, reject){
            try {
                localStorage.setItem(key, value);
                resolve();
            } catch(e){
                reject(e);
            }
        });
    },
    getItem(key){
        return new Promise(function(resolve, reject){
            try {
                const value = localStorage.getItem(key);
                resolve(value);
            } catch(e){
                reject(e);
            }
        });
    },
    removeItem(key){
        return new Promise(function(resolve, reject){
            try {
                localStorage.removeItem(key);
                resolve();
            } catch(e){
                reject(e);
            }
        });
    },
    clear(){
        return new Promise(function(resolve, reject){
            try {
                localStorage.clear();
                resolve();
            } catch(e){
                reject(e);
            }
        });
    }
};