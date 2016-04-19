(function ($, angular) {
'use strict';

/**
 * @ngdoc function
 * @name someApp.controller:DefaultController
 * @description
 */
angular.module('someApp')
.controller('DefaultController', function ($scope) {

	var dbugThis = false; var dbugAll = false;
	if(dbugAll||dbugThis){console.log("%ccalled DefaultController()","color:orange");}

	var DefaultController = {}; //private object
	DefaultController.setup = function(){

		//set scope variables here

		DefaultController.viewApi();
		DefaultController.onEvents();
	};
	DefaultController.viewApi = function(){

		//functions to be used in view can be added to $scope here
	};
	DefaultController.onEvents = function(){

		var onSomething = $scope.$on('something', function(e, data){
			//use this to catch broadcasts
		});

		$scope.$on('$destroy', onSomething);
	};
	DefaultController.getSomething = function(companyId, callback){
	
		//var dbugThis = true;
		if(dbugAll||dbugThis){console.log("%ccalled DefaultController.getSomething()","color:orange");}

		var getSomething = {};
		
		getSomething.setup = function(){

			api.then(getSomething.success, getSomething.failure);
		};
		getSomething.success = function(response){

			if(dbugAll||dbugThis){console.log("%ccalled getSomething.success()","color:green", response.data);}

			$scope.addresses = response.data;

			if(typeof callback === "function"){
				callback();
			}
	
			getSomething.finish();
		};
		getSomething.failure = function(response){

			if(dbugAll||dbugThis){console.log("%ccalled getSomething.failure()","color:red", response);}
	
			getSomething.finish();
		};
		getSomething.finish = function(){

			//do something on finish
		};
		getSomething.setup();
	};
	DefaultController.setup();
});
}(window.jQuery || window.$, window.angular));
