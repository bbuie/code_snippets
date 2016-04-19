/// <reference path="../../../../typings/main.d.ts" />

module someModule { 
  
	function setup() { 
		//usage: <some-directive info="infoObject"></some-directive>
		angular.module('someApp').directive("someDirective", someDirective); 
	};
	function someDirective(): ng.IDirective{

		var someDirective = {
		    restrict: 'E',
		    templateUrl: '/somehtml.html',
		    controller: SomeDirectiveController,
		    controllerAs: 'vm',
		    scope: {},
		    link: SomeDirectiveLink,
		};

		return someDirective;
	};
	class SomeDirectiveController{

		static $inject = ['$scope'];

		constructor() {

			var dbugThis = true;
			if(dbugThis){console.log("%ccalled SomeDirectiveController()","color:orange");}
		};
	};
	class SomeDirectiveLink{
		constructor(scope: ng.IScope, element: ng.IAugmentedJQuery, attributes: ng.IAttributes, controller){
			var dbugThis = true;
			if(dbugThis){console.log("%ccalled SomeDirectiveLink()","color:orange");}
		}
	};
	setup();
}
