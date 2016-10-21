(function ($, angular) {'use strict';
/**
 * @ngdoc function
 * @name someApp.controller:DefaultController
 * @description
 */
angular.module('someApp').controller('DefaultController', DefaultController);

function DefaultController(
	$scope,
	$q
){
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
	function getSomething(somethingId){

		return $q(getSomethingPromise);

		function getSomethingPromise(getSomethingResolve, getSomethingReject){
			api.then(getSomethingSuccess, getSomethingError);

			function getSomethingSuccess(response){
				getSomethingResolve(response);
			};
			function getSomethingError(response){
				getSomethingReject(response);
			};
		};
	};
	setup();
}
DefaultController.$inject = [
  '$scope',
  '$q'
];

}(window.jQuery || window.$, window.angular));
