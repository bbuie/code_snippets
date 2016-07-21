(function ($, angular) {
  /**
   * @ngdoc service
   * @name someApp.someAppApi
   * @description
   * # someAppApi
   * Factory in someApp.
   */
  angular.module('someApp').factory('someAppApi', someAppApi);

  function someAppApi() {
    'use strict';
    
    var api = {};//object returned from factory
    var apiCache = {};

    api.setup = function(){
      //setup api cache
      apiCache.someCache = null;
    };

    api.someData = function(someDataId){

      var someData = {};
      
      someData.type = function(type){
        var url = '/api/someData/type/' + type +'/';
        var type = $http.get(url);
        return type;
      };
      
      someData.types = function(){

        //return cache if exists
        if(apiCache.someDataTypes){
          return apiCache.someDataTypes; 
        }

        var url = '/api/someData/types/';
        apiCache.someDataTypes = $http.get(url);
        return apiCache.someDataTypes;
      };

      return someData;
    };

    api.setup();

    return api;
  }

  someAppApi.$inject = [
    '$http',
  ];
}(window.jQuery || window.$, window.angular));
