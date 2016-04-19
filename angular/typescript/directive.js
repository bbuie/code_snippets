/// <reference path="../../../../typings/main.d.ts" />

module someModule { 
  
	function setup() { 
		//usage: <ss-info-button info="infoObject"></ss-info-button>
		//see Defaults() below for infoObject default options. 
		angular.module('someApp').directive("someDirective", someDirective); 
	};
	function someDirective(): ng.IDirective{

		var someDirective = {
		    restrict: 'E',
		    templateUrl: '/skinsaver/components/info-button/info-button.html',
		    controller: SomeDirectiveController,
		    controllerAs: 'vm',
		    scope: {},
		    link: SomeDirectiveLink,
		};

		return someDirective;
	};
	class SomeDirectiveController{

		static $inject = ['$scope', '$ionicPopup'];

		constructor() {

			var dbugThis = true;
			if(dbugThis){console.log("%ccalled SomeDirectiveController()","color:orange");}
		};
	};
	class SomeDirectiveLink{
		constructor(scope: ng.IScope, element: ng.IAugmentedJQuery, attributes: ng.IAttributes, controller){
			var dbugThis = true;
			if(dbugThis){console.log("%ccalled infoButton.link()","color:orange");}
			if(dbugThis){console.log("%c  scope","color:grey",scope);}
		}
	};
	setup();
}
