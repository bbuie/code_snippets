/**
 * @ngdoc service
 * @name someApp.someAppApi
 * @description
 * # someAppApi
 * Factory in someApp.
 */
angular.module('someApp')
.factory('someAppApi', function ($http) {
  'use strict';
  
  var someAppApi = {};//object returned from factory
  var apiCache = {};

  someAppApi.setup = function(){
    //setup api cache
    apiCache.someCache = null;
  };

  someAppApi.someData = function(someDataId){

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

  someAppApi.setup();

  return someAppApi;
});
