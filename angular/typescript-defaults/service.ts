/// <reference path="../../../typings/main.d.ts" />

module someApp  {

    function setup(){
    	angular.module('someApp').service('SomeService', SomeService);
    }

    class SomeService {

        someProperty: any;
        someMethod: () => any;
        
        $inject = [
            'SomeInjection'
        ]; 

        constructor(
            SomeInjection
        ) { 

            this.someProperty = null;
            this.someMethod = someMethod;

            function someMethod() {};
        };
    }
    setup(); 
}



