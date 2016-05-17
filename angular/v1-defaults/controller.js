(function ($, angular) {
'use strict';

/**
 * @ngdoc function
 * @name someApp.controller:DefaultController
 * @description
 */
angular.module('someApp').controller('DefaultController', DefaultController);

function DefaultController($scope){

	var vm = this;

	function setup(){

		//set scope variables here

		viewApi();
		onEvents();
	};
	function viewApi(){

		//functions to be used in view can be added to $scope here
	};
	function onEvents(){

		var onSomething = $scope.$on('something', function(e, data){
			//use this to catch broadcasts
		});

		$scope.$on('$destroy', onSomething);
	};
	function getSomething(companyId, callback){
		
		function setup(){

			api.then(success, failure);
		};
		function success(response){

			if(dbugAll||dbugThis){console.log("%ccalled success()","color:green", response.data);}

			$scope.addresses = response.data;

			if(typeof callback === "function"){
				callback();
			}
	
			finish();
		};
		function failure(response){

			if(dbugAll||dbugThis){console.log("%ccalled failure()","color:red", response);}
	
			finish();
		};
		function finish(){

			//do something on finish
		};
		setup();
	};
	setup();
}

}(window.jQuery || window.$, window.angular));
